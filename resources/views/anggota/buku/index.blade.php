@extends('layouts.dashboard')
@section('title', 'Daftar Buku')

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
            <h2>Daftar Buku</h2>
            <p class="mb-0 text-title-gray">Pilih buku yang ingin kamu pinjam.</p>
          </div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('anggota.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item active">Daftar Buku</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- Search + Cart --}}
      <div class="card mb-3">
        <div class="card-body py-3">
          <div class="row g-2 align-items-center">
            <div class="col-md-9">
              <form method="GET" action="{{ route('anggota.buku.index') }}" class="row g-2">
                <div class="col-md-6">
                  <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="{{ $search ?? '' }}">
                    <button class="btn btn-primary" type="submit"><i data-feather="search" style="width:16px;height:16px"></i></button>
                  </div>
                </div>
                <div class="col-md-4">
                  <select name="kategori_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kt)
                      <option value="{{ $kt->id }}" @selected($kt->id == $kategoriId)>{{ $kt->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2">
                  @if($search || $kategoriId)
                    <a href="{{ route('anggota.buku.index') }}" class="btn btn-light w-100">Reset</a>
                  @endif
                </div>
              </form>
            </div>
            <div class="col-md-3 text-md-end">
              <button class="btn btn-success" id="btnPinjamSekarang" data-bs-toggle="modal" data-bs-target="#modalPinjam" disabled>
                <i data-feather="shopping-cart" style="width:16px;height:16px"></i>
                Pinjam Sekarang <span class="badge bg-white text-success ms-1" id="cartCount">0</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      {{-- Buku Grid --}}
      <div class="row g-3" id="bukuGrid">
        @forelse($buku as $item)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 buku-card" data-id="{{ $item->id }}" data-judul="{{ $item->judul }}" data-stok="{{ $item->stok }}">
            <div style="height:160px;overflow:hidden;border-radius:8px 8px 0 0;">
              @if($item->foto)
                <img src="{{ Storage::url($item->foto) }}" class="w-100 h-100" style="object-fit:cover;">
              @else
                <div class="w-100 h-100 bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
                  <iconify-icon icon="solar:book-2-bold" class="text-info" width="48"></iconify-icon>
                </div>
              @endif
            </div>
            <div class="card-body p-2 d-flex flex-column">
              <div class="fw-semibold small text-truncate mb-1" title="{{ $item->judul }}">{{ $item->judul }}</div>
              <div class="text-muted" style="font-size:.72rem">{{ $item->penulis ?? '-' }}</div>
              @if($item->kategori)
                <span class="badge bg-light-info text-info mt-1" style="font-size:.65rem">{{ $item->kategori->nama }}</span>
              @endif
              <div class="mt-auto pt-2 d-flex align-items-center justify-content-between">
                @if($item->stok > 0)
                  <span class="badge bg-light-success text-success">Stok: {{ $item->stok }}</span>
                  <button type="button"
                    class="btn btn-sm btn-outline-primary btn-pilih"
                    data-id="{{ $item->id }}"
                    data-judul="{{ $item->judul }}"
                    style="font-size:.72rem;padding:2px 8px">
                    + Pilih
                  </button>
                @else
                  <span class="badge bg-light-danger text-danger">Habis</span>
                  <a href="{{ route('anggota.buku.show', $item->id) }}" class="btn btn-sm btn-outline-secondary" style="font-size:.72rem;padding:2px 8px">Detail</a>
                @endif
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12">
          <div class="text-center py-5 text-muted">
            <iconify-icon icon="solar:book-minimalistic-bold" width="60" class="d-block mb-3 opacity-30"></iconify-icon>
            <p>Tidak ada buku ditemukan.</p>
          </div>
        </div>
        @endforelse
      </div>

      {{-- Pagination --}}
      <div class="mt-4 d-flex justify-content-center">
        {{ $buku->appends(['search' => $search, 'kategori_id' => $kategoriId])->links() }}
      </div>

    </div>
  </div>
</div>

{{-- Modal Pinjam --}}
<div class="modal fade" id="modalPinjam" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('anggota.pinjam.store') }}" method="POST" id="formPinjam">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title"><iconify-icon icon="solar:book-bold" class="me-1 text-primary"></iconify-icon> Konfirmasi Peminjaman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted small mb-3">Kamu akan meminjam buku berikut (maks. 3 buku):</p>
          <ul class="list-group mb-3" id="listBukuDipilih"></ul>
          <div class="mb-3">
            <label class="form-label fw-semibold">Durasi Peminjaman <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="number" name="lama_pinjam" class="form-control" value="7" min="1" max="30" required>
              <span class="input-group-text">hari</span>
            </div>
            <small class="text-muted">Minimal 1 hari, maksimal 30 hari.</small>
          </div>
          <div class="alert alert-info small mb-0 py-2">
            <iconify-icon icon="solar:info-circle-bold" class="me-1"></iconify-icon>
            Peminjaman perlu disetujui petugas terlebih dahulu. Denda Rp 1.000/hari jika terlambat.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <iconify-icon icon="solar:send-bold" class="me-1"></iconify-icon> Kirim Permintaan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  const cart = new Map(); // id -> judul

  function updateCart() {
    const count = cart.size;
    document.getElementById('cartCount').textContent = count;
    document.getElementById('btnPinjamSekarang').disabled = count === 0;

    // Update list di modal
    const ul = document.getElementById('listBukuDipilih');
    ul.innerHTML = '';

    // Clear hidden inputs
    document.querySelectorAll('input[name="buku_ids[]"]').forEach(el => el.remove());

    cart.forEach((judul, id) => {
      ul.innerHTML += `<li class="list-group-item d-flex justify-content-between align-items-center small">
        <span><iconify-icon icon="solar:book-bold" class="text-primary me-1"></iconify-icon>${judul}</span>
        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-remove-cart" data-id="${id}" style="font-size:.7rem">✕</button>
      </li>`;
      const inp = document.createElement('input');
      inp.type = 'hidden';
      inp.name = 'buku_ids[]';
      inp.value = id;
      document.getElementById('formPinjam').appendChild(inp);
    });

    // Update tombol pilih
    document.querySelectorAll('.btn-pilih').forEach(btn => {
      const bid = btn.dataset.id;
      if (cart.has(bid)) {
        btn.textContent = '✓ Dipilih';
        btn.classList.replace('btn-outline-primary', 'btn-success');
      } else {
        btn.textContent = '+ Pilih';
        btn.classList.replace('btn-success', 'btn-outline-primary');
      }
    });
  }

  document.querySelectorAll('.btn-pilih').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.dataset.id;
      const judul = this.dataset.judul;
      if (cart.has(id)) {
        cart.delete(id);
      } else {
        if (cart.size >= 3) {
          alert('Maksimal 3 buku sekaligus!');
          return;
        }
        cart.set(id, judul);
      }
      updateCart();
    });
  });

  document.getElementById('listBukuDipilih').addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-remove-cart');
    if (btn) {
      cart.delete(btn.dataset.id);
      updateCart();
    }
  });
</script>
@endpush
@endsection
