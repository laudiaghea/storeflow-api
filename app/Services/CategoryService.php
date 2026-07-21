<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Exceptions\NotFoundException;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }

    public function findById($id)
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw new NotFoundException("Category tidak ditemukan");
        }

        return $category;
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw new NotFoundException("Category tidak ditemukan");
        }

        return $this->categoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw new NotFoundException("Category tidak ditemukan");
        }

        return $this->categoryRepository->delete($id);
    }
}
