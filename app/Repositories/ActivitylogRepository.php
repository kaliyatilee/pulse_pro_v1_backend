<?php
namespace App\Repositories;

use App\Models\Activitylog;
use App\Repositories\BaseRepository;

class ActivitylogRepository extends BaseRepository
{
    protected $activitylogModel;

    public function __construct(Activitylog $activitylogModel)
    {
        parent::__construct($activitylogModel);
        $this->activitylogModel = $activitylogModel;
    }
}
