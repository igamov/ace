<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('projects', 'ProjectsController');
Route::apiResource('customers', 'CustomerController');
Route::apiResource('priority', 'PriorityController');
Route::apiResource('area_activity', 'AreaActivityController');
Route::apiResource('invoice', 'InvoiceController');
Route::apiResource('nds', 'NdsController');
Route::apiResource('company_detail', 'CompanyDetailController',  ['except' => ['index', 'destroy', 'store']]);
Route::apiResource('notes', 'NoteController');
Route::apiResource('task', 'TaskController');
Route::patch('/tasks/{task}', 'TaskController@updateStatus')->name('task.updateStatus');
Route::put('/tasks/updateAll', 'TaskController@updateAll')->name('task.updateAll');
Route::apiResource('status', 'StatusController');
Route::apiResource('comment', 'CommentController');

Route::get('/users', 'AuthController@index')->name('user.index');
Route::post('/register', 'AuthController@register')->name('user.register');
Route::post('/login', 'AuthController@login')->name('user.login');
Route::post('/logout', 'AuthController@logout')->name('user.logout');