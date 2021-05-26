@extends('layouts.app')

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

                    @if (count($posts) > 0)
                    <h1 class="text-center">Your Posts</h1>
                        @foreach ($posts as $post)
                        <div class="card mt-4">
                            <div class="card-body">
                                <h1 class="card-title">
                                    <a class="text-decoration-none" href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                                </h1>
                                <p class="card-text">
                                    {{ substr($post->body, 0, 7) . ' ...'}}
                                </p>
                                <small>Created on {{ date('Y-m-d', strtotime($post->created_at)) }} 
                                    at {{ date('H:i:s', strtotime($post->created_at)) }} by {{ $post->user->name ?? '' }}</small>
                                <div>
                                    <a class="btn btn-success mt-4" href="/posts/{{ $post->id }}/edit">Edit</a>
                                    <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger float-right" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <h1 class="text-center">There are no posts</h1>
                    @endif
                    <div class="text-center">
                        <a href="/posts/create" class="btn btn-success mt-4">Create Post</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
