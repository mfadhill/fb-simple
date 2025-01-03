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
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-500 mt-2 inline-block">Comment & Reply</a>

                    <div class="flex items-center space-x-2">
                        <button id="like-btn-{{ $post->id }}"
                            class="like-btn {{ $post->isLikedByUser() ? 'text-red-500' : 'text-gray-600' }}"
                            data-post-id="{{ $post->id }}" onclick="toggleLike({{ $post->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                            <span id="likes-count-{{ $post->id }}">{{ $post->likes()->count() }}</span>
                        </button>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function toggleLike(postId) {
            const likeBtn = $('#like-btn-' + postId);
            const likesCount = $('#likes-count-' + postId);

            $.ajax({
                url: '/posts/' + postId + '/like',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    postId: postId
                },

                success: function(response) {
                    if (response.status === 'liked') {
                        likeBtn.removeClass('text-gray-600').addClass('text-red-500');
                    } else {
                        likeBtn.removeClass('text-red-500').addClass('text-gray-600');
                    }
                    likesCount.text(response.likes_count);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        }
    </script>
@endsection
