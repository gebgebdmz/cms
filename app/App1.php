<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Menu;

class App extends Model
{
    protected $table = 'bas_app';
    public $timestamps = false;
    protected $fillable = ['id','app_name','app_type','description','menu_name','menu_url','menu_parent_id'];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'bas_role_app','role_id','app_id');
    }
    public function menu(){
        return $this->belongsToMany(Menu::class,'app_name');
    }
    // public function apps()
    // {
    // return $this->belongsToMany(App::class,'bas_role_app','role_id','app_id');
    // }
}
