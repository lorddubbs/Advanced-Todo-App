<?php

namespace App\Services\Comment;

use App\Repositories\Comment\CommentRepository;


class CommentService
{
    protected $commentRepository;  

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }


    public function createComment(array $comment)
    {
        $comment = $this->commentRepository->create($comment);
        
        return $this->commentRepository->where('task_id', $comment->task_id)->get();
    }

    public function updateComment(int $commentId, array $data)
    {
        return $this->commentRepository->update($commentId, $data);
    }

    public function getAllComments($taskId)
    {
        $comments = $this->commentRepository->where('task_id', $taskId);
        if (!$comments)  {
            throw new \Exception('Comment not found with Task ID:.', $taskId);
        }
        return $comments->get();
    }

    public function getCommentById(int $commentId)
    {
        return $this->commentRepository->find($commentId);
    }

    public function deleteComment(int $commentId)
    {
        return $this->commentRepository->delete($commentId);
    }

}