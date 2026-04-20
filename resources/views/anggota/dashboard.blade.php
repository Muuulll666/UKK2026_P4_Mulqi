@extends('layouts.dashboard')
@section('title', 'Dashboard Anggota')

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
            <h2>Selamat Datang, {{ auth()->user()->nama }}! 👋</h2>
            <p class="mb-0 text-title-gray">Kelola peminjaman buku kamu di sini.</p>
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

        {{-- Kartu Profil Anggota --}}
        <div class="col-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center gap-3">
                @if(auth()->user()->foto)
                  <img src="{{ Storage::url(auth()->user()->foto) }}" alt="foto profil"
                       class="rounded-circle border" style="width:70px;height:70px;object-fit:cover;">
                @else
                  <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center border"
                       style="width:70px;height:70px;flex-shrink:0;">
                    <span class="fw-bold text-success fs-4">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</span>
                  </div>
                @endif
                <div class="flex-grow-1">
                  <h5 class="mb-0 fw-semibold">{{ auth()->user()->nama }}</h5>
                  <span class="text-muted small">{{ auth()->user()->email }}</span>
                  <div class="mt-1"><span class="badge bg-light-success text-success">Anggota</span></div>
                </div>
                <!-- <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                  <i data-feather="edit-2" style="width:14px;height:14px"></i> Edit Profil
                </button> -->
              </div>
            </div>
          </div>
        </div>

        @if(session('success'))
          <div class="col-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
          </div>
        @endif

        {{-- Stats --}}
        <div class="col-12 mb-3">
          <div class="row g-3">
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
                  <div class="p-2 rounded bg-warning bg-opacity-10 text-warning d-inline-block mb-2">
                    <iconify-icon icon="solar:clock-circle-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4>
                  <span class="text-muted small">Menunggu</span>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="card text-center">
                <div class="card-body">
                  <div class="p-2 rounded bg-success bg-opacity-10 text-success d-inline-block mb-2">
                    <iconify-icon icon="solar:check-circle-bold" width="28"></iconify-icon>
                  </div>
                  <h4 class="mb-0 fw-bold">{{ $stats['total_history'] }}</h4>
                  <span class="text-muted small">Total Pinjaman</span>
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

        {{-- Peminjaman Aktif --}}
        <div class="col-lg-7 col-12">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <div class="header-top">
                <h3><iconify-icon icon="solar:document-text-bold" class="text-primary me-1"></iconify-icon> Peminjaman Aktif</h3>
                <a href="{{ route('anggota.history') }}" class="btn btn-light btn-sm">Lihat Semua</a>
              </div>
            </div>
            <div class="card-body pt-2">
              @forelse($activeLoans as $transaksi)
              <div class="d-flex align-items-start gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="p-2 rounded bg-primary bg-opacity-10 text-primary">
                  <iconify-icon icon="solar:book-bold" width="18"></iconify-icon>
                </div>
                <div class="flex-grow-1" style="min-width:0">
                  @foreach($transaksi->detailTransaksi as $detail)
                    <div class="fw-semibold small text-truncate">{{ $detail->buku->judul }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $detail->buku->penulis }}</div>
                  @endforeach
                  <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    @php
                      $btnClass = match($transaksi->status) {
                        'menunggu' => 'bg-light-warning border-light-warning text-warning',
                        'dipinjam' => 'bg-light-primary border-light-primary text-primary',
                        default    => 'bg-light-secondary text-secondary',
                      };
                    @endphp
                    <div class="btn {{ $btnClass }} btn-sm" style="font-size:.7rem;padding:2px 8px">{{ ucfirst($transaksi->status) }}</div>
                    @if($transaksi->status === 'dipinjam')
                      <span class="text-muted" style="font-size:.75rem">
                        Jatuh tempo: {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}
                        @if(\Carbon\Carbon::parse($transaksi->tanggal_kembali)->isPast())
                          <span class="text-danger">(Terlambat {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->diffInDays() }} hari)</span>
                        @endif
                      </span>
                    @endif
                  </div>
                </div>
              </div>
              @empty
              <div class="text-center py-4 text-muted">
                <iconify-icon icon="solar:book-minimalistic-bold" width="40" class="d-block mb-2 opacity-50"></iconify-icon>
                <p class="mb-2 small">Tidak ada peminjaman aktif</p>
                <a href="{{ route('anggota.buku.index') }}" class="btn btn-primary btn-sm">Pinjam Buku</a>
              </div>
              @endforelse
            </div>
          </div>
        </div>

        {{-- Buku Tersedia & Ketentuan --}}
        <div class="col-lg-5 col-12">
          <div class="card mb-3">
            <div class="card-header card-no-border pb-0">
              <div class="header-top">
                <h3><iconify-icon icon="solar:stars-bold" class="text-warning me-1"></iconify-icon> Buku Tersedia</h3>
                <a href="{{ route('anggota.buku.index') }}" class="btn btn-light btn-sm">Lihat Semua</a>
              </div>
            </div>
            <div class="card-body pt-2">
              @foreach($recentBooks as $buku)
              <a href="{{ route('anggota.buku.show', $buku->id) }}"
                 class="d-flex align-items-center gap-3 py-2 text-decoration-none {{ !$loop->last ? 'border-bottom' : '' }}">
                <div style="width:36px;height:50px;flex-shrink:0;overflow:hidden;border-radius:4px;">
                  @if($buku->foto)
                    <img src="{{ Storage::url($buku->foto) }}" style="width:36px;height:50px;object-fit:cover;">
                  @else
                    <div class="bg-info bg-opacity-10 d-flex align-items-center justify-content-center w-100 h-100">
                      <iconify-icon icon="solar:book-2-bold" class="text-info" width="18"></iconify-icon>
                    </div>
                  @endif
                </div>
                <div class="flex-grow-1" style="min-width:0">
                  <div class="fw-semibold small text-truncate" style="color:var(--body-font-color)">{{ $buku->judul }}</div>
                  <div class="text-muted" style="font-size:.75rem">{{ $buku->penulis }}</div>
                </div>
                <div class="btn bg-light-success border-light-success text-success btn-sm" style="font-size:.7rem;padding:2px 8px;white-space:nowrap">
                  Stok: {{ $buku->stok }}
                </div>
              </a>
              @endforeach
            </div>
          </div>

          <div class="card">
            <div class="card-header card-no-border pb-0">
              <h3 class="text-info"><iconify-icon icon="solar:info-circle-bold" class="me-1"></iconify-icon> Ketentuan Peminjaman</h3>
            </div>
            <div class="card-body pt-2">
              <ul class="mb-0 ps-3 text-muted small">
                <li>Maksimal 3 buku sekaligus</li>
                <li>Durasi pinjam: 7 hari</li>
                <li>Denda terlambat: Rp 1.000/hari</li>
                <li>Peminjaman perlu persetujuan petugas</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>

