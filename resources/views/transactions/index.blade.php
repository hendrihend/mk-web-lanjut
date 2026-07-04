@extends('layouts.app_adminlte')

@section('title', 'Transaksi')

@section('content')
<div class="container-fluid px-0 px-md-2">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Daftar Transaksi</h1>
            <p class="text-muted mb-0">Kelola semua transaksi dengan filter dan export yang lebih praktis.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('transactions.export', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Transaksi
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('transactions.index') }}" class="row g-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <label class="form-label small text-muted">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Kode / deskripsi"
                        value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label small text-muted">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label small text-muted">Tipe</label>
                    <select name="type" class="form-select">
                        <option value="">Semua</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label small text-muted">Metode</label>
                    <select name="payment_method" class="form-select">
                        <option value="">Semua</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Kartu</option>
                        <option value="check" {{ request('payment_method') == 'check' ? 'selected' : '' }}>Cek</option>
                        <option value="other" {{ request('payment_method') == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <label class="form-label small text-muted">User</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-1">Total Transaksi</h6>
                            <h3 class="mb-0">{{ $transactions->total() }}</h3>
                        </div>
                        <span class="badge bg-primary-subtle text-primary"><i class="fas fa-list"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-1">Menunggu</h6>
                            <h3 class="mb-0 text-warning">{{ $transactions->where('status', 'pending')->count() }}</h3>
                        </div>
                        <span class="badge bg-warning-subtle text-warning"><i class="fas fa-clock"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-1">Selesai</h6>
                            <h3 class="mb-0 text-success">{{ $transactions->where('status', 'completed')->count() }}</h3>
                        </div>
                        <span class="badge bg-success-subtle text-success"><i class="fas fa-check-circle"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted mb-1">Gagal / Dibatalkan</h6>
                            <h3 class="mb-0 text-danger">{{ $transactions->where('status', 'failed')->count() + $transactions->where('status', 'cancelled')->count() }}</h3>
                        </div>
                        <span class="badge bg-danger-subtle text-danger"><i class="fas fa-exclamation-circle"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th class="d-none d-md-table-cell">User</th>
                            <th class="d-none d-lg-table-cell">Deskripsi</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th class="d-none d-md-table-cell">Metode</th>
                            <th>Status</th>
                            <th class="d-none d-md-table-cell">Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                            <td><strong>{{ $transaction->transaction_code }}</strong></td>
                            <td class="d-none d-md-table-cell">{{ $transaction->user->name }}</td>
                            <td class="d-none d-lg-table-cell">{{ Str::limit($transaction->description, 30) }}</td>
                            <td>
                                @if($transaction->type === 'income')
                                <span class="badge bg-success">Pemasukan</span>
                                @elseif($transaction->type === 'expense')
                                <span class="badge bg-danger">Pengeluaran</span>
                                @else
                                <span class="badge bg-info">Transfer</span>
                                @endif
                            </td>
                            <td class="text-end fw-semibold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            <td class="d-none d-md-table-cell">{{ ucfirst($transaction->payment_method) }}</td>
                            <td>
                                @if($transaction->status === 'pending')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($transaction->status === 'completed')
                                <span class="badge bg-success">Selesai</span>
                                @elseif($transaction->status === 'failed')
                                <span class="badge bg-danger">Gagal</span>
                                @else
                                <span class="badge bg-secondary">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell">{{ $transaction->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-info btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i> <span class="d-none d-lg-inline">Lihat</span>
                                    </a>
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i> <span class="d-none d-lg-inline">Edit</span>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i> <span class="d-none d-lg-inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection