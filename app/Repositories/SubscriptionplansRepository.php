<?php
namespace App\Repositories;

use App\Models\Subscriptionplans;
use App\Repositories\BaseRepository;

class SubscriptionplansRepository extends BaseRepository
{
    protected $subscriptionplansModel;

    public function __construct(Subscriptionplans $subscriptionplansModel)
    {
        parent::__construct($subscriptionplansModel);
        $this->subscriptionplansModel = $subscriptionplansModel;
    }
}