{{-- Modal Edit Profil --}}
<div class="modal fade" id="modalEditProfil" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          {{-- Foto Profil --}}
          <div class="mb-3">
            <label class="form-label fw-semibold">Foto Profil</label>
            <div class="d-flex align-items-center gap-3 mb-2">
              <div class="rounded-circle border overflow-hidden" style="width:70px;height:70px;flex-shrink:0;">
                @if(auth()->user()->foto)
                  <img id="profilPreview" src="{{ Storage::url(auth()->user()->foto) }}" style="width:70px;height:70px;object-fit:cover;">
                @else
                  <div id="profilPreviewPlaceholder" class="bg-success bg-opacity-10 d-flex align-items-center justify-content-center w-100 h-100">
                    <span class="fw-bold text-success fs-4">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</span>
                  </div>
                  <img id="profilPreview" src="" style="display:none;width:70px;height:70px;object-fit:cover;">
                @endif
              </div>
              <input type="file" name="foto" id="profilFotoInput" class="form-control" accept="image/*">
            </div>
            @if(auth()->user()->foto)
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="hapus_foto" id="hapusProfilFoto" value="1">
              <label class="form-check-label text-danger" for="hapusProfilFoto">Hapus foto profil</label>
            </div>
            @endif
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control" value="{{ auth()->user()->nama }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
          </div>
          <hr>
          <p class="text-muted small mb-2">Kosongkan jika tidak ingin mengubah password.</p>
          <div class="mb-3">
            <label class="form-label fw-semibold">Password Baru</label>
            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.getElementById('profilFotoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.getElementById('profilPreview');
        img.src = e.target.result;
        img.style.display = 'block';
        const ph = document.getElementById('profilPreviewPlaceholder');
        if (ph) ph.style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  });
</script>
@endpush
@endsection
