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
    <small>Created on {{ date('Y-m-d', strtotime($post->created_at)) }} 
        at {{ date('H:i:s', strtotime($post->created_at)) }} by {{ $post->user->name ?? 'admin' }}</small><br>
    @if (Auth::user() && Auth::user()->id == $post->user_id)
    <div class="d-flex justify-content-between align-items-center">
        <a class="btn btn-success mt-4" href="{{ $post->id }}/edit">Edit</a>
        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger float-right" type="submit">Delete</button>
        </form>
    </div>
    @endif
    @if (Auth::user())
        <h2 class="text-center">What do you think about it?</h2>
        <div class="text-center mt-4 mb-4">
            <button id="leaveCom" class="btn btn-secondary">Write your comment</button>
            <form id="comment-form" class="d-none" method="POST">
                @csrf
                @method('POST')
                <div class="form-group mt-4">
                    <textarea class="form-control" name="page-comment" id="comment-text" cols="30" rows="10"></textarea>
                </div>
                <input type="hidden" id="postId" value="{{ $post->id }}">
                <input type="hidden" id="userName" value="{{ Auth::user()->name }}">
                <input type="hidden" id="postAuthor" value="{{ $post->user_id }}">
                <input type="submit" class="btn btn-success" value="Опубликовать">
            </form>
        </div>
    @endif
    @if (count($comments) > 0)
    <h2 class="text-center">Comments</h2>
    <div id="comments">
        @foreach ($comments as $comment)
            <div class="card mt-4 mb-4 bg-info">
                <div class="card-body">
                    <span class="card-title">Written  by {{ $comment->user->name ?? '' }}</span>
                    on {{ date('Y-m-d', strtotime($comment->created_at)) }} 
                        at {{ date('H:i:s', strtotime($comment->created_at)) }} 
                    <div class="card-text">
                        {{ $comment->comment }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @elseif(count($comments) == 0)
    <div id="comments" class="mt-4 mb-4">
    </div>
    @endif
@endsection