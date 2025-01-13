<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Post;

class ReplyController extends Controller
{
    public function index()
    {
        $replies = Reply::latest()->get();
        return view('post.show', compact('replies'));
    }

    public function store(Request $request, $post)
    {
        $post = Post::findOrFail($post);

        $request->validate([
            'content' => 'required|string'
        ]);

        $reply = Reply::create([
            'content' => $request->content,
            'post_id' => $post->post_id,
            'created_by' => auth()->user()->user_id
        ]);

        $reply->load('user');

        return response()->json([
            'reply' => $reply,
            'message' => 'Reply created successfully.'
        ]);
    }
}