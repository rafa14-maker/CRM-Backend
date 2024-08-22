<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roomType(){
        return $this->belongsTo(RoomType::class,'room_type_id','id');
    }

    public function mealPlan(){
        return $this->belongsTo(MealPlan::class,'meal_plan_id','id');
    }
    
}
