<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Menu;

class App extends Model
{
    protected $table = 'bas_app';
    public $timestamps = false;
    protected $fillable = ['id','app_name','app_type','description','menu_name','menu_url'];

    public function apps()
    {
        return $this->belongsToMany('App\Role','bas_role_app','app_name','role_id')
        ->withPivot('priv_access','priv_insert','priv_delete','priv_update','priv_export','priv_print');
    }

    public function menu(){
        return $this->belongsToMany(Menu::class,'app_name');
    }
    
}
