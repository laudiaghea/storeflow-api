<?php

namespace App\Repositories;

use App\Models\TransactionDetail;
use App\Repositories\Interfaces\TransactionDetailRepositoryInterface;

class TransactionDetailRepository implements TransactionDetailRepositoryInterface
{
    public function getAll()
    {
        return TransactionDetail::all();
    }

    public function findById($id)
    {
        return TransactionDetail::find($id);
    }

    public function create(array $data)
    {
        return TransactionDetail::create($data);
    }

    public function update($id, array $data)
    {
        $TransactionDetail = TransactionDetail::find($id);

        $TransactionDetail->update($data);

        return $TransactionDetail;
    }

    public function delete($id)
    {
        $TransactionDetail = TransactionDetail::find($id);

        return $TransactionDetail->delete();
    }
}
