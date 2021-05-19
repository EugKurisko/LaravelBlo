<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //take everything from database
        $posts = DB::table('posts')->paginate(3);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()) {
            return view('posts.create');
        }
        return redirect('posts');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->checkInput($request);
        $post = new Post();
        $this->writeToDb($request, $post);
        return redirect('posts')->with('success', 'Post added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (Auth::user()) {
            return view('posts.edit')->with('post', $post);
        }
        return redirect('posts');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->checkInput($request);
        //dd($request->image->name);
        $this->writeToDb($request, $post);
        return redirect('posts')->with('success', 'Post added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        File::delete(public_path() . '/images/' . $post->image_name);
        return redirect('posts')->with('success', 'Post deleted');
    }

    private function checkInput(Request $request)
    {
        $request->validate([
            'title' => 'required|max:64',
            'body' => 'required',
            'img' => 'image|max:1999|mimes:png,jpg'
        ]);
        //dd($request->image);
        if ($request->image) {
            $this->validateImage($request);
        }
    }

    private function writeToDb(Request $request, Post $post)
    {
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->image_name = $request->image->name ?? 'noImage.jpg';
        $post->save();
    }

    private function validateImage(Request &$request)
    {
        $name = $request->image->getClientOriginalName();
        $imageNameToStore = time() . $name;
        $request->image->name = $imageNameToStore;
        $request->image->move(public_path('images'), $imageNameToStore);
    }
}
