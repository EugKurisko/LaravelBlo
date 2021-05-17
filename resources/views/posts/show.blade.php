@extends('layouts.app')
@section('content')
    <h1>{{ $post->title }}</h1>
    <p>
        {{ $post->body }}
    </p>
    <small>Created at {{ $post->created_at }} by</small>
@endsection