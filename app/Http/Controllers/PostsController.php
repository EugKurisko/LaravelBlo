<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
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
        $posts = DB::table('posts')->paginate(5);
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
        return redirect('posts')->with('error', 'You don\'t have permisson to enter this page');
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
        return redirect('home')->with('success', 'Post added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $comments = Comment::where('post_id', '=', $post->id)->get();
        return view('posts.show', ['post' => $post, 'comments' => $comments]);
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
            return view('posts.edit', ['post' => $post, 'message' => 'Post edited']);
        }
        return redirect('posts')->with('error', 'You don\'t have permisson to enter this page');
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
        if ($request->image != null) {
            File::delete(public_path() . '/images/' . $post->image_name);
        }
        $this->checkInput($request);
        $this->writeToDb($request, $post);
        return redirect('posts/' . $post->id)->with('success', 'Post edited');
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
        Comment::where('post_id', $post->id)->delete();
        //$post->user->comment->comment->delete();
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
        if ($request->image) {
            $this->validateImage($request);
        }
    }

    private function writeToDb(Request $request, Post $post)
    {
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->image_name = $request->image->name ?? $post->image_name ?? '';
        $post->save();
    }

    private function validateImage(Request $request)
    {
        $name = $request->image->getClientOriginalName();
        $imageNameToStore = time() . $name;
        $request->image->name = $imageNameToStore;
        $request->image->move(public_path('images'), $imageNameToStore);
    }
}
