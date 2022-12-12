<?php
namespace App\Repositories;

use App\Models\Corporate;
use App\Repositories\BaseRepository;

class CorporateRepository extends BaseRepository
{
    protected $corporateModel;

    public function __construct(Corporate $corporateModel)
    {
        parent::__construct($corporateModel);
        $this->corporateModel = $corporateModel;
    }
}
