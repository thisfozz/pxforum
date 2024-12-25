<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-4">
                        <a href="{{ route('forum.create') }}" class="btn btn-primary mb-3 dark:bg-blue-600 dark:hover:bg-blue-700">
                            Create New Topic
                        </a>

                        <div class="row mt-4">
                            @foreach ($topics as $topic)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-light dark:border-gray-700">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title font-weight-bold text-gray-800 dark:text-gray-200">{{ $topic->title }}</h5>
                                            <p class="card-text text-muted dark:text-gray-400">
                                                Created by <strong>{{ $topic->user->login }}</strong>
                                            </p>

                                            <p class="card-text small text-muted mt-2 dark:text-gray-400">
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

                                            <a href="{{ route('forum.topic', $topic->topic_id) }}" class="btn btn-primary mt-auto dark:bg-blue-600 dark:hover:bg-blue-700">
                                                View Topic
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>