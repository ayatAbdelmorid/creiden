<?php

namespace App\Http\Controllers\AuthUser;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Storage;
use Hash;
use Auth;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function register()
    {

      return view('userAuth.register');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'storage_name' => 'required|string|max:255',

        ]);

        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $storage=Storage::create([
            'name' => $request->storage_name,
            'user_id' =>  $user->id,
        ]);

        $credentials = $request->only('email', 'password');

         if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->intended('user/home');
        }

    }

    public function login()
    {


      return view('userAuth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->intended('user/home');
        }

        return redirect()->route('user.login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function logout() {
      Auth::guard('user')->logout();

      return redirect()->route('user.login');
    }

    public function home()
    {
        $storage= Auth::guard('user')->user()->storage;
        return view('user_home',['storage'=>$storage]);
    }
}
