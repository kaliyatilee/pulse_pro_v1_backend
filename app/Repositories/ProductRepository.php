<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    protected $productRepository;

    public function __construct(Product $productRepository)
    {
        parent::__construct($productRepository);
        $this->productRepository = $productRepository;
    }
}
