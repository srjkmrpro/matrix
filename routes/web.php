<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\RestController;
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

Route::get('/', [CrudController::class, 'index']);

Route::post('/ImageUpload', [CrudController::class, 'upload']);

Route::post('/Save', [CrudController::class, 'Save']);
Route::post('/Edit', [CrudController::class, 'Edit']);
Route::get("/GetAll", [CrudController::class, "GetAll"]);
Route::post("/Delete", [CrudController::class, "Delete"]);
