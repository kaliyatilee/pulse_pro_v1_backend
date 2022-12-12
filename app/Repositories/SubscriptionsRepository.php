<?php
namespace App\Repositories;

use App\Models\Subscriptions;
use App\Repositories\BaseRepository;

class SubscriptionsRepository extends BaseRepository
{
    protected $subscriptionsModel;

    public function __construct(Subscriptions $subscriptionsModel)
    {
        parent::__construct($subscriptionsModel);
        $this->subscriptionsModel = $subscriptionsModel;
    }
}
