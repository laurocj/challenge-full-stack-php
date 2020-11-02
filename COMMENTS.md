Decisão da arquitetura utilizada
===================
 - Utilizei o framework [Laravel](https://laravel.com/) por ser o mais popular e conter uma boa gama de plugins, isso garante uma maior "durabilidade" no core da aplicação além de uma rápida solução para bugs. 
 - Modularizei a aplicação com o auxilio do [Laravel-modules](https://nwidart.com/laravel-modules/v6/introduction) para ter "partes" do código que possam ser reutilizadas.
 - Fiquei como banco de dados [MySQL] (https://www.mysql.com/) por já ter ele instalado no pc, mas o uso framework Laravel garante uma fácil troca para outro.
 - Implemente meu CmsController com metodos que isolam as chamadas ao métodos nativos do laravel, assim como um GenericRepository com a mesma intenção, assim posso trocar o framework caso seja necessário.
 - Fiz o uso de Services para isolar a regra de negócio.
 - Adicionei um comando ao Artisan para a criação do CRUD inicial para um desenvolvimento, para sua utilização tense que ter uma tabela com as colunas já definidas e um módulo na pasta Modules então:
   - php artisan module:make Setting - Cria o módulo 'Settind' na pasta Modules
   - php artisan module:make-migration create_menus_table Setting - Cria uma migration no modulo Setting (defina suas colunas para a tabela)
   - php artisan module:migrate - Executa suas migrations 
   - php artisan generator:make-crud menus Setting - A estrutura inicial com Controller, Model, Views (index, edit, create), Service e Repository serão criados.


Lista de bibliotecas de terceiros utilizadas
===================

PHP
laravel/ui
lucascudo/laravel-pt-br-localization
nwidart/laravel-modules
mockery
phpunit

JS
fontawesome
jquery-mask-plugin
select2
ttskch/select2-bootstrap4-theme

O que você melhoraria se tivesse mais tempo
===================
 - Mais testes.
 - Um sistema de ACL por rotas.

Quais requisitos obrigatórios que não foram entregues
===================
