@extends('layouts.admin.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">user</th>
                    <th scope="col">CRUD</th>
                  </tr>
                </thead>
                <tbody>
                    @if (count($storages)>0)
                        @foreach ($storages as $storage)
                            <tr>
                                <th scope="row">{{$storage->id}}</th>
                                <td>{{$storage->name}}</td>
                                <td>{{$storage->user->name}}</td>
                                <td><div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                      <a type="button" class="btn btn-secondary" href="{{route('storages.edit',['storage'=>$storage])}}">Updtae</a>

                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                      <a type="button" class="btn btn-info" href="{{route('storages.show',['storage'=>$storage])}}">Show</a>

                                    </div>
                                    <div class="btn-group" role="group" aria-label="Third group">

                                      <a type="button" class="btn btn-warning" href="{{route('storage.destroy',['storage'=>$storage])}}">Delete</a>

                                    </div>
                                  </div></td>
                            </tr>

                        @endforeach
                    @endif


                </tbody>
              </table>

        </div>
    </div>
@endsection
