<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = $this->transactionService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $transactions
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        $transaction = $this->transactionService->createTransaction($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dibuat',
            'data' => $transaction
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = $this->transactionService->findById($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $transaction
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, string $id)
    {
        $transaction = $this->transactionService->updateTransaction($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'data' => $transaction
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = $this->transactionService->deleteTransaction($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
