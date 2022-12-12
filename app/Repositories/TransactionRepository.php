<?php
namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

class TransactionRepository extends BaseRepository
{
    protected $transactionRepository;

    public function __construct(Transaction $transactionRepository)
    {
        parent::__construct($transactionRepository);
        $this->transactionRepository = $transactionRepository;
    }
}
