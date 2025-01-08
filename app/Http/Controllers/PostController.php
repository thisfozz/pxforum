<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Topic;
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return view('post.index', compact('posts'));
    }

    public function create($topic)
    {
        $topic = Topic::find($topic);
        return view('post.create', compact('topic'));
    }
    public function store(Request $request, $topicId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'open',
            'created_by' => auth()->user()->user_id,
            'topic_id' => $topicId
        ]);

        return redirect()->route('forum.topic', $topicId)->with('success', 'Post created successfully.');
    }

    public function show($topic, $post)
    {
        $post = Post::findOrFail($post);
        return view('post.show', compact('post'));
    }
}