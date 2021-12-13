<?php

namespace App\Http\Controllers;

use App\Item;
use App\Storage;
use Auth;
use Illuminate\Http\Request;

class ItemController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Storage $storage)
    {
        $data=[];
        $data['storage']=$storage;

        return view('item.edit',$data);
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
        $validatedData =  $request->validate([
            'name' => 'required|string|max:255',
            'storage_id' => 'required|integer|exists:storages,id',
        ]);
        if( isset($request->itemId)){
            $item=Item::findOrFail($request->itemId);
            $item->name=$validatedData['name'];
            $item->save();
        }else{

            $item=Item::create([
                'name' => $validatedData['name'],
                'storage_id' => $validatedData['storage_id'],
            ]);
        }
        if(Auth::guard('admin')->check()){
            return   redirect()->route('storages.edit',['storage'=>$storage_id])->with('success', 'item created successfully');

        }
        return   redirect()->route('user.home')->with('success', 'item created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($storage_id,Item $item)
    {
        $data=[];
        $data['item']=$item;

        return view('item.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Storage $storage,Item $item)
    {
        $data=[];
        $data['storage']=$storage;
        $data['item']=$item;

        return view('item.edit',$data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($storage,Item $item)
    {
        $item->delete();
        
        if(Auth::guard('admin')->check()){
            return   redirect()->route('storages.edit',['storage'=>$storage])->with('success', 'item created successfully');

        }
        return   redirect()->route('user.home')->with('success', 'item created successfully');
    }
}
