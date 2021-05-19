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

                    @if (!empty($posts))
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
                                <small>Created at {{ $post->created_at }} by {{ $post->user->name ?? '' }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <h1 class="text-center">There are no posts</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
