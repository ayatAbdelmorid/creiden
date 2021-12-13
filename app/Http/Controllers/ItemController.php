<?php

namespace App\Http\Controllers;

use App\Item;
use App\Storage;
use Auth;
use Illuminate\Http\Request;
use Validator;

class ItemController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($storage_id)
    {

        $items=Item::where('storage_id',$storage_id)->get();

        if($items){
            return response()->json([
                'items'=>$items

    
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
    public function store(Request $request,$storage_id)
    {
        $request->request->add(['storage_id' => $storage_id]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'storage_id' => 'required|integer|exists:storages,id',
        ]);
        $validation_messages=$validator->messages()->get('*');
        if(isset($validation_messages['name'])){
            return response()->json(['error'=>'storage name required.'], 401);

        }
        if(isset($validation_messages['storage_id'])||$storage_id!=$request->storage_id){
            return response()->json(['error'=>'wrong storage_id'], 401);

        }
        $validatedData=$validator->valid();


        if( isset($request->itemId)){
            $item=Item::where('storage_id',$storage_id)->where('id',$request->itemId)->first();
            if(!$item){
                return response()->json(['error'=>'incorrect storageId.'], 401);
            }
            $item->name=$validatedData['name'];
            $item->save();
        }else{

            $item=Item::create([
                'name' => $validatedData['name'],
                'storage_id' => $validatedData['storage_id'],
            ]);
        }
      
        if($item){
            return response()->json([
                'item'=>$item,
    
            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
           
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($storage_id,Item $item)
    {
        if( $item->storage_id!=$storage_id){
            return response()->json(['error'=>'item not related to storage sent'], 401);

        }
 

        if($item){
            return response()->json([
                'item'=>$item
    
            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Storage $storage,Item $item)
    {

        if($item){
            return response()->json([
                'item'=>$item,
                'storage'=>$storage

    
            ],200); 
        }
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($storage,Item $item)
    {
        
        if($item){
            
            $item->delete();

            return response()->json([
                'status'=>"success",
            ],200);
        }
       
        
        return response()->json(['error'=>'Something went wrong. Please try again later.'], 500);    }
}
