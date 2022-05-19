<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emailtickets extends Model
{
    protected $table = 'email_tickets';
    protected $fillable = [
        'ticket_code ', 'age ', 'create_dt', 'close_dt', 'state', 'queue', 'is_lock', 'upload_id'
    ];
}
