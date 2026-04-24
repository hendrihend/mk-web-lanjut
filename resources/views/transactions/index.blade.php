@extends('layouts.app_adminlte')

@section('title', 'Transaksi')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Daftar Transaksi</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Transaksi
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('transactions.index') }}" class="row g-3">
                <div class="col-md-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari kode/deskripsi..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">-- Status --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Menunggu
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>
                            Gagal
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">-- Tipe --</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>
                            Pemasukan
                        </option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>
                            Pengeluaran
                        </option>
                        <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>
                            Transfer
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_method" class="form-select">
                        <option value="">-- Metode Bayar --</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Kartu</option>
                        <option value="check" {{ request('payment_method') == 'check' ? 'selected' : '' }}>Cek</option>
                        <option value="other" {{ request('payment_method') == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="user_id" class="form-select">
                        <option value="">-- User --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Transaksi</h5>
                    <h3 class="text-primary">{{ $transactions->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <h3 class="text-warning">{{ $transactions->where('status', 'pending')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <h3 class="text-success">{{ $transactions->where('status', 'completed')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gagal/Dibatalkan</h5>
                    <h3 class="text-danger">{{ $transactions->where('status', 'failed')->count() + $transactions->where('status', 'cancelled')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kode Transaksi</th>
                    <th>User</th>
                    <th>Deskripsi</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                    <td><strong>{{ $transaction->transaction_code }}</strong></td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ Str::limit($transaction->description, 30) }}</td>
                    <td>
                        @if($transaction->type === 'income')
                        <span class="badge bg-success">Pemasukan</span>
                        @elseif($transaction->type === 'expense')
                        <span class="badge bg-danger">Pengeluaran</span>
                        @else
                        <span class="badge bg-info">Transfer</span>
                        @endif
                    </td>
                    <td class="text-end">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaction->payment_method) }}</td>
                    <td>
                        @if($transaction->status === 'pending')
                        <span class="badge bg-warning">Menunggu</span>
                        @elseif($transaction->status === 'completed')
                        <span class="badge bg-success">Selesai</span>
                        @elseif($transaction->status === 'failed')
                        <span class="badge bg-danger">Gagal</span>
                        @else
                        <span class="badge bg-secondary">Dibatalkan</span>
                        @endif
                    </td>
                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-info" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4">Tidak ada data transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection