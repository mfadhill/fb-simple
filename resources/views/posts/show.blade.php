@extends('home')

@section('content')
    <div class="container mx-auto p-4 max-w-3xl">
        <h1 class="text-2xl font-bold mb-6">{{ $post->title }}</h1>

        <!-- Menampilkan gambar dengan lebar yang lebih terbatas dan efek shadow -->
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                class="w-full h-64 object-cover my-4 rounded-md shadow-lg">
        @endif

        <p class="my-4">{{ $post->content }}</p>

        <h2 class="text-xl font-bold mt-6">Comments</h2>
        @foreach ($post->comments as $comment)
            <div class="mb-4 border-t pt-4 shadow-sm rounded-lg p-4">
                <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}</p>

                @foreach ($comment->replies as $reply)
                    <div class="ml-4 mt-2">
                        <p><strong>{{ $reply->user->name }}</strong>: {{ $reply->comment }}</p>
                    </div>
                @endforeach

                <form action="{{ route('comments.reply') }}" method="POST" class="ml-4 mt-2">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <input type="text" name="comment" placeholder="Reply..."
                        class="border px-2 py-1 rounded w-full max-w-lg shadow-sm">
                    <button type="submit" class="bg-gray-300 py-1 px-2 mt-2 rounded">Reply</button>
                </form>
            </div>
        @endforeach

        <form action="{{ route('comments.store') }}" method="POST" class="shadow-sm p-4 rounded-lg mb-6">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="comment" placeholder="Add a comment..." class="border p-2 w-full max-w-lg rounded shadow-md"></textarea>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 mt-2 rounded">Submit</button>
        </form>
    </div>
@endsection
