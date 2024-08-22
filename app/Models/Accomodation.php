<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function destination(){
        return $this->belongsTo(Destination::class,'destination_id','id');
    }

    // public function images(){
    //     return $this->hasMany(Accomodimg::class,'accomodation_id','id');
    // }

    public function tariff(){
        return $this->hasMany(Tarif::class,'accomodation_id','id');
    }

    public function bank(){
        return $this->hasOne(Bank::class,'accomodation_id','id');
    }
 
    public static function getImage(){
        $hotels = self::all();
        return $hotels->map(function($hotel){
            return $hotel->hotel_img ? asset('storage/'.$hotel->hotel_img):asset('storage/hotels/hotel_img.jpg');
        });
    }
}
