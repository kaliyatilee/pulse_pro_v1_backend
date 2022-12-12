<?php
namespace App\Repositories;

use App\Models\Reward;
use App\Repositories\BaseRepository;

class RewardRepository extends BaseRepository
{
    protected $rewardRepository;

    public function __construct(Reward $rewardRepository)
    {
        parent::__construct($rewardRepository);
        $this->rewardRepository = $rewardRepository;
    }
}
