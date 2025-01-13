<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class ForumController extends Controller
{
    public function index()
    {
        $topics = Topic::latest()
            ->with('user')
            ->withCount('posts')
            ->with('lastPost')
            ->get();

        return view('forum.index', compact('topics'));
    }
}