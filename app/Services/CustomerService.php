<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Exceptions\NotFoundException;

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
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            throw new NotFoundException("Customer tidak ditemukan");
        }

        return $customer;
    }

    public function create(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function update($id, array $data)
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            throw new NotFoundException("Customer tidak ditemukan");
        }

        return $this->customerRepository->update($id, $data);
    }

    public function delete($id)
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            throw new NotFoundException("Customer tidak ditemukan");
        }

        return $this->customerRepository->delete($id);
    }
}
