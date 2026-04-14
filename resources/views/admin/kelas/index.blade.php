@extends('layouts.dashboard')
@section('title', 'Kelola Kelas')

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
          <div class="col-sm-6 col-12"><h2>Kelola Kelas</h2></div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item">Admin</li>
              <li class="breadcrumb-item active">Kelas</li>
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
                <h3>Data Kelas</h3>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                  <i class="iconly-Plus icli me-1"></i> Tambah Kelas
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
                      <th>Nama Kelas</th>
                      <th>Jumlah Anggota</th>
                      <th class="text-center" width="120">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($kelas as $i => $k)
                    <tr>
                      <td>{{ $i + 1 }}</td>
                      <td><h6 class="mb-0">{{ $k->nama_kelas }}</h6></td>
                      <td><span class="badge bg-light-primary text-primary">{{ $k->anggota_count }} anggota</span></td>
                      <td class="text-center">
                        <button type="button" class="btn bg-light-warning border-light-warning text-warning btn-sm me-1 btn-edit"
                          data-id="{{ $k->id }}" data-nama="{{ $k->nama_kelas }}"
                          data-bs-toggle="modal" data-bs-target="#modalEdit">
                          <i data-feather="edit-2" style="width:14px;height:14px"></i>
                        </button>
                        <button type="button" class="btn bg-light-danger border-light-danger text-danger btn-sm btn-hapus"
                          data-id="{{ $k->id }}" data-nama="{{ $k->nama_kelas }}"
                          data-bs-toggle="modal" data-bs-target="#modalHapus">
                          <i data-feather="trash-2" style="width:14px;height:14px"></i>
                        </button>
                      </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada kelas</td></tr>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.kelas.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
            <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: X IPA 1" required>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEdit" method="POST">
        @csrf @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Edit Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
            <input type="text" name="nama_kelas" id="editNama" class="form-control" required>
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
          <h5 class="modal-title text-danger">Hapus Kelas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body pt-2">
          <p class="mb-0">Yakin hapus kelas <strong id="hapusNama"></strong>?</p>
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
  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('formEdit').action = `/admin/kelas/${this.dataset.id}`;
      document.getElementById('editNama').value = this.dataset.nama;
    });
  });
  document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('formHapus').action = `/admin/kelas/${this.dataset.id}`;
      document.getElementById('hapusNama').textContent = this.dataset.nama;
    });
  });
</script>
@endpush
@endsection
