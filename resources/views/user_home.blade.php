@extends('layouts.user.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <div class="card-body">

                    <table class="table table-bordered">


                        <thead class="thead-dark">
                            <th class="lopendeopdrachten text-center" colspan="4">
                                @if (isset($storage))
                                    <a type="button" class="btn btn-secondary" href="{{route('items.create',['storage'=>$storage])}}">add new item</a>
                                @endif
                            </th>

                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">CRUD</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if (isset($storage)&&count($storage->items)>0)
                                @foreach ($storage->items as $item)
                                    <tr>
                                        <th scope="row">{{$item->id}}</th>
                                        <td>{{$item->name}}</td>
                                        <td><div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                              <a type="button" class="btn btn-secondary" href="{{route('items.edit',['storage'=>$storage,'item'=>$item])}}">Updtae</a>

                                            </div>
                                            <div class="btn-group mr-2" role="group" aria-label="Second group">
                                              <a type="button" class="btn btn-info" href="{{route('items.show',['storage'=>$storage,'item'=>$item])}}">Show</a>

                                            </div>
                                            <div class="btn-group" role="group" aria-label="Third group">

                                              <a type="button" class="btn btn-warning" href="{{route('item.destroy',['storage'=>$storage,'item'=>$item])}}">Delete</a>

                                            </div>
                                          </div></td>
                                    </tr>

                                @endforeach
                            @endif


                        </tbody>
                      </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
