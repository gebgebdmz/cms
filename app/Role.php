<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Menu;

class Role extends Model
{
    //
    public $timestamps = false;
    protected $table = 'bas_role';
    protected $fillable = ['name','remark'];

    public function users()
    {
        return $this->belongsToMany('App\User','bas_user_role','role_id','user_id');
    }

    public function apps()
    {
        return $this->belongsToMany('App\App','bas_role_app','role_id','app_name','id','app_name')
        ->withPivot('priv_access','priv_insert','priv_delete','priv_update','priv_export','priv_print');
    }
   

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
