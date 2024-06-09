<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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

Route::resource('students', StudentController::class);
Route::get('students/cities/{province_id}', [StudentController::class, 'getCities']);
Route::get('students/districts/{regency_id}', [StudentController::class, 'getDistricts']);
Route::get('students/villages/{district_id}', [StudentController::class, 'getVillages']);