<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadedForm extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $table = 'uploaded_form';
    protected $fillable = [
        'form_id', 'link'
    ];
}
