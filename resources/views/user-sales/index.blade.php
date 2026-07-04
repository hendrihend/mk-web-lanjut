@extends('layouts.app_adminlte')

@section('title', 'User Sales')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Daftar User Sales</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('user-sales.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah User Sales
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
            <form method="GET" action="{{ route('user-sales.index') }}" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, email..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="region" class="form-select">
                        <option value="">-- Pilih Region --</option>
                        @foreach($regions as $reg)
                        <option value="{{ $reg }}" {{ request('region') == $reg ? 'selected' : '' }}>
                            {{ $reg }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
                @if(request('search') || request('region'))
                <div class="col-md-3">
                    <a href="{{ route('user-sales.index') }}" class="btn btn-light w-100">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Sales</th>
                        <th>Email</th>
                        <th>Region</th>
                        <th class="d-none d-md-table-cell">Quota</th>
                        <th class="d-none d-md-table-cell">Achievement</th>
                        <th>% Pencapaian</th>
                        <th class="d-none d-lg-table-cell">Komisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userSales as $sales)
                    <tr>
                        <td>{{ ($userSales->currentPage() - 1) * $userSales->perPage() + $loop->iteration }}</td>
                        <td><strong>{{ $sales->sales_name }}</strong></td>
                        <td>{{ $sales->email }}</td>
                        <td>{{ $sales->region }}</td>
                        <td class="d-none d-md-table-cell">Rp {{ number_format($sales->quota, 0, ',', '.') }}</td>
                        <td class="d-none d-md-table-cell">Rp {{ number_format($sales->achievement, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $sales->achievement_percentage >= 100 ? 'success' : ($sales->achievement_percentage >= 75 ? 'warning' : 'danger') }}">
                                {{ $sales->achievement_percentage }}%
                            </span>
                        </td>
                        <td class="d-none d-lg-table-cell">Rp {{ number_format($sales->commission, 0, ',', '.') }}</td>
                        <td>
                            @if($sales->status === 'active')
                            <span class="badge bg-success">Aktif</span>
                            @else
                            <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('user-sales.show', $sales) }}" class="btn btn-info btn-sm" title="Lihat">
                                    <i class="fas fa-eye"></i> <span class="d-none d-lg-inline">Lihat</span>
                                </a>
                                <a href="{{ route('user-sales.edit', $sales) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i> <span class="d-none d-lg-inline">Edit</span>
                                </a>
                                <form action="{{ route('user-sales.destroy', $sales) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus?')">
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
                        <td colspan="10" class="text-center py-4">
                            <p class="mb-0">Tidak ada data User Sales</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer">
            {{ $userSales->links() }}
        </div>
    </div>
</div>
@endsection