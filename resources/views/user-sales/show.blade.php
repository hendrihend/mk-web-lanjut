@extends('layouts.app_adminlte')

@section('title', 'Detail User Sales')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>Detail User Sales</h1>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('user-sales.edit', $userSale) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('user-sales.index') }}" class="btn btn-secondary">
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
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Nama Sales</h5>
                            <p class="fs-5"><strong>{{ $userSale->sales_name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Email</h5>
                            <p class="fs-5">{{ $userSale->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Nomor Telepon</h5>
                            <p class="fs-5">{{ $userSale->phone ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Region</h5>
                            <p class="fs-5">{{ $userSale->region }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Quota</h5>
                            <p class="fs-5">Rp {{ number_format($userSale->quota, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Pencapaian</h5>
                            <p class="fs-5">Rp {{ number_format($userSale->achievement, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">% Pencapaian</h5>
                            <p class="fs-5">
                                <span class="badge bg-{{ $userSale->achievement_percentage >= 100 ? 'success' : ($userSale->achievement_percentage >= 75 ? 'warning' : 'danger') }}">
                                    {{ $userSale->achievement_percentage }}%
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Komisi</h5>
                            <p class="fs-5"><strong>Rp {{ number_format($userSale->commission, 0, ',', '.') }}</strong></p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Tingkat Komisi</h5>
                            <p class="fs-5">{{ $userSale->commission_rate }}%</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">Status</h5>
                            <p class="fs-5">
                                @if($userSale->status === 'active')
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($userSale->notes)
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="text-muted mb-2">Catatan</h5>
                            <p>{{ $userSale->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-muted mb-3">Informasi Tambahan</h5>
                            <small class="text-muted">
                                Dibuat: {{ $userSale->created_at->format('d-m-Y H:i:s') }}<br>
                                Diperbarui: {{ $userSale->updated_at->format('d-m-Y H:i:s') }}
                            </small>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('user-sales.edit', $userSale) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('user-sales.destroy', $userSale) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus User Sales ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('user-sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection