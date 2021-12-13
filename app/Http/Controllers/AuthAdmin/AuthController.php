<?php

namespace App\Http\Controllers\AuthAdmin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Hash;
use Auth;
class AuthController extends Controller
{

    public function register()
    {

      return view('adminAuth.register');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $admin=Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $credentials = $request->only('email', 'password');

         if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('admin/home');
        }

    }

    public function login()
    {


      return view('adminAuth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('admin/home');
        }

        return redirect()->route('admin.login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function logout() {
      Auth::guard('admin')->logout();

      return redirect()->route('admin.login');
    }

    public function home()
    {
      return view('admin_home');
    }

}
