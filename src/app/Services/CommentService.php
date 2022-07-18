<?php

namespace App\Services;

use App\Models\Comment;
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

        return $this->repository->store($data);
    }

    public function destroy(Comment $comment)
    {
        $this->repository->destroy($comment);
    }

    public function update(Request $request, Comment $comment)
    {

    }
}
