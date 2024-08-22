<?php

namespace App\Http\Controllers\Crm\Accomodation;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        $tariffs = Tarif::with('roomType','mealPlan')->get();
        return response()->json($tariffs, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Tarif::create($request->all());
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
        $tarif = Tarif::with('roomType','mealPlan')->findOrFail($id);
        return response()->json($tarif,200);

    }

    /**
     * Update the specified resource in storage.
     *
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Tarif::where('id',$id)->update($request->all());
        return response()->json('success',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tarif::destroy($id);
        return response()->json('success',204);

    }
}
