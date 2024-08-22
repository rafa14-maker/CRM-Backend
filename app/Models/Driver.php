<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function vehicle(){
        return $this->belongsTo(Transfer::class,'transfer_id','id');
    }

    public static function getImages(){
        $drivers = self::all();
        // Map through each driver and retrieve its image
        return $drivers->mapWithKeys(function ($driver) {
            return [
                $driver->id => [
                    'driver_img'=> $driver->driver_img ? asset('storage/'.$driver->driver_img): asset('storage/drivers/driver_img.jpg'),
                    'veh_img' => $driver->veh_img ? asset('storage/'.$driver->veh_img) : asset('storage/vehicles/veh_img.jpg'),
                    'driver_id_card' => $driver->driver_id_card ? asset('storage/'.$driver->driver_id_card) : asset('storage/drivers_card/id_card.jpg') ,
                    'license_copy' => $driver->license_copy ? asset('storage/'.$driver->license_copy) : asset('storage/drivers_license/license.jpg')
                ]
            ];  // Assuming 'image' is the column name for the image URL
        })->toArray();
    }
        // return 
        
}
