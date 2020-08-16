<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    protected $table = 'bas_email_queue';
    public $timestamps = false;

    protected $fillable = [
        'destination_email', 'email_body', 'email_subject', 'created_at', 'is_processed'
    ];
}
