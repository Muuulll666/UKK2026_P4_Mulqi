@extends('layouts.dashboard')
@section('title', 'Dashboard Petugas')

@section('content')
<div class="page-body-wrapper">

  {{-- Sidebar --}}
  <aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
      <ul class="sidebar-menu" id="simple-bar">
        <li class="sidebar-main-title">
          <div><h5 class="lan-1 f-w-700 sidebar-title">Menu Petugas</h5></div>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Home-dashboard') }}"></use></svg>
            <h6 class="f-w-600">Dashboard</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link {{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}" href="{{ route('petugas.transaksi.index') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Paper') }}"></use></svg>
            <h6 class="f-w-600">Transaksi Peminjaman</h6>
          </a>
        </li>
      </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
  </aside>

  <div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-sm-6 col-12">
            <h2>Dashboard Petugas 📋</h2>
            <p class="mb-0 text-title-gray">Selamat datang, {{ auth()->user()->nama }}</p>
          </div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid default-dashboard">
      <div class="row">

        {{-- Stats --}}
        <div class="col-12 mb-3">
          <div class="row g-3">
            <div class="col-6 col-md-3">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-warning bg-opacity-10 text-warning d-inline-block mb-2">
                    <iconify-icon icon="solar:clock-circle-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4>
                  <span class="text-muted small">Menunggu Persetujuan</span>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-primary bg-opacity-10 text-primary d-inline-block mb-2">
                    <iconify-icon icon="solar:book-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['dipinjam'] }}</h4>
                  <span class="text-muted small">Sedang Dipinjam</span>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-success bg-opacity-10 text-success d-inline-block mb-2">
                    <iconify-icon icon="solar:check-circle-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['dikembalikan'] }}</h4>
                  <span class="text-muted small">Dikembalikan</span>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
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

        {{-- Menunggu Persetujuan --}}
        <div class="col-lg-6 col-12">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <div class="header-top">
                <h3><iconify-icon icon="solar:clock-circle-bold" class="text-warning me-1"></iconify-icon> Menunggu Persetujuan</h3>
                <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-light btn-sm">Lihat Semua</a>
              </div>
            </div>
            <div class="card-body pt-2">
              @forelse($menunggu as $t)
              <div class="d-flex align-items-start gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="p-2 rounded bg-warning bg-opacity-10 text-warning">
                  <iconify-icon icon="solar:user-bold" width="18"></iconify-icon>
                </div>
                <div class="flex-grow-1" style="min-width:0">
                  <div class="fw-semibold small">{{ $t->user->nama }}</div>
                  @foreach($t->detailTransaksi as $d)
                    <div class="text-muted" style="font-size:.75rem">{{ $d->buku->judul }}</div>
                  @endforeach
                  <div class="text-muted" style="font-size:.75rem">
                    {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}
                  </div>
                </div>
                <div class="d-flex gap-1">
                  <form method="POST" action="{{ route('petugas.transaksi.terima', $t->id) }}">
                    @csrf @method('PATCH')
                    <button class="btn bg-light-success border-light-success text-success btn-sm">Terima</button>
                  </form>
                  <form method="POST" action="{{ route('petugas.transaksi.tolak', $t->id) }}">
                    @csrf @method('PATCH')
                    <button class="btn bg-light-danger border-light-danger text-danger btn-sm">Tolak</button>
                  </form>
                </div>
              </div>
              @empty
              <div class="text-center text-muted py-4 small">Tidak ada transaksi menunggu</div>
              @endforelse
            </div>
          </div>
        </div>

        {{-- Terlambat --}}
        <div class="col-lg-6 col-12">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <div class="header-top">
                <h3><iconify-icon icon="solar:danger-bold" class="text-danger me-1"></iconify-icon> Peminjaman Terlambat</h3>
              </div>
            </div>
            <div class="card-body pt-2">
              @forelse($terlambat as $t)
              <div class="d-flex align-items-start gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="p-2 rounded bg-danger bg-opacity-10 text-danger">
                  <iconify-icon icon="solar:user-bold" width="18"></iconify-icon>
                </div>
                <div class="flex-grow-1" style="min-width:0">
                  <div class="fw-semibold small">{{ $t->user->nama }}</div>
                  @foreach($t->detailTransaksi as $d)
                    <div class="text-muted" style="font-size:.75rem">{{ $d->buku->judul }}</div>
                  @endforeach
                  <div class="btn bg-light-danger border-light-danger text-danger btn-sm mt-1" style="font-size:.7rem;padding:2px 8px">
                    Terlambat {{ \Carbon\Carbon::parse($t->tanggal_kembali)->diffInDays() }} hari
                  </div>
                </div>
                <a href="{{ route('petugas.transaksi.show', $t->id) }}" class="btn bg-light-danger border-light-danger text-danger btn-sm">
                  <i data-feather="arrow-right" style="width:14px;height:14px"></i>
                </a>
              </div>
              @empty
              <div class="text-center text-muted py-4 small">Tidak ada peminjaman terlambat</div>
              @endforelse
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection
