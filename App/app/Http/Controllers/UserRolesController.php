<?php

namespace App\Http\Controllers;

use App\UserRoles;
use Illuminate\Http\Request;


class UserRolesController extends Controller
{
  public function index()
  {
    $user_roles = UserRoles::all();

    return response()->json([
      'user_roles' => $user_roles->toArray()
    ]);
  }
}
