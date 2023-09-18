<?php

namespace App\Http\Controllers;


// app/Http/Controllers/UserController.php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\EmailRule;
use Illuminate\View\View;

class UserController extends Controller
{   
    public function index()
    {
        $user = User::all(); 
    
        return view('user.index', compact('user')); // Use compact() to pass the variable to the view
    }
    
      public function login(Request $req)
    {   
        $credentials= $req->validate([
            'password'=>'required | min:5',
            'email' => ['required', new EmailRule()],
        ]);
         return $req->input();
    
        $user = User::where('email', $req->email)->first(); //jeble awal user l 3ndo he email first()
        if(!Hash::check($req->password, $user->password)){
        return 'cannot login';
    }
    $token=$user->createToken($user->name);
    return response()->json(['token'=>$token->plainTextToken,'user' => $user]);
    
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
    public function store(Request $req) {
        $user = new User;
        $user->name = $credentials['name'];
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();
        return redirect()->route('user.index')->with('success', 'User created successfully!');
    }
    public function update(Request $request, $id)
    {
        $user=User::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }
        $user->update($req->only(['name', 'email']));
        //update pass
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }
return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }
    public function show($id){
        $user=User::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }
        return view('user.show',['user' => $user]);
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully!'); //redirect is like pointer to tell ur browser to go to the right place
    }

}


