<?php

namespace App\Http\Controllers\AuthUser;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Storage;
use Hash;
use Auth;
use Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
        protected function guard()
    {
        return Auth::guard('userApi');
    }
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'storage_name' => 'required|string|max:255',

        ]);
        $validation_messages=$validator->messages()->get('*');
        if(isset($validation_messages['name'])||isset($validation_messages['password'])){
            return response()->json(['error'=>'Incorrect username or password.'], 401);

        }
        if(isset($validation_messages['email'])){
            return response()->json(['error'=>'Incorrect email.'], 401);

        }

        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' =>  hash('sha256',Str::random(80)),

        ]);
        $storage=Storage::create([
            'name' => $request->storage_name,
            'user_id' =>  $user->id,
        ]);
        $credentials = $request->only('email', 'password');
            Auth::guard('userApi')->attempt($credentials);
            $user= Auth::guard('userApi')->user();
            if($request->wantsJson() || strpos($request->getRequestUri(), 'api')&&$user){
                $success['token'] =   $user->api_token ;
                $success['user'] =  $user;

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
        Auth::guard('userApi')->attempt($credentials);
        $user= Auth::guard('userApi')->user();

        if($request->wantsJson() || strpos($request->getRequestUri(), 'api')&& $user){

            $user->api_token = hash('sha256',Str::random(80));
            $user->save();

            $success['token'] =   $user->api_token;
            $success['user'] =  $user;   

            return response()->json(['success'=>$success], 200);

        }
      
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
    }

    public function logout(Request $request) {

        $user = User::where('api_token', request()->bearerToken())->first();

        if(    $user ){
            unset($user->api_token);
            $user->save();
            
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        }

        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);

    }


}
