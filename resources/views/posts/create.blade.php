@extends('layouts.app')
@section('content')
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input style="width: 300px;" type="text" name="title" class="form-control mt-4" placeholder="Post title">
            <textarea name="body" class="form-control mt-4 mb-4" placeholder="Post content" rows="4"></textarea>
            <input type="file" name="image">
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-success">Create Post</button>
            </div>
        </div>
    </form>
@endsection