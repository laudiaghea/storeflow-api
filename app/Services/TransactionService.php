<?php

namespace App\Services;

use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\TransactionDetailRepositoryInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    private $transactionRepository;
    private $productRepository;
    private $customerRepository;
    private $transactionDetailRepository;

    public function __construct (
        TransactionRepositoryInterface $transactionRepository,
        ProductRepositoryInterface $productRepository,
        CustomerRepositoryInterface $customerRepository,
        TransactionDetailRepositoryInterface $transactionDetailRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->transactionDetailRepository = $transactionDetailRepository;
    }

    public function getAll()
    {
        return $this->transactionRepository->getAll();
    }

    public function findById($id)
    {
        return $this->transactionRepository->findById($id);
    }

    public function createTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
        // cek customer
        $customer = $this->customerRepository->findById($data['customer_id']);

        if (!$customer) {
            return null;
        }

        // simpan total transaksi
        $total = 0;

        // hitung total harga
        foreach ($data['items'] as $item) {
            // ambil data produk
            $product = $this->productRepository->findById($item['product_id']);

            // cek produk
            if (!$product) {
                return null;
            }

            // cek stok
            if ($product->stok < $item['qty']) {
                return null;
            }

            //hitung totak
            $total += $product->harga * $item['qty'];
        }

        //simpan transaksi
        $transaction = $this->transactionRepository->create([
            'customer_id' => $data['customer_id'],
            'total' => $total
        ]);

        // simpan detail transaksi
        foreach ($data['items'] as $item) {
            $product = $this->productRepository->findById($item['product_id']);

            $this->transactionDetailRepository->create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $item['qty'],
                'harga' => $product->harga
            ]);

            //mengurangi stok
            $this->productRepository->update($product->id, [
                'stok' => $product->stok - $item['qty']
            ]);
        }

        return $transaction;

        });
    }

    public function updateTransaction($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
        // ambil transaksi lama
        $transaction = $this->transactionRepository->findById($id);

        if (!$transaction) {
            return null;
        }

        // ambil detail lama
        $oldDetails = $transaction->transactionDetails;

        //kembalikan stok lama
        foreach ($oldDetails as $detail) {
            $product = $this->productRepository->findById($detail->product_id);

            $this->productRepository->update($product->id, [
                'stok' => $product->stok + $detail->qty
            ]);
        }

        // hitung total baru
        $total = 0;

        foreach ($data['items'] as $item) {
            $product = $this->productRepository->findById($item['product_id']);

            if (!$product) {
                return null;
            }

            if ($product->stok < $item['qty']) {
                return null;
            }

            $total += $product->harga * $item['qty'];
        }

        // update transaksi
        $transaction = $this->transactionRepository->update($id, [
            'customer_id' => $data['customer_id'],
            'total' => $total
        ]);

        //hapus detail lama
        foreach ($oldDetails as $detail) {
            $detail->delete();
        }

        // simpan detail baru & kurangi stok
        foreach ($data['items'] as $item) {
            $product = $this->productRepository->findById($item['product_id']);

            $this->transactionDetailRepository->create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $item['qty'],
                'harga' => $product->harga
            ]);

            $this->productRepository->update($product->id, [
                'stok' => $product->stok - $item['qty']
            ]);
        }

        return $transaction;

        });
    }

    public function deleteTransaction($id)
    {
        return DB::transaction(function () use ($id) {
            
        //ambil transaksi
        $transaction = $this->transactionRepository->findById($id);

        if (!$transaction) {
            return null;
        }

        //ambil detail transaksi
        $details = $transaction->transactionDetails;

        // kembalikan stok
        foreach ($details as $detail) {
            $product = $this->productRepository->findById($detail->product_id);

            $this->productRepository->update($product->id, [
                'stok' => $product->stok + $detail->qty
            ]);

            //hapus detail
            $detail->delete();
        }

        return $this->transactionRepository->delete($id);

        });
    }
}
