<?php

namespace App\Http\Controllers\AuthAdmin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Hash;
use Auth;
use Validator;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    protected function guard()
    {
        return Auth::guard('adminApi');
    }

    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        if(isset($validation_messages['email'])||isset($validation_messages['password'])){
            return response()->json(['error'=>'Incorrect username or password.'], 401);

        }
        $admin=Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $credentials = $request->only('email', 'password');

        Auth::guard('adminApi')->attempt($credentials);
        $admin= Auth::guard('adminApi')->user();
        
        if($request->wantsJson() || strpos($request->getRequestUri(), 'api')&& $admin){
            
            $admin->api_token = hash('sha256',Str::random(80));
            $admin->save();
            
            $success['token'] =   $admin->api_token;
            $success['admin'] =  $admin;   
           
            return response()->json(['success'=>$success], 200);

        }
      
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);

    }


    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if(isset($validation_messages['email'])||isset($validation_messages['password'])){
            return response()->json(['error'=>'Incorrect username or password.'], 401);

        }

        $credentials = $request->only('email', 'password');

        Auth::guard('adminApi')->attempt($credentials);
        $admin= Auth::guard('adminApi')->user();

        if($request->wantsJson() || strpos($request->getRequestUri(), 'api')&& $admin){
            $admin->api_token = hash('sha256',Str::random(80));
            $admin->save();

            $success['token'] =   $admin->api_token;
            $success['admin'] =  $admin;  

            return response()->json(['success'=>$success], 200);

        }
      
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
    }

    public function logout() {
        $admin = Admin::where('api_token', request()->bearerToken())->first();

        if(    $admin ){
            unset($admin->api_token);
            $admin->save();
            
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        }

        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
    }


}
