<?php

namespace App\Services;

use App\Repositories\Interfaces\TransactionDetailRepositoryInterface;

class TransactionDetailService
{
    private $transactionDetailRepository;

    public function __construct(TransactionDetailRepositoryInterface $transactionDetailRepository)
    {
        $this->transactionDetailRepository = $transactionDetailRepository;
    }

    public function getAll()
    {
        return $this->transactionDetailRepository->getAll();
    }

    public function findById($id)
    {
        return $this->transactionDetailRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->transactionDetailRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->transactionDetailRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->transactionDetailRepository->delete($id);
    }
}
