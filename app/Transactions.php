<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $table = 'transaction';
    protected $fillable = [
        'user_id ', 'transaction_type_id ', 'status', 'start_datetime', 'end_datetime', 'total_tat', 'remarks'
    ];

    
}