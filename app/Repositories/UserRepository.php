<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        parent::__construct($userModel);
        $this->userModel = $userModel;
    }
}
