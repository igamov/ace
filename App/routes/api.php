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
Route::get('/tasks', 'TaskController@all')->name('tasks.all');
Route::patch('/tasks/{task}', 'TaskController@updateStatus')->name('task.updateStatus');
Route::put('/tasks/updateAll', 'TaskController@updateAll')->name('task.updateAll');
Route::apiResource('status', 'StatusController');
Route::apiResource('comment', 'CommentController');
Route::get('/user_roles', 'UserRolesController@index')->name('user_roles.index');


Route::get('/users', 'UserController@index')->name('user.index');
Route::get('/users/{id}', 'UserController@show')->name('user.show');
Route::post('/users/edit_profile', 'AuthController@editProfile')->name('user.editProfile');
Route::post('/users/update_profile', 'AuthController@updateProfile')->name('user.updateProfile');
Route::post('/register', 'AuthController@register')->name('user.register');
Route::post('/login', 'AuthController@login')->name('user.login');
Route::post('/logout', 'AuthController@logout')->name('user.logout');