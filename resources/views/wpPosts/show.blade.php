@extends('layouts.admin.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" >
                    <div class="card-header">Storage Info</div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{$post['ID']}}</li>
                                    <li class="list-group-item">{{$post['post_title']}}</li>
                                    <li class="list-group-item">{{$post['post_status']}}</li>
                                    <li class="list-group-item">{!! $post['post_content'] !!}</li>

                                </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
