<?php

namespace App\Http\Controllers;

// app/Http/Controllers/UserController.php

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login()
    {
        $user = User::all();
        return response()->json(['user' => $user]);
    }
    public function logout(Request $req) 
    {
        if($req->user()->tokens()->delete()){
            return response()->json([
                'message'=>'Logout Successfully'
            ],200);
        } else
        return response()->json([
            'message'=>'error'
        ],500);
    }

    }



