<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    
    return view('welcome');
});
//  Route::get("/about",function(){
//     return view('about');
//  });
 //Route::view("contact",'contact');
// Route::post("user",[UsersController::class,'getData']);
// Route::view("login","user");
// //Route::resource('/user', UserController::class);
// Route::get('/user', [UserController::class, 'index'])->name('user.index');
// Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
// Route::post('/user', [UserController::class, 'store'])->name('user.store');
// Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
// Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
// Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
