<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $service;

    public function __construct(CommentService $commentService)
    {
        $this->service = $commentService;
    }

    public function store(CommentRequest $request)
    {
        return $this->service->store($request);
    }

    public function update(Request $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $this->service->destroy($comment);
    }
}
