<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Exceptions\NotFoundException;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    public function findById($id)
    {
        $product =  $this->productRepository->findById($id);

        if (!$product) {
            throw new NotFoundException("Product tidak ditemukan");
        }

        return $product;

    }

    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            throw new NotFoundException("Produk tidak ditemukan");
        }

        return $this->productRepository->update($id, $data);
    }

    public function delete($id)
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            throw new NotFoundException("Produk tidak ditemukan");
        }

        return $this->productRepository->delete($id);;
    }
}
