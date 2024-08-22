<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionTeam;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::with('permission','permission.permissionDetail')->get();
        return response()->json($teams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * input 'f_n' , 'l_n','email','role_id'
     */
    public function store(Request $request)
    {
        $request->merge(['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        $team =    Team::create($request->all());

        if (request('permission')) {
            foreach (request('permisson') as $item) {
                PermissionTeam::create(['permission_id' => $item->id, 'team_id' => $team->id]);
            }            
        }

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
        $team = Team::with('permission')->findOrFail($id);
        return response()->json($team, 200);
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
        Team::where('id', $id)->update($request->all());
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
        Team::destroy($id);
        return response()->json('success', 204);
    }
}
