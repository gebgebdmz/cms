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

}

