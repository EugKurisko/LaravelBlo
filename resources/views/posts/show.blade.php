@extends('layouts.app')
@section('content')
    <h1 class="text-center">{{ $post->title }}</h1>
    @if ($post->image_name)
    <div>
        <img src="{{ url('/images') }}/{{  $post->image_name }}" alt="image" style="width: 100%; height: 500px">
    </div>
    @endif
    <p class="mt-4">
        {{ $post->body }}
    </p>
    <small>Created at {{ $post->created_at }} by {{ $post->user->name ?? 'admin' }}</small><br>
    @if (Auth::user() && Auth::user()->id == $post->user_id)
    <a class="btn btn-success mt-4" href="{{ $post->id }}/edit">Edit</a>
    <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger float-right" type="submit">Delete</button>
    </form>
    @endif
@endsection