@extends('layouts.app_adminlte')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Detail Transaksi</h1>
                <div>
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $transaction->transaction_code }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kode Transaksi</label>
                            <p class="form-control-plaintext">{{ $transaction->transaction_code }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                @if($transaction->status === 'pending')
                                <span class="badge bg-warning">Menunggu</span>
                                @elseif($transaction->status === 'completed')
                                <span class="badge bg-success">Selesai</span>
                                @elseif($transaction->status === 'failed')
                                <span class="badge bg-danger">Gagal</span>
                                @else
                                <span class="badge bg-secondary">Dibatalkan</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">User</label>
                            <p class="form-control-plaintext">{{ $transaction->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipe Transaksi</label>
                            <p class="form-control-plaintext">
                                @if($transaction->type === 'income')
                                <span class="badge bg-success">Pemasukan</span>
                                @elseif($transaction->type === 'expense')
                                <span class="badge bg-danger">Pengeluaran</span>
                                @else
                                <span class="badge bg-info">Transfer</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <p class="form-control-plaintext">{{ $transaction->description }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jumlah</label>
                            <p class="form-control-plaintext fs-5 fw-bold text-primary">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <p class="form-control-plaintext">{{ ucfirst($transaction->payment_method) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Transaksi</label>
                            <p class="form-control-plaintext">{{ $transaction->created_at->format('d M Y - H:i') }}</p>
                        </div>
                    </div>

                    @if($transaction->notes)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Catatan</label>
                            <p class="form-control-plaintext">{{ $transaction->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Transaksi
                        </a>
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus Transaksi
                            </button>
                        </form>
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection