<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getAll()
    {
        return Transaction::all();
    }

    public function findById($id)
    {
        return Transaction::find($id);
    }

    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function update($id, array $data)
    {
        $Transaction = Transaction::find($id);

        $Transaction->update($data);

        return $Transaction;
    }

    public function delete($id)
    {
        $Transaction = Transaction::find($id);

        return $Transaction->delete();
    }
}

