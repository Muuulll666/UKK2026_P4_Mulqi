@extends('layouts.dashboard')
@section('title', 'Kelola Buku')

@section('content')
<aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
      <ul class="sidebar-menu" id="simple-bar">
        <li class="sidebar-main-title"><div><h5 class="lan-1 f-w-700 sidebar-title">General</h5></div></li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Home-dashboard"></use></svg>
            <h6>Dashboard</h6>
          </a>
        </li>
        <li class="sidebar-main-title"><div><h5 class="sidebar-title pt-3 f-w-700">Data</h5></div></li>
        <li class="sidebar-list active">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link active" href="{{ route('admin.anggota.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Wallet"></use></svg>
            <h6 class="f-w-600">Data Anggota</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.user.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Profile"></use></svg>
            <h6 class="f-w-600">Data User</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.buku.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Paper-plus"></use></svg>
            <h6 class="f-w-600">Data Buku</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.kelas.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Category"></use></svg>
            <h6 class="f-w-600">Data Kelas</h6>
          </a>
        </li>
       <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.rak.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Folder"></use></svg>
            <h6 class="f-w-600">Data Rak</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.petugas.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#User"></use></svg>
            <h6 class="f-w-600">Data Petugas</h6>
          </a>
        </li>
         <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.penerbit.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Paper"></use></svg>
            <h6 class="f-w-600">Data Penerbit</h6>
          </a>
        </li>
        <li class="sidebar-list active">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link active" href="{{ route('admin.pengarang.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Edit"></use></svg>
            <h6 class="f-w-600">Data Pengarang</h6>
          </a>
        </li>
      </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</aside>

<div class="page-body-wrapper">
  <div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-sm-6 col-12"><h2>Kelola Buku</h2></div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item">Admin</li>
              <li class="breadcrumb-item active">Buku</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <div class="header-top">
                <h3>Data Buku</h3>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                  <i class="iconly-Plus icli me-1"></i> Tambah Buku
                </button>
              </div>
            </div>
            <div class="card-body pt-0">
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
              @endif
              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
              @endif
              <div class="table-responsive theme-scrollbar mt-3">
                <table class="table display table-bordernone" style="width:100%">
                  <thead>
                    <tr>
                      <th width="50">No</th>
                      <th width="60">Cover</th>
                      <th>Judul</th>
                      <th>Pengarang</th>
                      <th>Penerbit</th>
                      <th>Tahun</th>
                      <th>Stok</th>
                      <th>Rak</th>
                      <th class="text-center" width="100">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($buku as $i => $b)
                    <tr>
                      <td>{{ $i + 1 }}</td>
                      <td>
                        @if($b->foto)
                          <img src="{{ Storage::url($b->foto) }}" alt="cover" class="rounded" style="width:45px;height:60px;object-fit:cover;">
                        @else
                          <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:45px;height:60px;">
                            <i data-feather="book-open" style="width:20px;height:20px;color:#ccc"></i>
                          </div>
                        @endif
                      </td>
                      <td><h6 class="mb-0">{{ $b->judul }}</h6></td>
                      <td>{{ $b->pengarangRelasi->nama ?? ($b->pengarang ?? '-') }}</td>
                      <td>{{ $b->penerbitRelasi->nama ?? ($b->penerbit ?? '-') }}</td>
                      <td>{{ $b->tahun }}</td>
                      <td><span class="badge bg-light-{{ $b->stok > 0 ? 'success text-success' : 'danger text-danger' }}">{{ $b->stok }}</span></td>
                      <td>{{ $b->rak->nama_rak ?? '-' }}</td>
                      <td class="text-center">
                        <button type="button" class="btn bg-light-warning border-light-warning text-warning btn-sm me-1 btn-edit"
                          data-id="{{ $b->id }}"
                          data-judul="{{ $b->judul }}"
                          data-penulis="{{ $b->penulis }}"
                          data-penerbit="{{ $b->penerbit }}"
                          data-tahun="{{ $b->tahun }}"
                          data-stok="{{ $b->stok }}"
                          data-rak="{{ $b->rak_id }}"
                          data-penerbit-id="{{ $b->penerbit_id }}"
                          data-pengarang-id="{{ $b->pengarang_id }}"
                          data-pengarang="{{ $b->pengarang }}"
                          data-foto="{{ $b->foto ? Storage::url($b->foto) : '' }}"
                          data-bs-toggle="modal" data-bs-target="#modalEdit">
                          <i data-feather="edit-2" style="width:14px;height:14px"></i>
                        </button>
                        <button type="button" class="btn bg-light-danger border-light-danger text-danger btn-sm btn-hapus"
                          data-id="{{ $b->id }}" data-judul="{{ $b->judul }}"
                          data-bs-toggle="modal" data-bs-target="#modalHapus">
                          <i data-feather="trash-2" style="width:14px;height:14px"></i>
                        </button>
                      </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Belum ada buku</td></tr>
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

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Buku</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 mb-3">
              <label class="form-label fw-semibold">Cover Buku</label>
              <div class="d-flex align-items-center gap-3">
                <div class="rounded border d-flex align-items-center justify-content-center bg-light" style="width:80px;height:110px;flex-shrink:0;overflow:hidden;">
                  <span id="tambahFotoIcon"><i data-feather="image" style="width:28px;height:28px;color:#ccc;"></i></span>
                  <img id="tambahFotoPreview" src="" alt="preview" style="display:none;width:80px;height:110px;object-fit:cover;">
                </div>
                <div class="flex-grow-1">
                  <input type="file" name="foto" id="tambahFotoInput" class="form-control" accept="image/*">
                  <small class="text-muted">Format: JPG, PNG, WebP. Maks 2MB.</small>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
              <input type="text" name="judul" class="form-control" placeholder="Judul buku" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Penulis</label>
              <input type="text" name="penulis" class="form-control" placeholder="Nama penulis">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Pengarang <small class="text-muted">(dari data)</small></label>
              <select name="pengarang_id" class="form-select">
                <option value="">-- Pilih Pengarang --</option>
                @foreach($pengarang as $pg)
                  <option value="{{ $pg->id }}">{{ $pg->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Penerbit (teks)</label>
              <input type="text" name="penerbit" class="form-control" placeholder="Nama penerbit">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Penerbit <small class="text-muted">(dari data)</small></label>
              <select name="penerbit_id" class="form-select">
                <option value="">-- Pilih Penerbit --</option>
                @foreach($penerbit as $pn)
                  <option value="{{ $pn->id }}">{{ $pn->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
              <input type="number" name="tahun" class="form-control" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
              <input type="number" name="stok" class="form-control" placeholder="0" min="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Rak</label>
              <select name="rak_id" class="form-select">
                <option value="">-- Pilih Rak --</option>
                @foreach($rak as $r)
                  <option value="{{ $r->id }}">{{ $r->nama_rak }} {{ $r->lokasi ? "($r->lokasi)" : '' }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formEdit" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Buku</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 mb-3">
              <label class="form-label fw-semibold">Cover Buku</label>
              <div class="d-flex align-items-center gap-3">
                <div class="rounded border bg-light" style="width:80px;height:110px;flex-shrink:0;overflow:hidden;">
                  <img id="editFotoPreview" src="" alt="cover" style="width:80px;height:110px;object-fit:cover;">
                </div>
                <div class="flex-grow-1">
                  <input type="file" name="foto" id="editFotoInput" class="form-control mb-2" accept="image/*">
                  <small class="text-muted d-block mb-2">Kosongkan jika tidak ingin ubah foto. Maks 2MB.</small>
                  <div id="hapusFotoWrapper">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="hapus_foto" id="hapusFoto" value="1">
                      <label class="form-check-label text-danger" for="hapusFoto">Hapus foto saat ini</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
              <input type="text" name="judul" id="editJudul" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Penulis</label>
              <input type="text" name="penulis" id="editPenulis" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Pengarang <small class="text-muted">(dari data)</small></label>
              <select name="pengarang_id" id="editPengarangId" class="form-select">
                <option value="">-- Pilih Pengarang --</option>
                @foreach($pengarang as $pg)
                  <option value="{{ $pg->id }}">{{ $pg->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Penerbit (teks)</label>
              <input type="text" name="penerbit" id="editPenerbit" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Penerbit <small class="text-muted">(dari data)</small></label>
              <select name="penerbit_id" id="editPenerbitId" class="form-select">
                <option value="">-- Pilih Penerbit --</option>
                @foreach($penerbit as $pn)
                  <option value="{{ $pn->id }}">{{ $pn->nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
              <input type="number" name="tahun" id="editTahun" class="form-control" min="1900" max="{{ date('Y') }}" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
              <input type="number" name="stok" id="editStok" class="form-control" min="0" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Rak</label>
              <select name="rak_id" id="editRak" class="form-select">
                <option value="">-- Pilih Rak --</option>
                @foreach($rak as $r)
                  <option value="{{ $r->id }}">{{ $r->nama_rak }} {{ $r->lokasi ? "($r->lokasi)" : '' }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form id="formHapus" method="POST">
        @csrf @method('DELETE')
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title text-danger">Hapus Buku</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body pt-2">
          <p class="mb-0">Yakin hapus buku <strong id="hapusJudul"></strong>?</p>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.getElementById('tambahFotoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('tambahFotoPreview').src = e.target.result;
        document.getElementById('tambahFotoPreview').style.display = 'block';
        document.getElementById('tambahFotoIcon').style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  });

  document.getElementById('editFotoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => { document.getElementById('editFotoPreview').src = e.target.result; };
      reader.readAsDataURL(file);
    }
  });

  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
      const d = this.dataset;
      document.getElementById('formEdit').action       = `/admin/buku/${d.id}`;
      document.getElementById('editJudul').value       = d.judul;
      document.getElementById('editPenulis').value     = d.penulis || '';
      document.getElementById('editPenerbit').value    = d.penerbit || '';
      document.getElementById('editTahun').value       = d.tahun;
      document.getElementById('editStok').value        = d.stok;
      document.getElementById('editRak').value         = d.rak || '';
      document.getElementById('editPenerbitId').value  = d.penerbitId || '';
      document.getElementById('editPengarangId').value = d.pengarangId || '';
      document.getElementById('hapusFoto').checked     = false;
      document.getElementById('editFotoInput').value   = '';
      const preview = document.getElementById('editFotoPreview');
      const hapusWrapper = document.getElementById('hapusFotoWrapper');
      if (d.foto) {
        preview.src = d.foto;
        preview.style.objectFit = 'cover';
        hapusWrapper.style.display = 'block';
      } else {
        preview.src = '';
        hapusWrapper.style.display = 'none';
      }
    });
  });

  document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('formHapus').action = `/admin/buku/${this.dataset.id}`;
      document.getElementById('hapusJudul').textContent = this.dataset.judul;
    });
  });
</script>
@endpush
@endsection
