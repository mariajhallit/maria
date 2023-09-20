<?php

namespace App\Http\Controllers;


// app/Http/Controllers/UserController.php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\EmailRule;
use Illuminate\View\View;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{   
    public function index()
    {
        $users = QueryBuilder::for(User::class)
        ->allowedFilters(['name', 'email'])
        ->allowedSorts(['name', 'email', 'created_at'])
        ->defaultSort('email') 
        ->paginate()
        ->appends(request()->query()); //the website remembers your filter (size 10) and sorting (low to high). So even on the next page, you still see size 10 shoes sorted by price. It's like the website saying, "Oh, you wanted size 10 and low to high? Got it!"
       //This way, you don't have to reselect your options when you go to the next page.
        // $users = User::all();
    
        return response()->json(['users' => $users], 200);
    }
    
    
      public function login(Request $request)
    {   
        $data= $request->validate([
            'password'=>'required | min:5',
            'email' => ['required'],
        ]);
        //  $data=$request->input();
    
        $user = User::where('email', $data['email'])->first(); //jeble awal user l 3ndo he email first()
        if(!Hash::check($data['password'], $user->password)){
        return 'cannot login';
    }
    $token=$user->createToken($user->name);
    return response()->json(['token'=>$token->plainTextToken,'user' => $user]);
    
}

    
    public function logout(Request $request) 
    {
        if($request->user()->tokens()->delete()){
            return response()->json([
                'message'=>'Logout Successfully'
            ],200);
        } else
        return response()->json([
            'message'=>'error'
        ],500);
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email'],
            'password' => 'required|min:5',
        ]);
    
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : null,
        ]);
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', new EmailRule],
        'password' => 'required|min:5',
    ]);

    $user = User::find($id);
    if (!$user) {
        return response()->json(['error' => 'User not found.'], 404);
    }


    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    

    
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
       
    }
    $user->save();
    return response()->json(['message' => 'User updated successfully.'], 200);
}

    public function show($id){
        $user=User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        return response()->json(['message' => 'User show  successfully.'], 200);
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.'], 200);

}
}

