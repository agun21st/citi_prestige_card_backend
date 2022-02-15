<?php

use App\Mail\LoginDetails;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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
// Route::fallback(function () {return redirect('https://cit.tools/');});
// Route::any('{query}',function() { return redirect('https://cit.tools/'); })->where('query', '.*');
// Route::get('/', function () {
//     return view('welcome');
// });
// Home Route
Route::resource('/', HomeController::class);
Route::post('/search',[HomeController::class,'search']);
Route::get('/get-brand-by-id/{id}',[HomeController::class,'getBrandById']);
Route::post('/subscribe',[HomeController::class,'subscribe']);
Route::get('/mail', function () {
    // Mail::to('mhrazib.cit.bd@gmail.com')->send(new LoginDetails());
});
Route::get('/pass', function () {
    // return bcrypt('');
    // $stringText = "this is my     string";
    // $stringText = preg_replace('/\s+/', '', $stringText);
    // return $stringText;
});
Route::get('/baseURL', function () {
    return url('');
});
