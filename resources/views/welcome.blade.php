@extends('layouts.app')
@section('content')
<div class="mx-auto bg-light" style="width: 500px;">
    <h1>Welcome To LaravelBlog</h1>
    <h6>
        Write your articles, share your ideas, discuss interesting topics
    </h6>
    <p class="mx-auto bg-light" style="width: 300px;">
        Create account and get started
    </p>
    <div class="mt-4 row justify-content-center">
        <div class="col-4">
            <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
        </div>
        <div class="col-4">
            <a class="btn btn-success" href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>
</div>
@endsection
