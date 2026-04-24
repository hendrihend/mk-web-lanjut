@extends('layouts.app_adminlte')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Marketing Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('marketing-users.index') }}" class="small-box-footer">Lihat daftar <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $activeUsers }}</h3>
                <p>Active Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
            <a href="{{ route('marketing-users.index', ['status' => 'active']) }}" class="small-box-footer">Lihat aktif <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $inactiveUsers }}</h3>
                <p>Inactive Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-clock"></i>
            </div>
            <a href="{{ route('marketing-users.index', ['status' => 'inactive']) }}" class="small-box-footer">Lihat tidak aktif <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $departments }}</h3>
                <p>Departments</p>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
            <a href="{{ route('marketing-users.index') }}" class="small-box-footer">Lihat department <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tindakan Cepat</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('marketing-users.create') }}" class="btn btn-app bg-success">
                            <i class="fas fa-user-plus"></i> Tambah User
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('marketing-users.index') }}" class="btn btn-app bg-info">
                            <i class="fas fa-list"></i> Daftar Users
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('marketing-users.index') }}" class="btn btn-app bg-warning">
                            <i class="fas fa-search"></i> Filter Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection