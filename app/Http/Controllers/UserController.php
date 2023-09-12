<?php

namespace App\Http\Controllers;

// app/Http/Controllers/UserController.php

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }
}

