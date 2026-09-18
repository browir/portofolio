<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'character' => ['required', 'string', 'in:knight,princess,dragon'],
            'message' => ['required', 'string', 'max:500'],
        ]);

        $comment = Comment::create($validated);

        return response()->json([
            'comment' => [
                'name' => $comment->name,
                'character' => $comment->character,
                'message' => $comment->message,
            ],
        ], 201);
    }
}
