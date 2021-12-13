@extends('layouts.admin.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">storage Form</div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{route('storages.store')}}">
                            @csrf
                            @if(isset($storage))
                                <input type="hidden" id="storageId" name="storageId" value="{{$storage->id}}">
                            @endif

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{isset($storage)?$storage->name: old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="user_id" class="col-md-4 col-form-label text-md-right">User </label>

                                <div class="col-md-6">
                                    <select name="user_id" id="user_id" required>
                                        <option value="">Select User</option>

                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}" @if(isset($storage)&&$storage->user_id==$user->id)selected @endif>{{$user->name}}</option>

                                        @endforeach

                                      </select>

                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">

                                        {{ __('Submit') }}
                                    </button>

                                </div>
                            </div>
                        </form>

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
