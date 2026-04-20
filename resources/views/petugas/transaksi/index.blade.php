@extends('layouts.dashboard')
@section('title', 'Transaksi Peminjaman')

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
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link {{ request()->routeIs('petugas.laporan.*') ? 'active' : '' }}" href="{{ route('petugas.laporan.index') }}">
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
          <div class="col-sm-6 col-12">
            <h2>Transaksi Peminjaman</h2>
            <p class="mb-0 text-title-gray">Kelola persetujuan dan pengembalian buku.</p>
          </div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item active">Transaksi</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
      @endif

      {{-- Filter Tabs --}}
      <div class="card mb-3">
        <div class="card-body py-2">
          <div class="d-flex gap-2 flex-wrap">
            @php
              $tabs = [
                'semua'        => ['label' => 'Semua',        'color' => 'secondary'],
                'menunggu'     => ['label' => 'Menunggu',     'color' => 'warning'],
                'dipinjam'     => ['label' => 'Dipinjam',     'color' => 'primary'],
                'dikembalikan' => ['label' => 'Dikembalikan', 'color' => 'success'],
                'ditolak'      => ['label' => 'Ditolak',      'color' => 'danger'],
              ];
            @endphp
            @foreach($tabs as $key => $tab)
            <a href="{{ route('petugas.transaksi.index', ['filter' => $key]) }}"
               class="btn btn-sm {{ $filter === $key ? 'btn-'.$tab['color'] : 'btn-outline-'.$tab['color'] }}">
              {{ $tab['label'] }}
              <span class="badge {{ $filter === $key ? 'bg-white text-'.$tab['color'] : 'bg-'.$tab['color'].' text-white' }} ms-1">
                {{ $counts[$key] }}
              </span>
            </a>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Tabel --}}
      <div class="card">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-3">#</th>
                  <th>Anggota</th>
                  <th>Buku</th>
                  <th>Tgl Pinjam</th>
                  <th>Jatuh Tempo</th>
                  <th>Status</th>
                  <th>Denda</th>
                  <th class="text-center pe-3">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($transaksi as $t)
                @php
                  $isLate = $t->status === 'dipinjam' && \Carbon\Carbon::parse($t->tanggal_kembali)->isPast();
                @endphp
                <tr class="{{ $isLate ? 'table-danger' : '' }}">
                  <td class="ps-3 text-muted small">{{ $t->id }}</td>
                  <td>
                    <div class="fw-semibold small">{{ $t->user?->nama ?? '-' }}</div>
                    <div class="text-muted" style="font-size:.72rem">{{ $t->user?->email ?? '' }}</div>
                  </td>
                  <td>
                    @foreach($t->detailTransaksi as $d)
                    <div class="small text-truncate" style="max-width:160px" title="{{ $d->buku?->judul }}">
                      <iconify-icon icon="solar:book-bold" class="text-primary me-1" width="12"></iconify-icon>
                      {{ $d->buku?->judul ?? '(hapus)' }}
                    </div>
                    @endforeach
                  </td>
                  <td class="small">{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}</td>
                  <td class="small">
                    {{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}
                    @if($isLate)
                      <div class="text-danger" style="font-size:.7rem">
                        +{{ \Carbon\Carbon::parse($t->tanggal_kembali)->diffInDays() }} hari
                      </div>
                    @endif
                  </td>
                  <td>
                    @php
                      $badge = match($t->status) {
                        'menunggu'     => 'bg-light-warning text-warning',
                        'dipinjam'     => 'bg-light-primary text-primary',
                        'dikembalikan' => 'bg-light-success text-success',
                        'ditolak'      => 'bg-light-danger text-danger',
                        default        => 'bg-secondary text-white',
                      };
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($t->status) }}</span>
                  </td>
                  <td class="small {{ $t->denda > 0 ? 'text-danger fw-semibold' : 'text-muted' }}">
                    {{ $t->denda > 0 ? 'Rp '.number_format($t->denda,0,',','.') : '-' }}
                  </td>
                  <td class="text-center pe-3">
                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                      <a href="{{ route('petugas.transaksi.show', $t->id) }}" class="btn btn-xs btn-outline-secondary" title="Detail">
                        <i data-feather="eye" style="width:14px;height:14px"></i>
                      </a>

                      @if($t->status === 'menunggu')
                        <form action="{{ route('petugas.transaksi.terima', $t->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Setujui peminjaman ini?')">
                          @csrf @method('PATCH')
                          <button type="submit" class="btn btn-xs btn-success" title="Terima">
                            <i data-feather="check" style="width:14px;height:14px"></i>
                          </button>
                        </form>
                        <form action="{{ route('petugas.transaksi.tolak', $t->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Tolak peminjaman ini?')">
                          @csrf @method('PATCH')
                          <button type="submit" class="btn btn-xs btn-danger" title="Tolak">
                            <i data-feather="x" style="width:14px;height:14px"></i>
                          </button>
                        </form>

                      @elseif($t->status === 'dipinjam')
                        <form action="{{ route('petugas.transaksi.kembalikan', $t->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Catat buku ini sudah dikembalikan?')">
                          @csrf @method('PATCH')
                          <button type="submit" class="btn btn-xs btn-primary" title="Kembalikan">
                            <iconify-icon icon="solar:arrow-left-bold" width="14"></iconify-icon>
                          </button>
                        </form>

                      @elseif($t->status === 'dikembalikan' && $t->denda > 0)
                        <form action="{{ route('petugas.transaksi.lunasi', $t->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Tandai denda sudah dibayar?')">
                          @csrf @method('PATCH')
                          <button type="submit" class="btn btn-xs btn-warning text-white" title="Lunasi Denda">
                            <iconify-icon icon="solar:wallet-bold" width="14"></iconify-icon>
                          </button>
                        </form>
                      @endif
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="text-center py-5 text-muted">
                    <iconify-icon icon="solar:document-text-bold" width="48" class="d-block mb-2 opacity-30"></iconify-icon>
                    Tidak ada transaksi.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="mt-3 d-flex justify-content-center">
        {{ $transaksi->links() }}
      </div>

    </div>
  </div>
</div>

@push('scripts')
<style>
.btn-xs { padding: 3px 8px; font-size: .75rem; }
</style>
@endpush
@endsection
