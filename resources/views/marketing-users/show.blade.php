@extends('layouts.app_adminlte')

@section('title', 'Detail Marketing User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Detail Marketing User</h1>
                <div>
                    <a href="{{ route('marketing-users.edit', $marketingUser) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('marketing-users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
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
                            <h5 class="text-muted">Nama</h5>
                            <p class="lead">{{ $marketingUser->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Email</h5>
                            <p class="lead">
                                <a href="mailto:{{ $marketingUser->email }}">{{ $marketingUser->email }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Nomor Telepon</h5>
                            <p class="lead">
                                @if($marketingUser->phone)
                                <a href="tel:{{ $marketingUser->phone }}">{{ $marketingUser->phone }}</a>
                                @else
                                <span class="text-secondary">-</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Status</h5>
                            <p class="lead">
                                @if($marketingUser->status === 'active')
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Posisi</h5>
                            <p class="lead">{{ $marketingUser->position ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Department</h5>
                            <p class="lead">{{ $marketingUser->department ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Territory</h5>
                            <p class="lead">{{ $marketingUser->territory ?? '-' }}</p>
                        </div>
                    </div>

                    @if($marketingUser->notes)
                    <div class="mb-4">
                        <h5 class="text-muted">Catatan</h5>
                        <div class="alert alert-light border">
                            {{ $marketingUser->notes }}
                        </div>
                    </div>
                    @endif

                    <div class="mb-4">
                        <small class="text-muted">
                            <p>Dibuat: {{ $marketingUser->created_at->format('d/m/Y H:i') }}</p>
                            <p>Diperbarui: {{ $marketingUser->updated_at->format('d/m/Y H:i') }}</p>
                        </small>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('marketing-users.edit', $marketingUser) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Data
                        </a>
                        <form action="{{ route('marketing-users.destroy', $marketingUser) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('marketing-users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection