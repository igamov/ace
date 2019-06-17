<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index(){
    $users = User::get();
    $admins = $users->filter(function ($user, $key) {
      return $user->role->name == 'admin';
    })->values();
    $managers = $users->filter(function ($user, $key) {
      return $user->role->name == 'manager';
    })->values();
    $developers = $users->filter(function ($user, $key) {
      return $user->role->name == 'developer';
    })->values();
    $customers = $users->filter(function ($user, $key) {
      return $user->role->name == 'customer';
    })->values();
    return response()->json([
      'users' => $users->toArray(),
      'managers' => $managers,
      'admins' => $admins,
      'developers' => $developers,
      'customers' => $customers
    ]);
  }
  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::findOrFail($id);
//    $task->project = $task->project()->with('customer')->get()[0];
//    $task->comments = $task->comments()->orderBy('created_at', 'desc')->get();
    $user->load('role');
    if ($user->role->name == 'manager') {
      $user->projects = $user->manager_projects()->with('priority')->with('customer')->get();
      $user->customers = $user->manager_customers()->get();
    }
    if ($user->role->name == 'customer') {
      $user->customers = $user->spoke_customers()->get();
    }
    return response()->json($user);
  }
}
