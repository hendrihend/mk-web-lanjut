@extends('layouts.app_adminlte')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Edit Transaksi</h1>

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validasi Gagal!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('transactions.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="transaction_code" class="form-label">Kode Transaksi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('transaction_code') is-invalid @enderror"
                                id="transaction_code" name="transaction_code" value="{{ old('transaction_code', $transaction->transaction_code) }}" required>
                            @error('transaction_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror"
                                id="user_id" name="user_id" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $transaction->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Transaksi <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                id="type" name="type" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                                <option value="transfer" {{ old('type', $transaction->type) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="3" required>{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" required>
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_method') is-invalid @enderror"
                                id="payment_method" name="payment_method" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="cash" {{ old('payment_method', $transaction->payment_method) == 'cash' ? 'selected' : '' }}>Tunai</option>
                                <option value="transfer" {{ old('payment_method', $transaction->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="card" {{ old('payment_method', $transaction->payment_method) == 'card' ? 'selected' : '' }}>Kartu</option>
                                <option value="check" {{ old('payment_method', $transaction->payment_method) == 'check' ? 'selected' : '' }}>Cek</option>
                                <option value="other" {{ old('payment_method', $transaction->payment_method) == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="failed" {{ old('status', $transaction->status) == 'failed' ? 'selected' : '' }}>Gagal</option>
                                <option value="cancelled" {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                id="notes" name="notes" rows="2">{{ old('notes', $transaction->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Update Transaksi
                            </button>
                            <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection