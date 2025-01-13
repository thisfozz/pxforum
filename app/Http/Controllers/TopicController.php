<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::latest()
            ->with('user')
            ->withCount('posts')
            ->with(['posts' => function($query) {
                $query->withCount('replies');
            }])
            ->with('lastPost')
            ->get();

        return view('forum.index', compact('topics'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $topic = Topic::create([
            'title'=> $request->title,
            'created_by'=>auth()->user()->user_id,
        ]);

        return redirect()->route('forum.index')->with('success','Topic created successfully.');
    }


    public function show($topicId)
    {
        $topic = Topic::with(['posts.user'])
            ->withCount('posts')
            ->with(['posts' => function($query) {
                $query->withCount('replies');
            }])
            ->findOrFail($topicId);
        
        return view('topic.index', compact('topic'));
    }
}