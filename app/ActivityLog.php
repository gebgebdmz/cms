<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;
    protected $table = 'bas_activitylog';
    protected $fillable = [
        'id',
        'inserted_date',
        'username',
        'application',
        'creator',
        'ip_user',
        'action',
        'description',
        'user_agent',
        'created_at',
        'updated_at'
    ];
}
