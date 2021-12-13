@extends('layouts.admin.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">post Form</div>
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
                        <form method="POST" action="{{isset($post)?route('wordpress.store_post',['post'=>$post['ID']]):route('wordpress.store_post')}}">
                            @csrf
                            @if(isset($post))
                                <input type="hidden" id="postId" name="postId" value="{{$post['ID']}}">
                            @endif

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{isset($post)?$post['post_title']: old('title') }}" required autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="editor" class="col-md-4 col-form-label text-md-right">Content</label>

                                <div class="col-md-6">
                                        <textarea class="form-control" id="editor" name="editor">{{isset($post)?strip_tags( $post['post_content']):''}}</textarea>

                                    @error('editor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-right">status</label>

                                <div class="col-md-6">
                                    <select name="status" id="status" required>
                                        <option value="{{$post['post_status']}}" @if(isset($post)&&$post['post_status']=='publish')selected @endif>publish</option>
                                        <option value="{{$post['post_status']}}" @if(isset($post)&&$post['post_status']=='draft')selected @endif>draft</option>
                                        <option value="{{$post['post_status']}}" @if(isset($post)&&$post['post_status']=='pending')selected @endif>pending</option>
                                        <option value="{{$post['post_status']}}" @if(isset($post)&&$post['post_status']=='private')selected @endif>private</option>

                                    </select>
                                    <input type="checkbox" name="status" value="publish"  @if(isset($post)&&$post['post_status']=='publish')checked @endif>
                                    <label for="status"> publish</label><br>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label for="excerpt" class="col-md-4 col-form-label text-md-right">Excerpt</label>

                                <div class="col-md-6">
                                        <textarea class="form-control" id="excerpt" name="excerpt">{{isset($post)?strip_tags( $post['post_excerpt']):''}}</textarea>

                                    @error('excerpt')
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
            </div>
        </div>
    </div>
</div>
@endsection
