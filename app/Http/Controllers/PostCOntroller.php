<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        // Ambil ID pengguna yang sedang login
        $userId = auth()->id();

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'user_id' => $userId, // Isi dengan user_id yang valid
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function like($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Hapus like
            $existingLike->delete();
            return response()->json([
                'status' => 'unliked',
                'likes_count' => $post->likes()->count()
            ]);
        } else {
            // Tambahkan like
            $post->likes()->create(['user_id' => $user->id]);
            return response()->json([
                'status' => 'liked',
                'likes_count' => $post->likes()->count()
            ]);
        }
    }


    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post has been deleted successfully');
    }
}
