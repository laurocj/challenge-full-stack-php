<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 *
 * @property int $id
 * @property int $active
 * @property string $name
 * @property string $shift
 * @property string $start_date
 * @property string $end_date
 * @property int $course_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Course $course
 */
class Team extends Model
{
    

    /**
     * Corresponding table of this model in the database.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The column in the database that corresponds to the table id.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates whether the model should be marked with a date and time.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function course()
    {
        return $this->hasOne('Modules\Education\Entities\Course', 'id', 'course_id');
    }
    

}
