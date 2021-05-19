@extends('layouts.app')
@section('content')
    <h1>{{ $post->title }}</h1>
    <p>
        {{ $post->body }}
    </p>
    <small>Created at {{ $post->created_at }} by {{ $post->user->name ?? '' }}</small><br>
    @if (Auth::user() && Auth::user()->id == $post->user_id)
    <a class="btn btn-success mt-4" href="{{ $post->id }}/edit">Edit</a>
    <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger float-right" type="submit">Delete</button>
    </form>
    @endif
@endsection