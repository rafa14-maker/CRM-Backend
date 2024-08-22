<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use App\Models\Query;
use App\Models\QueryItinerary;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queries = Query::with('destination','leadSource','team','client','agent','corporate','package')->get();
        return response()->json($queries,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Query::create($request->all());
        return response()->json('success',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = Query::with('destination','leadSource','team','client','agent','corporate','package')->findOrfail($id);

        // $itinerary = json_decode(Itinerary::first()->destinations)[0];
        // $goaRows = YourModel::whereJsonContains('your_json_column', 'Goa')->get();


        $itinerary = Itinerary::whereJsonContains('destinations',$query->destination->name)->get();
        
        // return response()->json($itinerary,200);

        return response()->json(['query' => $query,'itinerary_suggestions' => $itinerary],200);
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
        Query::where('id',$id)->update($request->all());
        return response()->json('success',200);

        // if(request('package')){
        //     QueryItinerary::create([
        //         'query_id'
        //     ])
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Query::destroy($id);
        return response()->json('success',204);
    }
}
