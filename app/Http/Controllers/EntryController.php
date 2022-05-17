<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCommentResource;
use App\Models\BookComment;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function getEntries()
    {
        return BookCommentResource::collection(BookComment::where('policy', 'public')->where('status', 'approved')->orderBy('created_at', 'DESC')->get());
    }

    public function getAllEntries()
    {
        return BookCommentResource::collection(BookComment::orderBy('created_at', 'DESC')->get());
    }

    public function postEntry(Request $request)
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'policy' => ['required', 'in:private,public'],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $comment = BookComment::create($request->only(['name', 'policy', 'content']));

        return new BookCommentResource($comment);
    }

    public function editEntry(Request $request, BookComment $comment)
    {
        $request->validate([
            'status' => ['required', 'in:pending,approved,denied',],
        ]);

        $comment->update(['status' => $request->status]);

        return new BookCommentResource($comment);
    }

    public function deleteEntry(BookComment $comment)
    {
        $comment->delete();

        return $comment;
    }
}
