<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleApp extends Model
{
    //
    public $timestamps = false;
    protected $table = 'bas_role_app';
    protected $fillable = ['role_id','app_id','app_name'];

    public function roles()
    {
        return $this->belongsToMany('App\Role','bas_role_app','app_name','role_id')
        ->withPivot('priv_access','priv_insert','priv_delete','priv_update','priv_export','priv_print');
    }

    public function apps()
    {
        return $this->belongsToMany('App\App','bas_role_app','role_id','app_name','id','app_name')
        ->withPivot('priv_access','priv_insert','priv_delete','priv_update','priv_export','priv_print');
    }
}
