@extends('layouts.admin.app')

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

                <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group-vertical " role="group" aria-label="First group">

                        <a type="button" class="btn btn-primary btn-lg mb-5" href="{{route('users.create')}}">Create User</a>
                        <a type="button" class="btn btn-secondary btn-lg" href="{{route('users.index')}}">All Users</a>
                    </div>
                    <div class="btn-group-vertical" role="group" aria-label="seconed group">

                        <a type="button" class="btn btn-primary btn-lg mb-5" href="{{route('storages.create')}}">Create Storage</a>
                        <a type="button" class="btn btn-secondary btn-lg"  href="{{route('storages.index')}}">All Storages</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
