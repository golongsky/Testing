<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoachingForm extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $table = 'coaching_form';
    protected $fillable = [
        'form_name', 'form_created_by', 'form_type', 'form_control_id', 'form_description'
    ];
}
