<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Enrollment
 *
 * @property int $id
 * @property int $active
 * @property string $date
 * @property int $team_id
 * @property int $student_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Student $student
 * @property Team $team
 */
class Enrollment extends Model
{
    

    /**
     * Corresponding table of this model in the database.
     *
     * @var string
     */
    protected $table = 'enrollments';

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
    public function student()
    {
        return $this->hasOne('Modules\Education\Entities\Student', 'id', 'student_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function team()
    {
        return $this->hasOne('Modules\Education\Entities\Team', 'id', 'team_id');
    }
    

}
