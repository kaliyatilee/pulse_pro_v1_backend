<?php
namespace App\Repositories;

use App\Models\Merchant;
use App\Repositories\BaseRepository;

class MerchantRepository extends BaseRepository
{
    protected $merchantModel;

    public function __construct(Merchant $merchantModel)
    {
        parent::__construct($merchantModel);
        $this->merchantModel = $merchantModel;
    }
}
