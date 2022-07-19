<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentService
{
    private $repository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->repository = $commentRepository;
    }

    public function store(Request $request)
    {
        $data = $request->except(['_method', '_token']);

        $comment = $this->repository->store($data);

        $comment->username = User::find($comment->user_id)->name;

        return $comment;
    }

    public function destroy(Comment $comment)
    {
        $this->repository->destroy($comment);
    }

    public function update(Request $request, Comment $comment)
    {

    }
}
