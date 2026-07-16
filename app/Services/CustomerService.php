<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerService
{
    private $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll()
    {
        return $this->customerRepository->getAll();
    }

    public function findById($id)
    {
        return $this->customerRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->customerRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->customerRepository->delete($id);
    }
}
