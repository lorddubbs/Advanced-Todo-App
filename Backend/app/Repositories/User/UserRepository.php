<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        parent::__construct($userModel);
    }
}
