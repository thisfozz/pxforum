@extends('layouts.app')

@section('content')
    <h3>{{ $topic->title }}</h3>

    @if ($posts->isEmpty())
        <p>No posts yet in this topic. Be the first to post!</p>
    @else
        @foreach ($posts as $post)
            <div class="post">
                <h5>{{ $post->title }}</h5>
                <p>{{ $post->content }}</p>
                <p><small>Posted at {{ $post->created_at->diffForHumans() }}</small></p>
            </div>
        @endforeach
    @endif
@endsection