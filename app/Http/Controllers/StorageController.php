<?php

namespace App\Http\Controllers;

use App\Storage;
use App\User;
use Illuminate\Http\Request;
use Validator;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storages=Storage::all();

        if($storages){
            return response()->json([
                'storages'=>$storages

    
            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);


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
            'user_id' => 'required|integer|unique:storages,user_id,'.$request->storageId.',id,deleted_at,NULL',
            'storageId' => 'nullable|integer',

        ]);
        $validation_messages=$validator->messages()->get('*');
        if(isset($validation_messages['name'])){
            return response()->json(['error'=>'storage name required.'], 401);

        }
        if(isset($validation_messages['user_id'])){
            return response()->json(['error'=>'somthing with user maybe has another storage '], 401);

        }
        $validatedData=$validator->valid();


        if( isset($request->storageId)){
            $storage=Storage::findOrFail($request->storageId);
            if(!$storage){
                return response()->json(['error'=>'incorrect storageId.'], 401);
            }
            $storage->name=$validatedData['name'];
            $storage->user_id=$validatedData['user_id'];
            $storage->save();
        }else{

            $storage=Storage::create([
                'name' => $validatedData['name'],
                'user_id' => $validatedData['user_id'],
            ]);
        }


        if($storage){
            return response()->json([
                'storage'=>$storage,
                'user'=>$storage->user

            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function show(Storage $storage)
    {

        if($storage){
            return response()->json([
                'storage'=>$storage
    
            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function edit(Storage $storage)
    {
        $storage=$storage;
        $users=User::all();

        if($storage){
            return response()->json([
                'users'=>$user,
                'storage'=>$storage

    
            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Storage $storage)
    {

        // $storage->delete();
        if($storage){
            if(count($storage->items)>0 ){
                foreach( $storage->items as $item){
                    $item->delete();
                }
            }
            return response()->json([
                'status'=>"success",
            ],200);
        }
       
        
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
    }
}
