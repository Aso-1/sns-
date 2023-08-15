<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $inputs = request()->validate([
            'comment' => 'required|max:255'
        ]);

        $comment = Comment::create([
            'comment' => $inputs['comment'],
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id
        ]);

        return redirect('/');
    }
}
