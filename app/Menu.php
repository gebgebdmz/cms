<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\App;

class Menu extends Model
{
    protected $table = 'bas_menu';
    public $timestamps = false;
    // protected $primaryKey ='id';
    protected $fillable = ['app_name',
                           'parent_menu_id',
                           'role_id'];
    
    public function role()
    {
        return $this->belongsToMany(Role::class);
        
    }
    public function children(){
        $role_menu = Auth::user()->role->access;
        $role_menu_arr =array();
        foreach ($role_menu as $item) {
            $role_menu_arr[]=$item->id;
        }
        return $this->hasMany(Menu::class,'app_name')
                    ->where("role_id",$role_menu_arr);
   
    }

}

