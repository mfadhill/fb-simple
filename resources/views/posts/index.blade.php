@extends('home')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Blog Posts</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create New Post</a>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            @foreach ($posts as $post)
                <div class="border p-4 rounded-md shadow-md">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                            class="mb-4 rounded-md w-full">
                    @endif
                    <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                    <p class="text-gray-600 text-sm">By {{ $post->user->name }} | {{ $post->created_at->format('d M Y') }}
                    </p>
                    <p class="mt-2">{{ Str::limit($post->content, 150) }}</p>
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-500 mt-2 inline-block">Read more</a>
                    <div class="flex items-center justify-between mt-4 text-gray-600">
                        <button class="flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>

                            <span>Like</span>
                        </button>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded mt-4">Delete Post</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
