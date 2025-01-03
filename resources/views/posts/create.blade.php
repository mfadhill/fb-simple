@extends('home')
@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4 text-center">Create New Post</h1>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="5"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                    <input type="file" name="image" id="image"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" accept="image/*" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
            </form>
        </div>
    </div>
@endsection
