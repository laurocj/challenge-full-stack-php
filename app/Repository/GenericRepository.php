<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

trait GenericRepository
{

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    public $query;

    /**
     * https://laravel.com/docs/7.x/eloquent#retrieving-models
     *
     * @param Array $columns
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*']): Collection
    {
        return $this->query->get($columns);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return boolean
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     *  https://laravel.com/docs/7.x/eloquent#retrieving-single-models
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id)
    {
        return $this->query->find($id);
    }

    /**
     * Retorna uma list que pode ser usado em um select deve ser passado o nome da coluna que será apresentada
     *
     * @param  string  $value
     * @param  string|null  $key
     * @param  int|string $limit
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function lists($columns, $glue = " ", $limit = 10, $key = null)
    {
        if (is_null($key)) {
            $key = $this->getPrimaryKey();
        }

        $columns = is_array($columns) ? $columns : [$columns];
        $select = $columns;
        $select[] = $key;
        $this->query->select($select)->whereNotNull($columns);

        if (is_numeric($limit)) {
            $this->query->limit($limit);
        }

        foreach ($columns as $column) {
            $this->query->where($column, '<>', '')->orderBy($column);
        }

        $collection = $this->query
            ->get()
            ->mapWithKeys(function ($item) use ($key, $glue, $columns) {
                return [$item->{$key} => implode($glue, $item->only($columns))];
            });

        return $collection;
    }

    /**
     * https://laravel.com/docs/5.8/pagination#paginating-eloquent-results
     *
     * @param int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        $key = $this->getPrimaryKey();
        return $this->query->orderBy($key, 'DESC')->paginate($perPage);
    }

    /**
     * Uma forma de pesquisa nas tabelas
     * Envie um array com as tabelas onde se quer procurar e por último o campo
     *
     * @param Int $perPage
     * @param Array $fieldsForResearch ['turma.curso.Denominacao' => 'Capacitação', 'instrutor.nm_candidato' => "Pedro"];
     * @param String|null $orderBy coluna
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function search(int $perPage = 10, array $fieldsForResearch, $orderBy = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        foreach ($fieldsForResearch as $field => $keyword) {
            $this->compileQuerySearch($this->query,$field, $keyword);
        }

        if (!is_null($orderBy)) {
            $this->compileQueryOrderBy($this->query, $orderBy, 'ASC');
        }

        return $this->query->paginate($perPage);
    }

    /**
     * Compila a cláusula pelos relacionamentos do model.
     *
     * @param mixed  $query
     * @param string $column
     * @param string $direction
     */
    public function compileQueryOrderBy($query, $column, $direction = 'ASC')
    {
        $alias = $this->resolveColumn($query,$column);

        $query->orderBy( $alias, $direction);
    }

    /**
     * Recebendo uma string que representa um alias de columa curso.nome
     * retorna esse alias resolvido para o nome da tabela e o nome da column
     *
     * @param mixed $query
     * @param string column
     *
     * @return string
     */
    private function resolveColumn($query, $column)
    {
        $model = $query->getModel();
        list($relationship, $column) = $this->explodeField($column);

        if(is_null($relationship)) {
            return $model->getTable() .'.'. $column;
        } else {
            $relationship = $model->{ucfirst($relationship)}();
            $nextQuery = $relationship->getQuery();

            //guarda a consulta inicial
            if(!isset($this->baseQuery)) {
                $this->baseQuery = $query;
            }
            $this->addJoin($relationship);

            return $this->resolveColumn($nextQuery, $column);
        }
    }

    /**
     * Adiciona um join a consulta
     * @param Illuminate\Database\Eloquent\Relations $relationship
     */
    private function addJoin($relationship)
    {
        $table = $relationship->getModel()->getTable();
        $foreign = $relationship->getQualifiedForeignKeyName();
        if($relationship instanceof HasOneOrMany) {
            $other = $relationship->getQualifiedParentKeyName();
        } else if($relationship instanceof BelongsTo) {
            $other = $relationship->getQualifiedOwnerKeyName();
        }

        $this->baseQuery->join($table, $foreign, '=', $other, 'left');
    }

    /**
     * Compila a cláusula pelos relacionamentos do model.
     *
     * @param mixed  $query
     * @param string $column
     * @param string $keyword
     * @param string $boolean
     */
    public function compileQuerySearch($query, $column, $keyword, $boolean = 'or')
    {
        list($relationship, $column) = $this->explodeField($column);

        if(is_null($relationship)) {
            $this->whereClaule($query, $column, $keyword, $boolean);
        } else {
            $query->{$boolean . 'WhereHas'}($relationship, function ($query) use ($column, $keyword) {
                $this->compileQuerySearch($query,$column, $keyword,'');
            });
        }
    }

    /**
     * Compila a cláusula where de consultas.
     *
     * @param mixed  $query
     * @param string $column
     * @param string $keyword
     * @param string $boolean
     */
    protected function whereClaule($query,$column,$keyword, $boolean) {
        $query->{$boolean . 'Where'}($query->getModel()->getTable() . "." . $column, 'LIKE', '%' . $keyword . '%');
    }

    /**
     * Quebra a string em relacionamento e coluna
     *
     * @param $field string
     * @return array
     */
    protected function explodeField($field) {
        if (strpos($field, '.') !== false) {
            return explode('.',$field,2);
        }

        return [null,$field];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param Array $attributes
     *
     * @return boolean
     */
    public function save(Model &$model): bool
    {
        return $model->save();
    }

    /**
     * Obtem a string que correponde a primary key da tabela
     *
     * @return string
     */
    private function getPrimaryKey()
    {
        return $this->query->getModel()->getKeyName();
    }
}
