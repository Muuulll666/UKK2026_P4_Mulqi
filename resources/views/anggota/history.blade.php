@extends('layouts.dashboard')
@section('title', 'History Peminjaman')

@section('content')
<div class="page-body-wrapper">

  {{-- Sidebar --}}
  <aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
      <ul class="sidebar-menu" id="simple-bar">
        <li class="sidebar-main-title">
          <div><h5 class="lan-1 f-w-700 sidebar-title">Menu Anggota</h5></div>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}" href="{{ route('anggota.dashboard') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Home-dashboard') }}"></use></svg>
            <h6 class="f-w-600">Dashboard</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link {{ request()->routeIs('anggota.buku.*') ? 'active' : '' }}" href="{{ route('anggota.buku.index') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Paper-plus') }}"></use></svg>
            <h6 class="f-w-600">Daftar Buku</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link {{ request()->routeIs('anggota.history') ? 'active' : '' }}" href="{{ route('anggota.history') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Paper') }}"></use></svg>
            <h6 class="f-w-600">History Peminjaman</h6>
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
            <h2>History Peminjaman</h2>
            <p class="mb-0 text-title-gray">Riwayat semua aktivitas peminjaman kamu.</p>
          </div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('anggota.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item active">History</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
      @endif

      <div class="row">
        @forelse($transaksi as $t)
        @php
          $statusColor = match($t->status) {
            'menunggu'     => ['bg' => 'bg-light-warning', 'text' => 'text-warning', 'icon' => 'solar:clock-circle-bold'],
            'dipinjam'     => ['bg' => 'bg-light-primary', 'text' => 'text-primary', 'icon' => 'solar:book-bold'],
            'dikembalikan' => ['bg' => 'bg-light-success', 'text' => 'text-success', 'icon' => 'solar:check-circle-bold'],
            'ditolak'      => ['bg' => 'bg-light-danger',  'text' => 'text-danger',  'icon' => 'solar:close-circle-bold'],
            default        => ['bg' => 'bg-light-secondary','text' => 'text-secondary','icon' => 'solar:info-circle-bold'],
          };
          $isLate = $t->status === 'dipinjam' && \Carbon\Carbon::parse($t->tanggal_kembali)->isPast();
        @endphp
        <div class="col-12 mb-3">
          <div class="card {{ $isLate ? 'border-danger border-opacity-50' : '' }}">
            <div class="card-body">
              <div class="row align-items-start">
                {{-- Status Icon --}}
                <div class="col-auto">
                  <div class="p-3 rounded {{ $statusColor['bg'] }} {{ $statusColor['text'] }}">
                    <iconify-icon icon="{{ $statusColor['icon'] }}" width="28"></iconify-icon>
                  </div>
                </div>

                {{-- Info --}}
                <div class="col">
                  {{-- Buku List --}}
                  <div class="mb-2">
                    @foreach($t->detailTransaksi as $detail)
                    <div class="d-flex align-items-center gap-2 mb-1">
                      <div style="width:30px;height:40px;flex-shrink:0;overflow:hidden;border-radius:3px;">
                        @if($detail->buku?->foto)
                          <img src="{{ Storage::url($detail->buku->foto) }}" style="width:30px;height:40px;object-fit:cover;">
                        @else
                          <div class="bg-info bg-opacity-10 w-100 h-100 d-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:book-2-bold" class="text-info" width="14"></iconify-icon>
                          </div>
                        @endif
                      </div>
                      <div>
                        <div class="fw-semibold small">{{ $detail->buku?->judul ?? '(Buku dihapus)' }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $detail->buku?->penulis ?? '-' }}</div>
                      </div>
                    </div>
                    @endforeach
                  </div>

                  {{-- Tanggal & Status --}}
                  <div class="d-flex flex-wrap gap-3 align-items-center">
                    <span class="badge {{ $statusColor['bg'] }} {{ $statusColor['text'] }} border {{ $statusColor['bg'] }}">
                      {{ ucfirst($t->status) }}
                    </span>
                    <span class="text-muted small">
                      <iconify-icon icon="solar:calendar-bold" class="me-1"></iconify-icon>
                      Pinjam: {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y') }}
                    </span>
                    <span class="text-muted small">
                      <iconify-icon icon="solar:calendar-mark-bold" class="me-1"></iconify-icon>
                      Kembali: {{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y') }}
                    </span>
                    @if($isLate)
                    <span class="text-danger small fw-semibold">
                      <iconify-icon icon="solar:danger-bold" class="me-1"></iconify-icon>
                      Terlambat {{ \Carbon\Carbon::parse($t->tanggal_kembali)->diffInDays() }} hari
                    </span>
                    @endif
                    @if($t->denda > 0)
                    <span class="text-danger small">
                      Denda: <strong>Rp {{ number_format($t->denda, 0, ',', '.') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                {{-- Aksi --}}
                <div class="col-auto mt-2 mt-sm-0">
                  @if($t->status === 'dipinjam')
                  <form action="{{ route('anggota.kembalikan', $t->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin mengajukan pengembalian buku ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-outline-success">
                      <iconify-icon icon="solar:arrow-left-bold" width="14" class="me-1"></iconify-icon> Kembalikan
                    </button>
                  </form>
                  @elseif($t->status === 'menunggu')
                  <span class="badge bg-light-warning text-warning">Menunggu konfirmasi</span>
                  @endif
                </div>

              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12">
          <div class="card">
            <div class="card-body text-center py-5">
              <iconify-icon icon="solar:document-text-bold" width="60" class="d-block mb-3 text-muted opacity-30"></iconify-icon>
              <p class="text-muted mb-3">Belum ada riwayat peminjaman.</p>
              <a href="{{ route('anggota.buku.index') }}" class="btn btn-primary">Mulai Pinjam Buku</a>
            </div>
          </div>
        </div>
        @endforelse
      </div>

      <div class="d-flex justify-content-center">
        {{ $transaksi->links() }}
      </div>

    </div>
  </div>
</div>
@endsection
