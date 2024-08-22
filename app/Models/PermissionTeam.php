<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionTeam extends Model
{
    use HasFactory;

    protected $guraded=[];

    public function permissionDetail(){
        return $this->belongsTo(Permission::class,'permission_id','id');
    }
}
