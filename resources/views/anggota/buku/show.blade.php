@extends('layouts.dashboard')
@section('title', $buku->judul)

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
          <a class="sidebar-link" href="{{ route('anggota.dashboard') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Home-dashboard') }}"></use></svg>
            <h6 class="f-w-600">Dashboard</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link active" href="{{ route('anggota.buku.index') }}">
            <svg class="stroke-icon"><use href="{{ asset('assets/svg/iconly-sprite.svg#Paper-plus') }}"></use></svg>
            <h6 class="f-w-600">Daftar Buku</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('anggota.history') }}">
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
            <h2>Detail Buku</h2>
          </div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('anggota.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item"><a href="{{ route('anggota.buku.index') }}">Daftar Buku</a></li>
              <li class="breadcrumb-item active">{{ Str::limit($buku->judul, 30) }}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
      @endif

      <div class="row">
        {{-- Foto Buku --}}
        <div class="col-md-3 col-12 mb-3">
          <div class="card">
            <div class="card-body p-3 text-center">
              @if($buku->foto)
                <img src="{{ Storage::url($buku->foto) }}" class="img-fluid rounded" style="max-height:300px;object-fit:cover;width:100%">
              @else
                <div class="bg-info bg-opacity-10 rounded d-flex align-items-center justify-content-center" style="height:260px;">
                  <iconify-icon icon="solar:book-2-bold" class="text-info" width="80"></iconify-icon>
                </div>
              @endif
            </div>
          </div>
        </div>

        {{-- Info Buku --}}
        <div class="col-md-9 col-12 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <h3 class="fw-bold mb-1">{{ $buku->judul }}</h3>
              <p class="text-muted mb-3">{{ $buku->pengarangRelasi?->nama ?? $buku->penulis ?? '-' }}</p>

              <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                  <div class="p-3 rounded bg-primary bg-opacity-10 text-center">
                    <div class="text-muted small mb-1">Penerbit</div>
                    <div class="fw-semibold small">{{ $buku->penerbitRelasi?->nama ?? $buku->penerbit ?? '-' }}</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-3 rounded bg-warning bg-opacity-10 text-center">
                    <div class="text-muted small mb-1">Tahun Terbit</div>
                    <div class="fw-semibold small">{{ $buku->tahun ?? '-' }}</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-3 rounded bg-info bg-opacity-10 text-center">
                    <div class="text-muted small mb-1">Lokasi Rak</div>
                    <div class="fw-semibold small">{{ $buku->rak?->nama_rak ?? '-' }}</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-3 rounded bg-secondary bg-opacity-10 text-center">
                    <div class="text-muted small mb-1">Kategori</div>
                    <div class="fw-semibold small">{{ $buku->kategori?->nama ?? '-' }}</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-3 rounded {{ $buku->stok > 0 ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10' }} text-center">
                    <div class="text-muted small mb-1">Stok Tersedia</div>
                    <div class="fw-bold {{ $buku->stok > 0 ? 'text-success' : 'text-danger' }}">{{ $buku->stok }}</div>
                  </div>
                </div>
              </div>

              @if($buku->pengarangRelasi?->biografi)
                <div class="mb-4">
                  <h6 class="fw-semibold">Tentang Pengarang</h6>
                  <p class="text-muted small mb-0">{{ $buku->pengarangRelasi->biografi }}</p>
                </div>
              @endif

              <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('anggota.buku.index') }}" class="btn btn-light">
                  <i data-feather="arrow-left" style="width:16px;height:16px"></i> Kembali
                </a>
                @if($buku->stok > 0)
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                    <iconify-icon icon="solar:book-bold" class="me-1"></iconify-icon> Pinjam Buku Ini
                  </button>
                @else
                  <button class="btn btn-secondary" disabled>Stok Habis</button>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal Pinjam --}}
@if($buku->stok > 0)
<div class="modal fade" id="modalPinjam" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('anggota.pinjam.store') }}" method="POST">
        @csrf
        <input type="hidden" name="buku_ids[]" value="{{ $buku->id }}">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Peminjaman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex gap-3 align-items-start mb-3">
            <div style="width:50px;height:70px;flex-shrink:0;overflow:hidden;border-radius:4px;">
              @if($buku->foto)
                <img src="{{ Storage::url($buku->foto) }}" style="width:50px;height:70px;object-fit:cover;">
              @else
                <div class="bg-info bg-opacity-10 w-100 h-100 d-flex align-items-center justify-content-center">
                  <iconify-icon icon="solar:book-2-bold" class="text-info" width="24"></iconify-icon>
                </div>
              @endif
            </div>
            <div>
              <div class="fw-semibold">{{ $buku->judul }}</div>
              <div class="text-muted small">{{ $buku->penulis ?? '-' }}</div>
              <span class="badge bg-light-success text-success mt-1">Stok: {{ $buku->stok }}</span>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Durasi Peminjaman <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="number" name="lama_pinjam" class="form-control" value="7" min="1" max="30" required>
              <span class="input-group-text">hari</span>
            </div>
            <small class="text-muted">Minimal 1 hari, maksimal 30 hari.</small>
          </div>
          <div class="alert alert-info small py-2 mb-0">
            <iconify-icon icon="solar:info-circle-bold" class="me-1"></iconify-icon>
            Denda Rp 1.000/hari jika terlambat. Menunggu persetujuan petugas.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endsection
