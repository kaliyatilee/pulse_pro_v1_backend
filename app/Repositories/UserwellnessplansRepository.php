<?php
namespace App\Repositories;

use App\Models\Userwellnessplans;
use App\Repositories\BaseRepository;

class UserwellnessplansRepository extends BaseRepository
{
    protected $userwellnessplansModel;

    public function __construct(Userwellnessplans $userwellnessplansModel)
    {
        parent::__construct($userwellnessplansModel);
        $this->userwellnessplansModel = $userwellnessplansModel;
    }
}
