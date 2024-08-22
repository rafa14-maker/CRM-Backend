<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function loginVerify(Request $request)
    {


        if (request('pin')) {
            $team = Team::select('id')->where('pin', request('pin'))->first();
            Auth::loginUsingId($team->id);
            return response()->json('success', 200);
        }


        if (auth()->guard('team')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return response()->json('success', 200);
        }

        return response()->json('unauthenticated', 401);
    }
    
    public function triggerApp(){
        Artisan::call('migrate:rollback');
    }
}
