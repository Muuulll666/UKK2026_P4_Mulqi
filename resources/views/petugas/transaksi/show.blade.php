@extends('layouts.dashboard')
@section('title', 'Detail Transaksi #'.$transaksi->id)

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
          <a class="sidebar-link" href="{{ route('petugas.dashboard') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Home-dashboard') }}"></use></svg>
            <h6 class="f-w-600">Dashboard</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link active" href="{{ route('petugas.transaksi.index') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Paper') }}"></use></svg>
            <h6 class="f-w-600">Transaksi Peminjaman</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('petugas.laporan.index') }}">
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
            <h2>Detail Transaksi #{{ $transaksi->id }}</h2>
          </div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item"><a href="{{ route('petugas.transaksi.index') }}">Transaksi</a></li>
              <li class="breadcrumb-item active">#{{ $transaksi->id }}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
      @endif

      <div class="row">
        {{-- Info Anggota --}}
        <div class="col-md-4 mb-3">
          <div class="card h-100">
            <div class="card-header card-no-border pb-0">
              <h5><iconify-icon icon="solar:user-bold" class="text-primary me-1"></iconify-icon> Info Anggota</h5>
            </div>
            <div class="card-body">
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px;height:52px;flex-shrink:0;">
                  <span class="fw-bold text-primary fs-5">{{ strtoupper(substr($transaksi->user?->nama ?? 'U', 0, 1)) }}</span>
                </div>
                <div>
                  <div class="fw-semibold">{{ $transaksi->user?->nama ?? '-' }}</div>
                  <div class="text-muted small">{{ $transaksi->user?->email ?? '-' }}</div>
                  <span class="badge bg-light-primary text-primary">Anggota</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Info Transaksi --}}
        <div class="col-md-4 mb-3">
          <div class="card h-100">
            <div class="card-header card-no-border pb-0">
              <h5><iconify-icon icon="solar:document-text-bold" class="text-warning me-1"></iconify-icon> Info Transaksi</h5>
            </div>
            <div class="card-body">
              @php
                $badge = match($transaksi->status) {
                  'menunggu'     => 'bg-light-warning text-warning',
                  'dipinjam'     => 'bg-light-primary text-primary',
                  'dikembalikan' => 'bg-light-success text-success',
                  'ditolak'      => 'bg-light-danger text-danger',
                  default        => 'bg-secondary text-white',
                };
                $isLate = $transaksi->status === 'dipinjam' && \Carbon\Carbon::parse($transaksi->tanggal_kembali)->isPast();
              @endphp
              <table class="table table-sm table-borderless mb-0">
                <tr>
                  <td class="text-muted small pe-3">Status</td>
                  <td><span class="badge {{ $badge }}">{{ ucfirst($transaksi->status) }}</span></td>
                </tr>
                <tr>
                  <td class="text-muted small">Tgl Pinjam</td>
                  <td class="small">{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
                </tr>
                <tr>
                  <td class="text-muted small">Jatuh Tempo</td>
                  <td class="small {{ $isLate ? 'text-danger fw-semibold' : '' }}">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}
                    @if($isLate)
                      <span class="text-danger">(+{{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->diffInDays() }} hari)</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="text-muted small">Denda</td>
                  <td class="small {{ $transaksi->denda > 0 ? 'text-danger fw-semibold' : '' }}">
                    {{ $transaksi->denda > 0 ? 'Rp '.number_format($transaksi->denda,0,',','.') : '-' }}
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        {{-- Aksi --}}
        <div class="col-md-4 mb-3">
          <div class="card h-100">
            <div class="card-header card-no-border pb-0">
              <h5><iconify-icon icon="solar:settings-bold" class="text-success me-1"></iconify-icon> Tindakan</h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
              @if($transaksi->status === 'menunggu')
                <form action="{{ route('petugas.transaksi.terima', $transaksi->id) }}" method="POST"
                      onsubmit="return confirm('Setujui peminjaman ini?')">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-success w-100">
                    <i data-feather="check-circle" style="width:16px;height:16px"></i> Setujui Peminjaman
                  </button>
                </form>
                <form action="{{ route('petugas.transaksi.tolak', $transaksi->id) }}" method="POST"
                      onsubmit="return confirm('Tolak peminjaman ini?')">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-outline-danger w-100">
                    <i data-feather="x-circle" style="width:16px;height:16px"></i> Tolak Peminjaman
                  </button>
                </form>

              @elseif($transaksi->status === 'dipinjam')
                <form action="{{ route('petugas.transaksi.kembalikan', $transaksi->id) }}" method="POST"
                      onsubmit="return confirm('Konfirmasi buku sudah dikembalikan?')">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-primary w-100">
                    <iconify-icon icon="solar:arrow-left-bold" class="me-1"></iconify-icon> Konfirmasi Pengembalian
                  </button>
                </form>

              @elseif($transaksi->status === 'dikembalikan' && $transaksi->denda > 0)
                <div class="alert alert-warning py-2 mb-0 small">
                  <iconify-icon icon="solar:wallet-bold" class="me-1"></iconify-icon>
                  Denda belum dibayar: <strong>Rp {{ number_format($transaksi->denda,0,',','.') }}</strong>
                </div>
                <form action="{{ route('petugas.transaksi.lunasi', $transaksi->id) }}" method="POST"
                      onsubmit="return confirm('Tandai denda sudah lunas?')">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn btn-warning w-100">
                    <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon> Lunasi Denda
                  </button>
                </form>

              @else
                <div class="text-center py-3 text-muted small">
                  <iconify-icon icon="solar:check-circle-bold" width="32" class="d-block mb-2 opacity-50"></iconify-icon>
                  Tidak ada tindakan yang diperlukan.
                </div>
              @endif

              <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-light mt-auto">
                <i data-feather="arrow-left" style="width:14px;height:14px"></i> Kembali ke Daftar
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- Daftar Buku --}}
      <div class="card">
        <div class="card-header card-no-border pb-0">
          <h5><iconify-icon icon="solar:book-bold" class="text-info me-1"></iconify-icon> Buku yang Dipinjam</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            @foreach($transaksi->detailTransaksi as $detail)
            <div class="col-md-4 col-12">
              <div class="d-flex gap-3 align-items-center p-3 border rounded">
                <div style="width:45px;height:62px;flex-shrink:0;overflow:hidden;border-radius:4px;">
                  @if($detail->buku?->foto)
                    <img src="{{ Storage::url($detail->buku->foto) }}" style="width:45px;height:62px;object-fit:cover;">
                  @else
                    <div class="bg-info bg-opacity-10 w-100 h-100 d-flex align-items-center justify-content-center">
                      <iconify-icon icon="solar:book-2-bold" class="text-info" width="20"></iconify-icon>
                    </div>
                  @endif
                </div>
                <div class="flex-grow-1" style="min-width:0">
                  <div class="fw-semibold small text-truncate">{{ $detail->buku?->judul ?? '(Buku dihapus)' }}</div>
                  <div class="text-muted" style="font-size:.72rem">{{ $detail->buku?->penulis ?? '-' }}</div>
                  <div class="text-muted" style="font-size:.72rem">Rak: {{ $detail->buku?->rak?->nama_rak ?? '-' }}</div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
