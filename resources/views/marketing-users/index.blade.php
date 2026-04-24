@extends('layouts.app_adminlte')

@section('title', 'Marketing Users')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Daftar Marketing Users</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('marketing-users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Marketing User
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
            <form method="GET" action="{{ route('marketing-users.index') }}" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, email, phone..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">-- Pilih Status --</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name="department" class="form-control" placeholder="Department"
                        value="{{ request('department') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="territory" class="form-control" placeholder="Territory"
                        value="{{ request('territory') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Territory</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($marketingUsers as $user)
                <tr>
                    <td>{{ ($marketingUsers->currentPage() - 1) * $marketingUsers->perPage() + $loop->iteration }}</td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->position ?? '-' }}</td>
                    <td>{{ $user->department ?? '-' }}</td>
                    <td>{{ $user->territory ?? '-' }}</td>
                    <td>
                        @if($user->status === 'active')
                        <span class="badge bg-success">Aktif</span>
                        @else
                        <span class="badge bg-danger">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('marketing-users.show', $user) }}" class="btn btn-info" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('marketing-users.edit', $user) }}" class="btn btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('marketing-users.destroy', $user) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                    <td colspan="9" class="text-center py-4">
                        <p class="text-muted">Tidak ada data marketing users</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $marketingUsers->links() }}
    </div>
</div>
@endsection