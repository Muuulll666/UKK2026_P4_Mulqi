@extends('layouts.dashboard')
@section('title', 'Laporan Peminjaman')

@section('content')
<div class="page-body-wrapper">
  <aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
      <ul class="sidebar-menu" id="simple-bar">
        <li class="sidebar-main-title"><div><h5 class="lan-1 f-w-700 sidebar-title">Menu Petugas</h5></div></li>
        <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Home-dashboard') }}"></use></svg>
            <h6 class="f-w-600">Dashboard</h6>
          </a>
        </li>
        <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link {{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}" href="{{ route('petugas.transaksi.index') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Paper') }}"></use></svg>
            <h6 class="f-w-600">Transaksi Peminjaman</h6>
          </a>
        </li>
        <li class="sidebar-list active"><i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link active" href="{{ route('petugas.laporan.index') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Document') }}"></use></svg>
            <h6 class="f-w-600">Laporan</h6>
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
          <div class="col-sm-6 col-12"><h2>Laporan Peminjaman</h2></div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item">Petugas</li>
              <li class="breadcrumb-item active">Laporan</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid default-dashboard">

      {{-- Filter --}}
      <div class="card mb-3">
        <div class="card-body py-3">
          <form method="GET" action="{{ route('petugas.laporan.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
              <label class="form-label fw-semibold mb-1">Bulan</label>
              <select name="bulan" class="form-select form-select-sm">
                @foreach($bulanList as $b)
                  <option value="{{ $b['value'] }}" @selected($b['value'] == $bulan)>{{ $b['label'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold mb-1">Tahun</label>
              <select name="tahun" class="form-select form-select-sm">
                @foreach($tahunList as $t)
                  <option value="{{ $t }}" @selected($t == $tahun)>{{ $t }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary btn-sm w-100">
                <iconify-icon icon="solar:filter-bold" class="me-1"></iconify-icon> Filter
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- Stats --}}
      <div class="row g-3 mb-3">
        <div class="col-6 col-md-2">
          <div class="card text-center"><div class="card-body">
            <div class="p-2 rounded bg-primary bg-opacity-10 text-primary d-inline-block mb-2"><iconify-icon icon="solar:document-text-bold" width="24"></iconify-icon></div>
            <h4 class="mb-0 fw-bold">{{ $stats['total'] }}</h4><span class="text-muted small">Total</span>
          </div></div>
        </div>
        <div class="col-6 col-md-2">
          <div class="card text-center"><div class="card-body">
            <div class="p-2 rounded bg-warning bg-opacity-10 text-warning d-inline-block mb-2"><iconify-icon icon="solar:clock-circle-bold" width="24"></iconify-icon></div>
            <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4><span class="text-muted small">Menunggu</span>
          </div></div>
        </div>
        <div class="col-6 col-md-2">
          <div class="card text-center"><div class="card-body">
            <div class="p-2 rounded bg-primary bg-opacity-10 text-primary d-inline-block mb-2"><iconify-icon icon="solar:book-bold" width="24"></iconify-icon></div>
            <h4 class="mb-0 fw-bold">{{ $stats['dipinjam'] }}</h4><span class="text-muted small">Dipinjam</span>
          </div></div>
        </div>
        <div class="col-6 col-md-2">
          <div class="card text-center"><div class="card-body">
            <div class="p-2 rounded bg-success bg-opacity-10 text-success d-inline-block mb-2"><iconify-icon icon="solar:check-circle-bold" width="24"></iconify-icon></div>
            <h4 class="mb-0 fw-bold">{{ $stats['dikembalikan'] }}</h4><span class="text-muted small">Dikembalikan</span>
          </div></div>
        </div>
        <div class="col-6 col-md-2">
          <div class="card text-center"><div class="card-body">
            <div class="p-2 rounded bg-danger bg-opacity-10 text-danger d-inline-block mb-2"><iconify-icon icon="solar:close-circle-bold" width="24"></iconify-icon></div>
            <h4 class="mb-0 fw-bold">{{ $stats['ditolak'] }}</h4><span class="text-muted small">Ditolak</span>
          </div></div>
        </div>
        <div class="col-6 col-md-2">
          <div class="card text-center"><div class="card-body">
            <div class="p-2 rounded bg-success bg-opacity-10 text-success d-inline-block mb-2"><iconify-icon icon="solar:wallet-money-bold" width="24"></iconify-icon></div>
            <h5 class="mb-0 fw-bold" style="font-size:.9rem">Rp {{ number_format($stats['total_denda'],0,',','.') }}</h5>
            <span class="text-muted small">Total Denda</span>
          </div></div>
        </div>
      </div>

      {{-- Tabel --}}
      <div class="card">
        <div class="card-header card-no-border pb-0">
          <div class="header-top">
            <h3><iconify-icon icon="solar:document-text-bold" class="text-primary me-1"></iconify-icon> Detail Transaksi</h3>
            <span class="text-muted small">{{ \Carbon\Carbon::create()->month($bulan)->locale('id')->isoFormat('MMMM') }} {{ $tahun }}</span>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="table-responsive theme-scrollbar mt-3">
            <table class="table display table-bordernone" style="width:100%">
              <thead>
                <tr><th>No</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Lama</th><th class="text-center">Status</th><th class="text-end">Denda</th></tr>
              </thead>
              <tbody>
                @forelse($transaksi as $i => $t)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td><h6 class="mb-0">{{ $t->user->nama ?? '-' }}</h6></td>
                  <td>
                    @foreach($t->detailTransaksi as $d)
                      <div class="small">{{ $d->buku->judul ?? '-' }}</div>
                    @endforeach
                  </td>
                  <td>{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}</td>
                  <td><span class="badge bg-light-info text-info">{{ $t->lama_pinjam ?? 7 }} hari</span></td>
                  <td class="text-center">
                    @php $cls = match($t->status) { 'menunggu'=>'warning','dipinjam'=>'primary','dikembalikan'=>'success','ditolak'=>'danger',default=>'secondary' }; @endphp
                    <span class="badge bg-light-{{ $cls }} text-{{ $cls }}">{{ ucfirst($t->status) }}</span>
                  </td>
                  <td class="text-end">
                    @if($t->denda > 0)
                      <span class="text-danger fw-semibold small">Rp {{ number_format($t->denda,0,',','.') }}</span>
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada transaksi pada periode ini</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
