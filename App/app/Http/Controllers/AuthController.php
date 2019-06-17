<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

class AuthController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api')
      ->only('logout', 'editProfile', 'updateProfile');
  }

  public function register(Request $request)
  {
    $this->validate($request, [
      'last_name' => 'required|max:255',
      'first_name' => 'required|max:255',
      'patronymic' => 'required|max:255',
      'email' => 'required|email|unique:users',
      'role_id' => '',
      'password' => 'required|between:6,25|confirmed',
    ]);
    $user = new User($request->all());
    $user->photo = '/users/nopic.png';
    $user->password = bcrypt($request->password);
    $user->save();
    return response()->json([
      'success' => true
    ]);
  }

  public function login(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required|between:6,25'
    ]);
    $user = User::whereEmail($request->email)->first();
    if ($user && Hash::check($request->password, $user->password)) {
      $user->api_token = str_random(60);
      $user->save();
      return response()->json([
        'user' => $user->info()
      ]);
    }
    return response()->json([
      'message' => 'Неверный Email или пароль',
      'errors' => [
        'email' => ['Неверный Email или пароль'],
        'password' => ['Неверный Email или пароль'],
      ]
    ], 422);
  }

  public function logout(Request $request)
  {
    $user = $request->user();
    $user->api_token = null;
    $user->save();
    return response()->json([
      'success' => true
    ]);
  }

  public function editProfile(Request $request)
  {
    $user = $request->user();
    if ($user) {
      return response()->json([
        'success' => true,
        'user' => $user->info()
      ]);
    }
    return response()->json(['success' => false]);
  }

  public function updateProfile(Request $request)
  {
    $user = $request->user();

    switch ($request->action) {
      case 'photo':
        $file = $request->profilephoto;
        $ext = $file->getClientOriginalExtension();
        $filename = str_random(30);
        $file->move('users', $filename);
        $user->photo = '/users/' . $filename;
        $user->save();
        return response()->json([
          'success' => true,
          'user' => $user->info()
        ]);
        break;
      case 'profile':
        $this->validate($request, [
          'last_name' => 'required|max:255',
          'first_name' => 'required|max:255',
          'patronymic' => 'required|max:255',
        ]);
        if ($user) {
          $user->last_name = $request->last_name;
          $user->first_name = $request->first_name;
          $user->patronymic = $request->patronymic;
          $user->email = $request->email;
          $user->save();

          return response()->json([
            'success' => true,
            'user' => $user->info()
          ]);
        }
        break;
      case 'password':
        $this->validate($request, [
          'old_password' => 'required|between:6,25',
          'password' => 'required|between:6,25|confirmed'
        ]);

        if ($user && Hash::check($request->old_password, $user->password)) {
          $user->password = bcrypt($request->password);
          $user->save();
          return response()->json([
            'success' => true,
            'user' => $user->info()
          ]);
        }
        return response()->json([
          'message' => 'Неверный старый пароль',
          'errors' => [
            'old_password' => 'Неверный старый пароль',
          ],
        ], 422);
        break;
    }
  }
}