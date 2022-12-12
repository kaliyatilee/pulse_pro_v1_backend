<?php
namespace App\Repositories;

use App\Models\Newsfeed;
use App\Repositories\BaseRepository;

class NewsfeedRepository extends BaseRepository
{
    protected $newsfeedRepository;

    public function __construct(Newsfeed $newsfeedRepository)
    {
        parent::__construct($newsfeedRepository);
        $this->newsfeedRepository = $newsfeedRepository;
    }
}
