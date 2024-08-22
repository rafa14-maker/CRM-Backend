<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Authenticatable
{
    use HasFactory;    

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'pin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function role(){
    //     return $this->belongsTo(Role::class,'role_id','id');
    // }

    public function permission(){
        return $this->hasMany(PermissionTeam::class,'team_id','id');
    }

}
