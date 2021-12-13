<?php

namespace App\Http\Controllers;

use App\User;
use App\Storage;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $users=User::all();
        return response()->json([
            'users'=>$users

        ],200);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$request->userId,
            'userId' => 'nullable|integer',
            'password' => 'required_without:userId|nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password|nullable',
            'storage_name' => 'required_without:userId|nullable|string|max:255',

        ]);
        $validation_messages=$validator->messages()->get('*');
        if(isset($validation_messages['name'])||isset($validation_messages['password'])){
            return response()->json(['error'=>'Incorrect username or password.'], 401);

        }
        if(isset($validation_messages['email'])){
            return response()->json(['error'=>'Incorrect email.'], 401);

        }
          if(isset($validation_messages['password_confirmation'])){
            return response()->json(['error'=>'password_confirmation not matched.'], 401);

        }
        if(isset($validation_messages['storage_name'])){
            return response()->json(['error'=>'storage name required.'], 401);

        }
        $validatedData=$validator->valid();

        if( isset($request->userId)){
            $user=User::findOrFail($request->userId);
            if(!$user){
                return response()->json(['error'=>'incorrect userId.'], 401);
            }
            $user->name=$validatedData['name'];
            $user->email=$validatedData['email'];
            $user->password=isset($validatedData['password'])?$validatedData['password']:$user->password;
            $user->save();
        }else{

            $user=User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $storage=Storage::create([
                'name' => $request->storage_name,
                'user_id' =>  $user->id,
            ]);

        }
        if($user){
            return response()->json([
                'user'=>$user,
                'storage'=>$user->storage

            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       

        if($user){
            return response()->json([
                'user'=>$user,
                'storage'=>$user->storage

            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);

    }

    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(isset( $user)){
            $user->storage->delete();
            $user->delete();
            return response()->json([
                'status'=>"success",
            ],200);
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);

    }
}
