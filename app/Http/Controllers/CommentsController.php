<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->post_id = $request->postId;
        $comment->user_id = $request->postAuthor;
        $comment->save();
        $comment->user->name = $request->userName;
        return response()->json($comment);
    }

    public function destroy($id)
    {
        //
    }
}
