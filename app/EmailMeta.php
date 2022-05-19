<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailMeta extends Model
{
    protected $table = 'email_tickets_meta';
    protected $fillable = [
        'ticket_id ', 'meta_state ', 'meta_type', 'meta_sub_type'
    ];
}
