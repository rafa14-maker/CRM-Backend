<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Driver::with('vehicle')->get();

        $images =  Driver::getImages();

        $drivers->each(function ($driver) use ($images) {
            $driver->driver_img_url = $images[$driver->id]['driver_img'] ?? null; // Assuming the key corresponds to the order in which drivers were retrieved
            $driver->veh_img_url = $images[$driver->id]['veh_img'] ?? null;
            $driver->driver_id_card_url = $images[$driver->id]['driver_id_card'] ?? null;
            $driver->license_copy_url = $images[$driver->id]['license_copy'] ?? null;
        });

        // $drivers = Driver::with('vehicle')->get();
        return response()->json($drivers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'veh_no' => 'required|unique:drivers',
            // Add other validation rules as needed
        ]);

        if($validator->fails()){
            return response()->json('vehicle number must be unique',422);
        };

        // return $request;
        $veh_img_path = null;
        $driver_img_path = null;
        $driver_card = null;
        $driver_license = null;

        if ($file = request('veh_img')) {

            $file_name = uniqid() . '_' . time() . '_' . $file->getClientOriginalName();
            $veh_img_path = $file->storeAs('vehicles', $file_name, 'public');
        }

        if ($file = request('driver_img')) {

            $file_name = uniqid() . '_' . time() . '_' . $file->getClientOriginalName();
            $driver_img_path = $file->storeAs('drivers', $file_name, 'public');
        }

        if ($file = request('driver_id_card')) {

            $file_name = uniqid() . '_' . time() . '_' . $file->getClientOriginalName();
            $driver_card = $file->storeAs('drivers_card', $file_name, 'public');
        }

        if ($file = request('license_copy')) {

            $file_name = uniqid() . '_' . time() . '_' . $file->getClientOriginalName();
            $driver_license = $file->storeAs('drivers_license', $file_name, 'public');
        }

        $request_data = $request->all();
        $request_data['veh_img'] = $veh_img_path;
        $request_data['driver_img'] = $driver_img_path;
        $request_data['driver_id_card'] = $driver_card;
        $request_data['license_copy'] = $driver_license;

        // return $request_data;

        Driver::create($request_data);
        return response()->json('success', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::findOrfail($id);
        return response()->json($driver, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Driver::where('id', $id)->update($request->all());
        return response()->json('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Driver::destroy($id);
        return response()->json('success', 204);
    }
}
