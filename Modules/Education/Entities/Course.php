<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 */
class Course extends Model
{
    

    /**
     * Corresponding table of this model in the database.
     *
     * @var string
     */
    protected $table = 'courses';

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



}
