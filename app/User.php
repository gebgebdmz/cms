<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
//kalo mau matiin verifikasi
// class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'bas_user';
    public $timestamps = false;

    protected $fillable = [
        'username', 'name', 'email', 'password', 'address', 'phone', 'is_active', 'activation_code', 'priv_admin'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'priv_admin' => 'boolean',
    ];


    public function roles()
    {
        return $this->belongsToMany('App\Role', 'bas_user_role', 'user_id', 'role_id');
    }


    // Implements mail verification

    public function sendEmailVerificationNotification()
    {
        // $this->notify(new \App\Notifications\CustomVerifyEmailQueued);
        return redirect('/myprofile');
    }

    public function hasVerifiedEmail()
    {
        // return (($this->is_active)); //($this->activation_code === $this->generateActivationCode()));
        return true; //($this->activation_code === $this->generateActivationCode()));
    }
}
