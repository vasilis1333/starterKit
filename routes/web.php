<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');


//Language Translation
//Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);


/*
 |--------------------------------------------------------------------------
 | User Routes
 |--------------------------------------------------------------------------
 */
Route::post('users/activate/{user}',[UserController::class,'toggle_is_active'])->name('users.activate');
Route::post('users/datatables',[UserController::class,'datatables'])->name('users.datatables');
Route::resource('admin/users', UserController::class);
