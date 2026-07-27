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

    public function increasePrice(int $percent)
    {
        $this->productRepository->chunk(100, function ($products) use ($percent) {
            foreach ($products as $product) {
                $newPrice = $product->harga * (1 + ($percent / 100));

                $this->productRepository->update($product->id, [
                    'harga' => $newPrice
                ]);
            }
        });

        return [
           'message' => 'Harga semua produk berhasil dinaikan sebesar ' . $percent . '%'
        ];
    }
}
