<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $post->title }}
            </h2>
            <a href="{{ route('forum.topic', $post->topic_id) }}" 
               class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                ← Назад к темам
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden mb-6 border-2 border-indigo-500 dark:border-indigo-400">
                <div class="flex">
                    <div class="w-48 p-6 border-r border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-24 h-24 mb-3">
                                @if($post->user->userDetail && $post->user->userDetail->avatar_url)
                                    <img src="{{ $post->user->userDetail->avatar_url }}" 
                                         alt="Avatar" 
                                         class="rounded-full w-full h-full object-cover ring-4 ring-indigo-500 dark:ring-indigo-400">
                                @else
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($post->user->email)) }}?d=mp&s=200" 
                                         alt="Default Avatar"
                                         class="rounded-full w-full h-full object-cover ring-4 ring-indigo-500 dark:ring-indigo-400">
                                @endif
                            </div>
                            <div class="font-bold text-lg text-gray-900 dark:text-white">
                                {{ $post->user->userDetail->display_name ?? $post->user->login }}
                            </div>
                            <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-1">
                                Роль
                                {{ $post->user->role->role_name }}
                            </div>
                            @if($post->user->userDetail)
                                <div class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                                    @if($post->user->userDetail->first_name || $post->user->userDetail->last_name)
                                        {{ $post->user->userDetail->first_name }} {{ $post->user->userDetail->last_name }}<br>
                                    @endif
                                    Дата регистрации<br>
                                    {{ $post->user->created_at->format('d.m.Y') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 p-6 bg-white dark:bg-gray-800">
                        <div class="flex justify-between items-start mb-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Создано {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            @foreach($post->replies as $reply)
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden mb-4">
                    <div class="flex">
                        <div class="w-48 p-6 border-r border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 mb-3">
                                    @if($reply->user->userDetail && $reply->user->userDetail->avatar_url)
                                        <img src="{{ $reply->user->userDetail->avatar_url }}" 
                                             alt="Avatar" 
                                             class="rounded-full w-full h-full object-cover">
                                    @else
                                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($reply->user->email)) }}?d=mp&s=200" 
                                             alt="Default Avatar"
                                             class="rounded-full w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="font-bold text-gray-900 dark:text-white">
                                    {{ $reply->user->userDetail->display_name ?? $reply->user->login }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    Роль
                                    {{ $reply->user->role->role_name }}
                                </div>
                                @if($reply->user->userDetail)
                                    <div class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                                        @if($reply->user->userDetail->first_name || $post->user->userDetail->last_name)
                                            {{ $reply->user->userDetail->first_name }} {{ $post->user->userDetail->last_name }}<br>
                                        @endif
                                        Дата регистрации<br>
                                        {{ $reply->user->created_at->format('d.m.Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $reply->created_at->diffForHumans() }}
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-500">
                                        {{ $reply->likes_count ?? 0 }} likes
                                    </span>
                                    @auth
                                        <button type="button" 
                                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            Like
                                        </button>
                                    @endauth
                                </div>
                            </div>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! nl2br(e($reply->content)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @auth
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Ответить
                        </h3>
                        <form action="{{ route('forum.reply.store', [$post->topic_id, $post->post_id]) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <textarea name="content" 
                                          rows="4" 
                                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                          placeholder="Напишите ваш ответ здесь..."
                                          required></textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    Ответить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                    <div class="p-6 text-center">
                        <p class="text-gray-600 dark:text-gray-400">
                            Пожалуйста <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">войдите</a> 
                            чтобы ответить.
                        </p>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout> 