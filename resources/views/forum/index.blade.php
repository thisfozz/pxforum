<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Forum Topics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            Recent Discussions
                        </h3>
                        <a href="{{ route('forum.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create New Topic
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Topic</th>
                                    <th scope="col" class="px-6 py-3 hidden md:table-cell">Created By</th>
                                    <th scope="col" class="px-6 py-3 hidden sm:table-cell">Replies</th>
                                    <th scope="col" class="px-6 py-3">Last Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topics as $topic)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            <a href="{{ route('forum.topic', $topic->topic_id) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">
                                                {{ $topic->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell text-gray-600 dark:text-gray-400">
                                            {{ $topic->user->login }}
                                        </td>
                                        <td class="px-6 py-4 hidden sm:table-cell text-gray-600 dark:text-gray-400">
                                            {{ $topic->posts->sum('replies_count') + $topic->posts_count }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                            {{ $topic->lastPost ? $topic->lastPost->updated_at->diffForHumans() : 'No activity' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No topics found. Be the first to start a discussion!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>