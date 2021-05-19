@extends('layouts.app')
@section('content')
    <form action="{{ route('posts.update', ['post' => $post]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <input style="width: 300px;" type="text" name="title" class="form-control mt-4" value="{{ $post->title }}">
            <textarea name="body" class="form-control mt-4 mb-4" rows="4">{{ $post->body }}</textarea>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
@endsection