@extends('layouts.app')
@section('content')
    @if (count($posts) > 0)
        @foreach ($posts as $post)
        
        <div class="card mt-4">
            <div class="card-body">
                <div class="row row-eq-height">
                    @if ($post->image_name)
                    <div class="col-md-3">
                        <img class="rounded d-block w-100 h-100" src="{{ url('/images') }}/{{  $post->image_name }}" alt="image" style="width: 100%; height: 500px">
                    </div>
                        @endif
                    <div class="col-md-8" style="height: 100%">
                        <h1 class="card-title">
                            <a class="text-decoration-none" href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                        </h1>
                        <p class="card-text">
                            @if (strlen($post->body) > 40)
                                {{ substr($post->body, 0, 40) . "..."}}
                            @else
                                {{ $post->body }}
                            @endif
                        </p>
                        <div>
                            <small>Created at {{ $post->created_at }} by {{ $post->user->name ?? '' }}</small>
                        </div>
                    </div>
                    
                    @if (Auth::user() && Auth::user()->id == $post->user_id)
                    <div class="col-md-1" style="height: 100%">
                        <a class="btn btn-success mt-2  mb-4" href="posts/{{ $post->id }}/edit">Edit</a>
                        <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger float-right" type="submit">Delete</button>
                        </form>
                    </div>
                    @endif
                
                </div>
            </div>
        </div>
        @endforeach
    @else
        <h1 class="text-center">There are no posts</h1>
    @endif
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection