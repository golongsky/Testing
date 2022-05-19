<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $table = 'goal';
    protected $fillable = [
        'coaching_id', 'title', 'start_date', 'end_date', 'created_by', 'updated_by', 'description', 'is_active'
    ];
}
