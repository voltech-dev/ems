<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/Project/projectlist', [App\Http\Controllers\EmpDetailsController::class, 'projectlist']);
Route::get('/projectdata', [App\Http\Controllers\EmpDetailsController::class, 'projectdata']);
Route::get('/Project/projectcreation', [App\Http\Controllers\EmpDetailsController::class, 'projectcreation']);
Route::post('/Project/projectstore', [App\Http\Controllers\EmpDetailsController::class, 'projectstore']);
Route::get('/Project/projectedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'projectedit']);
Route::post('/Project/projectupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'projectupdate']);

Route::get('/Project/statuslist', [App\Http\Controllers\EmpDetailsController::class, 'statuslist']);
Route::get('/statusdata', [App\Http\Controllers\EmpDetailsController::class, 'statusdata']);
Route::get('/Project/statuscreation', [App\Http\Controllers\EmpDetailsController::class, 'statuscreation']);
Route::post('/Project/statusstore', [App\Http\Controllers\EmpDetailsController::class, 'statusstore']);
Route::get('/Project/statusedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'statusedit']);
Route::post('/Project/statusupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'statusupdate']);

Route::get('/Project/authoritylist', [App\Http\Controllers\EmpDetailsController::class, 'authoritylist']);
Route::get('/authoritydata', [App\Http\Controllers\EmpDetailsController::class, 'authoritydata']);
Route::get('/Project/authoritycreation', [App\Http\Controllers\EmpDetailsController::class, 'authoritycreation']);
Route::post('/Project/authoritystore', [App\Http\Controllers\EmpDetailsController::class, 'authoritystore']);
Route::get('/Project/authorityedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'authorityedit']);
Route::post('/Project/authorityupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'authorityupdate']);

Route::get('/Location/locationlist', [App\Http\Controllers\EmpDetailsController::class, 'locationlist']);
Route::get('/locationdata', [App\Http\Controllers\EmpDetailsController::class, 'locationdata']);
Route::get('/Location/locationcreation', [App\Http\Controllers\EmpDetailsController::class, 'locationcreation']);
Route::post('/Location/locationstore', [App\Http\Controllers\EmpDetailsController::class, 'locationstore']);
Route::get('/Location/locationedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'locationedit']);
Route::post('/Location/locationupdate/{id}', [App\Http\Controllers\EmpDetailsController::class, 'locationupdate']);


Route::get('/EmpDetails/remuneration/{id}', [App\Http\Controllers\EmpDetailsController::class, 'remuneration']);
Route::get('/EmpDetails/remunerationedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'remunerationedit']);
Route::get('/salarystructure', [App\Http\Controllers\EmpDetailsController::class, 'salarystructure']);
Route::post('/EmpDetails/remunerationstore', [App\Http\Controllers\EmpDetailsController::class, 'remunerationstore']);
Route::post('/EmpDetails/remunerationeditstore', [App\Http\Controllers\EmpDetailsController::class, 'remunerationeditstore']);
Route::get('/EmpDetails/statutory/{id}', [App\Http\Controllers\EmpDetailsController::class, 'statutory']);
Route::get('/EmpDetails/statutoryedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'statutoryedit']);
Route::get('/EmpDetails/bank/{id}', [App\Http\Controllers\EmpDetailsController::class, 'bank']);
Route::post('/EmpDetails/bankstore', [App\Http\Controllers\EmpDetailsController::class, 'bankstore']);
Route::get('/EmpDetails/bankedit/{id}', [App\Http\Controllers\EmpDetailsController::class, 'bankedit']);
Route::post('/EmpDetails/bankeditstore', [App\Http\Controllers\EmpDetailsController::class, 'bankeditstore']);
Route::post('/EmpDetails/statutorystore', [App\Http\Controllers\EmpDetailsController::class, 'statutorystore']);
Route::post('/EmpDetails/statutoryeditstore', [App\Http\Controllers\EmpDetailsController::class, 'statutoryeditstore']);

Route::get('/viewdata', [App\Http\Controllers\EmpDetailsController::class, 'viewdata']);
Route::get('/EmpDetails/empview/{id}', [App\Http\Controllers\EmpDetailsController::class, 'empview']);
Route::resource('/EmpDetails', 'App\Http\Controllers\EmpDetailsController');
