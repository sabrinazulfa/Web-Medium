<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CommentService
{
    public function getAllComments()
    {
        return Comment::all();
    }

    public function findCommentById($id)
    {
        return Comment::find($id);
    }

    public function createComment(array $data)
    {
        $validator = Validator::make($data, Comment::rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Comment::create($data);
    }

    public function updateComment($id, array $data)
    {
        $validator = Validator::make($data, Comment::rules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $comment = Comment::find($id);
        if ($comment) {
            $comment->update($data);
            return $comment;
        }
        return null;
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            return $comment->delete();
        }
        return null;
    }
}