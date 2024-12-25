@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <a href="{{ route('forum.create') }}" class="btn btn-primary mb-3">
            Create New Topic
        </a>

        <div class="row mt-4">
            @foreach ($topics as $topic)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-light">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold">{{ $topic->title }}</h5>
                            <p class="card-text text-muted">
                                Created by <strong>{{ $topic->user->login }}</strong>
                            </p>
                            
                            <p class="card-text small text-muted mt-2">
                                <span class="badge badge-info">
                                    @if($topic->posts_count == 0)
                                        0 Posts
                                    @else
                                        {{ $topic->posts_count }} Posts
                                    @endif
                                </span>
                                <span class="ml-2">
                                    Last reply: {{ $topic->lastPost ? $topic->lastPost->updated_at->diffForHumans() : 'No replies yet' }}
                                </span>
                            </p>

                            <a href="{{ route('forum.topic', $topic->topic_id) }}" class="btn btn-primary mt-auto">
                                View Topic
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection