@extends('layouts.admin.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" >
                    <div class="card-header">User Info</div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{$user->name}}</li>
                                    <li class="list-group-item">{{$user->email}}</li>
                                </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
