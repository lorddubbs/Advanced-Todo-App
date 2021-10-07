<?php

namespace App\Repositories\Comment;

use App\Repositories\BaseRepository;
use App\Models\Comment;

class CommentRepository extends BaseRepository
{
    protected $commentModel;

    public function __construct(Comment $commentModel)
    {
        parent::__construct($commentModel);
    }
}
