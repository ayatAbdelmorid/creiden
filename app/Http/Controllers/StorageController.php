<?php

namespace App\Http\Controllers;

use App\Storage;
use App\User;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $data['storages']=Storage::all();

        return view('storage.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[];
        $data['users']=User::all();

        return view('storage.edit',$data);

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
            'user_id' => 'required|integer|unique:storages,user_id,'.$request->storageId,
            'storageId' => 'nullable|integer',

        ]);
        if( isset($request->storageId)){
            $storage=Storage::findOrFail($request->storageId);
            $storage->name=$validatedData['name'];
            $storage->user_id=$validatedData['user_id'];
            $storage->save();
        }else{

            $user=Storage::create([
                'name' => $validatedData['name'],
                'user_id' => $validatedData['user_id'],
            ]);
        }


      return   redirect()->route('storages.index')->with('success', 'storage created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function show(Storage $storage)
    {
        $data=[];
        $data['storage']=$storage;

        return view('storage.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function edit(Storage $storage)
    {
        $data=[];
        $data['storage']=$storage;
        $data['users']=User::all();

        return view('storage.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Storage $storage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Storage  $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Storage $storage)
    {
        $storage->delete();
        return   redirect()->route('storages.index')->with('success', 'storage deleted successfully');
    }
}
