@extends('home')

@section('content')
    <div class="container mx-auto p-6 max-w-3xl bg-gray-800 text-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6">{{ $post->title }}</h1>

        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                class="w-full h-64 object-cover my-4 rounded-lg shadow-md">
        @endif

        <p class="my-6 leading-relaxed">{{ $post->content }}</p>

        <h2 class="text-2xl font-bold mt-8 border-t border-gray-700 pt-4">Comments</h2>
        <div class="space-y-6">
            @foreach ($post->comments as $comment)
                <div class="p-4 rounded-lg bg-gray-700 shadow-md">
                    <p class="mb-2">
                        <strong class="text-blue-400">{{ $comment->user->name }}</strong>: {{ $comment->comment }}
                    </p>

                    @if (auth()->id() === $comment->user_id || auth()->user()->is_admin)
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    @endif

                    <!-- Balasan -->
                    @foreach ($comment->replies as $reply)
                        <div class="ml-4 mt-2 p-2 rounded-lg bg-gray-600">
                            <p><strong class="text-blue-400">{{ $reply->user->name }}</strong>: {{ $reply->comment }}</p>

                            @if (auth()->id() === $reply->user_id || auth()->user()->is_admin)
                                <form action="{{ route('comments.destroy', $reply->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            @endif
                        </div>
                    @endforeach

                    <!-- Form Reply -->
                    <form action="{{ route('comments.reply') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="comment" placeholder="Add a reply..."
                            class="w-full p-3 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 mt-4 rounded transition">Submit
                            Reply</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Comment Form -->
        <form action="{{ route('comments.store') }}" method="POST" class="mt-8 p-6 bg-gray-700 rounded-lg shadow-md">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="comment" placeholder="Add a comment..."
                class="w-full p-3 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 mt-4 rounded transition">Submit</button>
        </form>
    </div>
@endsection
