<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accomodation;
use App\Models\Accomodimg;
use App\Models\Bank;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;


class AccomodationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Artisan::call('optimize');
        // dd('optimize');
        
        $accomodations = Accomodation::with('destination', 'tariff', 'bank','tariff.roomType','tariff.mealPlan')->get();

        $images = Accomodation::getImage();

        $accomodations->each(function($accomodation,$key) use ($images){
            $accomodation->hotel_img_url = $images->get($key);
        });

        return response()->json($accomodations, 200);
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
            'name' => 'required|unique:accomodations',
            // Add other validation rules as needed
        ]);

        if($validator->fails()){
            return response()->json('name must be unique',422);
        };



        $hotel_img_path = null;
        // return $request;
        // $accomodation = $request->except('hotel_img');
        // $accomodation = Accomodation::create($accomodation);

        // if (request('image')) {
        //     foreach (request('image') as $file) {
        //         $file_name = uniqid() . '_' . time() . '_' . $file->getClientOriginalName();
        //         $file_path = $file->storeAs('accomodations', $file_name, 'public');
        //         Accomodimg::create(['img' => $file_path, 'accomodation_id' => $accomodation->id]);
        //     };
        // }

        if ($file = request('hotel_img')) {
            $file_name = uniqid() . '_' . time() . '_' . $file->getClientOriginalName();
            $hotel_img_path = $file->storeAs('hotels', $file_name, 'public');
        }

        $request_data = $request->all();
        $request_data['hotel_img'] = $hotel_img_path;

        Accomodation::create($request_data);


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
        $accomodation = Accomodation::with('destination', 'tariff', 'bank','tariff.roomType','tariff.mealPlan')->findOrfail($id);
        return response()->json($accomodation, 200);
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
        Accomodation::where('id', $id)->update($request->all());
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
        Accomodation::destroy($id);
        return response()->json('success', 204);
    }

   
}
