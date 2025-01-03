<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'required|exists:comments,id',
        ]);

        Comment::create([
            'comment' => $request->comment,
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Reply added successfully!');
    }
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (auth()->id() !== $comment->user_id && !auth()->user()->is_admin) {
            return back()->with('error', 'You are not authorized to delete this comment.');
        }

        $comment->replies()->delete();
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}
