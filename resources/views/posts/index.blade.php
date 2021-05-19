@extends('layouts.app')
@section('content')
    @if (!empty($posts))
        @foreach ($posts as $post)
        <div class="card mt-4">
            <div class="card-body">
                <h1 class="card-title">
                    <a class="text-decoration-none" href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                </h1>
                <p class="card-text">
                    {{ substr($post->body, 0, 7) . ' ...'}}
                </p>
                <small>Created at {{ $post->created_at }} by {{ $post->user->name ?? '' }}</small>
            </div>
        </div>
        @endforeach
    @else
        There are no posts
    @endif
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection