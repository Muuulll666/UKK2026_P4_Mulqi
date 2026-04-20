@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')

@section('content')
<div class="page-body-wrapper">

  {{-- Page sidebar start --}}
  <aside class="page-sidebar">
    
  <div class="left-arrow" id="left-arrow">
    <i data-feather="arrow-left"></i>
  </div>

  <div class="main-sidebar" id="main-sidebar">
    <ul class="sidebar-menu" id="simple-bar">

      {{-- GENERAL --}}
      <li class="sidebar-main-title">
        <div><h5 class="lan-1 f-w-700 sidebar-title">General</h5></div>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
          <svg class="stroke-icon">
            <use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Home-dashboard"></use>
          </svg>
          <h6>Dashboard</h6>
        </a>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
          <svg class="stroke-icon">
            <use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Folder"></use>
          </svg>
          <h6>Manajemen Buku</h6>
        </a>

        <ul class="sidebar-submenu">
          <li>
            <a href="{{ route('admin.buku.index') }}">Data Buku</a>
          </li>
          <li>
            <a href="{{ route('admin.pengarang.index') }}">Pengarang</a>
          </li>
          <li>
            <a href="{{ route('admin.penerbit.index') }}">Penerbit</a>
          </li>
          <li>
            <a href="{{ route('admin.rak.index') }}">Rak</a>
          </li>
          <li>
            <a href="{{ route('admin.kelas.index') }}">Kelas</a>
          </li>
          <li>
            <a href="{{ route('admin.kategori.index') }}">Kategori Buku</a>
          </li>
        </ul>
      </li>

  
      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('admin.user.index') }}">
          <svg class="stroke-icon">
            <use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Profile"></use>
          </svg>
          <h6>Kelola User</h6>
        </a>
      </li>

      
      <li class="sidebar-list">
        <a class="sidebar-link" href="{{ route('admin.laporan.index') }}">
          <svg class="stroke-icon">
            <use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Paper-plus"></use>
          </svg>
          <h6>Laporan</h6>
        </a>
      </li>

    </ul>
  </div>

  <div class="right-arrow" id="right-arrow">
    <i data-feather="arrow-right"></i>
  </div>
</aside>
  {{-- Page sidebar end --}}

  <div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-sm-6 col-12">
            <h2>Dashboard Admin</h2>
            <p class="mb-0 text-title-gray">Selamat datang, {{ auth()->user()->nama }} </p>
          </div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item">Dashboard</li>
              <li class="breadcrumb-item active">Admin</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid default-dashboard">
      <div class="row">

        {{-- Stats Cards --}}
        <div class="col-12 mb-3">
          <div class="row g-3">

            <div class="col-6 col-md-2">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-primary bg-opacity-10 text-primary d-inline-block mb-2">
                    <iconify-icon icon="solar:users-group-rounded-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['total_anggota'] }}</h4>
                  <span class="text-muted small">Anggota</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-2">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-info bg-opacity-10 text-info d-inline-block mb-2">
                    <iconify-icon icon="solar:user-id-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['total_petugas'] }}</h4>
                  <span class="text-muted small">Petugas</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-2">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-success bg-opacity-10 text-success d-inline-block mb-2">
                    <iconify-icon icon="solar:book-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['total_buku'] }}</h4>
                  <span class="text-muted small">Total Buku</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-2">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-warning bg-opacity-10 text-warning d-inline-block mb-2">
                    <iconify-icon icon="solar:clock-circle-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4>
                  <span class="text-muted small">Menunggu</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-2">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-primary bg-opacity-10 text-primary d-inline-block mb-2">
                    <iconify-icon icon="solar:document-text-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['total_dipinjam'] }}</h4>
                  <span class="text-muted small">Dipinjam</span>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-2">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-danger bg-opacity-10 text-danger d-inline-block mb-2">
                    <iconify-icon icon="solar:danger-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['terlambat'] }}</h4>
                  <span class="text-muted small">Terlambat</span>
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="col-12">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <div class="header-top">
                <h3>
                  <iconify-icon icon="solar:document-text-bold" class="text-primary me-1"></iconify-icon>
                  Transaksi Terbaru
                </h3>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="table-responsive theme-scrollbar">
                <table class="table display table-bordernone" style="width:100%">
                  <thead>
                    <tr>
                      <th>Anggota</th>
                      <th>Buku</th>
                      <th>Tgl Pinjam</th>
                      <th>Tgl Kembali</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($transaksiTerbaru as $t)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $t->user->nama }}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        @foreach($t->detailTransaksi as $d)
                          <div class="small">{{ $d->buku->judul }}</div>
                        @endforeach
                      </td>
                      <td>
                        <div class="flex-grow-1">
                          <h6>{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</h6>
                        </div>
                      </td>
                      <td>
                        <div class="flex-grow-1">
                          <h6>{{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}</h6>
                        </div>
                      </td>
                      <td class="text-end">
                        @php
                          $btnClass = match($t->status) {
                            'menunggu'     => 'bg-light-warning border-light-warning text-warning',
                            'dipinjam'     => 'bg-light-primary border-light-primary text-primary',
                            'dikembalikan' => 'bg-light-success border-light-success text-success',
                            'ditolak'      => 'bg-light-danger border-light-danger text-danger',
                            default        => 'bg-light-secondary text-secondary',
                          };
                        @endphp
                        <div class="btn {{ $btnClass }}">{{ ucfirst($t->status) }}</div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection