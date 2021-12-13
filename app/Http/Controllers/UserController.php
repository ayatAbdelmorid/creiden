<?php

namespace App\Http\Controllers;

use App\User;
use App\Storage;
use Illuminate\Http\Request;
use Hash;
use Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $data['users']=User::all();

        return view('user.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$request->userId,
            'userId' => 'nullable|integer',
            'password' => 'required_without:userId|nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password|nullable',
            'storage_name' => 'required|string|max:255',

        ]);
        if( isset($request->userId)){
            $user=User::findOrFail($request->userId);
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


      return   redirect()->route('users.index')->with('success', 'user created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data=[];
        $data['user']=$user;

        return view('user.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data=[];
        $data['user']=$user;

        return view('user.edit', $data);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->storage->delete();
        $user->delete();
        return   redirect()->route('users.index')->with('success', 'user deleted successfully');

    }
}
