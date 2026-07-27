<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::with('category')->get();
    }

    public function findById($id)
    {
        return Product::with('category')->find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::with('category')->find($id);

        $product->update($data);

        return $product;
    }

    public function delete($id)
    {
        $product = Product::find($id);

        return $product->delete();
    }

    public function chunk(int $count, callable $callback)
    {
        return Product::chunk($count, $callback);
    }
}
