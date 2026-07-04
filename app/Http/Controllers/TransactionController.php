<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExcelExport;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->buildQuery($request);
        $transactions = $query->latest()->paginate(15);
        $users = User::all();

        return view('transactions.index', compact('transactions', 'users'));
    }

    public function export(Request $request)
    {
        $query = $this->buildQuery($request);
        $transactions = $query->latest()->get();

        return (new TransactionExcelExport($transactions))->download('transactions-' . now()->format('Ymd_His') . '.xlsx');
    }

    protected function buildQuery(Request $request)
    {
        $query = Transaction::query()->with('user');

        // Filter berdasarkan search
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('transaction_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter berdasarkan tipe transaksi
        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        // Filter berdasarkan payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->get('payment_method'));
        }

        // Filter berdasarkan date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('transactions.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_code' => 'required|string|unique:transactions,transaction_code',
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,card,check,other',
            'status' => 'required|in:pending,completed,failed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $transaction = Transaction::create($validated);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $users = User::all();
        return view('transactions.edit', compact('transaction', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'transaction_code' => 'required|string|unique:transactions,transaction_code,' . $transaction->id,
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,card,check,other',
            'status' => 'required|in:pending,completed,failed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
