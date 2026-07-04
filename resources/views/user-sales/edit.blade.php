@extends('layouts.app_adminlte')

@section('title', 'Edit User Sales')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Edit User Sales</h1>

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
                    <form action="{{ route('user-sales.update', $userSale) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="sales_name" class="form-label">Nama Sales <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sales_name') is-invalid @enderror"
                                id="sales_name" name="sales_name" value="{{ old('sales_name', $userSale->sales_name) }}" required>
                            @error('sales_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', $userSale->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" name="phone" value="{{ old('phone', $userSale->phone) }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="region" class="form-label">Region <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('region') is-invalid @enderror"
                                id="region" name="region" value="{{ old('region', $userSale->region) }}" required>
                            @error('region')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quota" class="form-label">Quota (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('quota') is-invalid @enderror"
                                        id="quota" name="quota" value="{{ old('quota', $userSale->quota) }}" step="0.01" required>
                                    @error('quota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="achievement" class="form-label">Pencapaian (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('achievement') is-invalid @enderror"
                                        id="achievement" name="achievement" value="{{ old('achievement', $userSale->achievement) }}" step="0.01" required>
                                    @error('achievement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="commission_rate" class="form-label">Tingkat Komisi (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('commission_rate') is-invalid @enderror"
                                id="commission_rate" name="commission_rate" value="{{ old('commission_rate', $userSale->commission_rate) }}" step="0.01" required>
                            @error('commission_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="active" {{ old('status', $userSale->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $userSale->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $userSale->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Update
                            </button>
                            <a href="{{ route('user-sales.show', $userSale) }}" class="btn btn-secondary">
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