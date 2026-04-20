@extends('layouts.dashboard')
@section('title', 'Kelola Petugas')

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
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.pengarang.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Edit"></use></svg>
            <h6 class="f-w-600">Data Pengarang</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.kategori.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Category"></use></svg>
            <h6 class="f-w-600">Kategori Buku</h6>
          </a>
        </li>
        <li class="sidebar-list">
          <i class="fa-solid fa-thumbtack"></i>
          <a class="sidebar-link" href="{{ route('admin.laporan.index') }}">
            <svg class="stroke-icon"><use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Paper-plus"></use></svg>
            <h6 class="f-w-600">Laporan</h6>
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
                    <div class="col-sm-6 col-12">
                        <h2>Kelola Petugas</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <i class="iconly-Home icli svg-color"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">Petugas</li>
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
                                <h3>Data Petugas</h3>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                    <i class="iconly-Plus icli me-1"></i> Tambah Petugas
                                </button>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="table-responsive theme-scrollbar">
                                <table class="table display table-bordernone" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th class="text-center" width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
@forelse($petugas as $i => $p)
<tr>
    <td>{{ $i + 1 }}</td>
    <td><h6 class="mb-0">{{ $p->nama }}</h6></td>
    <td>{{ $p->email }}</td>
    <td class="text-center">
        <button type="button"
                class="btn bg-light-warning border-light-warning text-warning btn-sm me-1"
                data-bs-toggle="modal"
                data-bs-target="#modalEdit{{ $p->id }}">
            <i data-feather="edit-2" style="width:14px;height:14px"></i>
        </button>

        <button type="button"
                class="btn bg-light-danger border-light-danger text-danger btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalHapus{{ $p->id }}">
            <i data-feather="trash-2" style="width:14px;height:14px"></i>
        </button>
    </td>
</tr>

{{-- Modal Edit per data --}}
<div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.petugas.update', $p->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Petugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-7 col-lg-8 col-md-10">
                            <div class="mb-3">
                                <label class="form-label f-w-600">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label f-w-600">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $p->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label f-w-600">
                                    Password Baru
                                    <small class="text-muted">(kosongkan jika tidak ingin ubah)</small>
                                </label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                            </div>

                            <div class="mb-3">
                                <label class="form-label f-w-600">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-warning text-white">Update</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Hapus per data --}}
<div class="modal fade" id="modalHapus{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.petugas.destroy', $p->id) }}">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2">Yakin ingin menghapus petugas berikut?</p>
                    <h5 class="mb-0">{{ $p->nama }}</h5>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@empty
<tr>
    <td colspan="4" class="text-center text-muted py-4">Belum ada petugas</td>
</tr>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.petugas.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Petugas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div style="max-width: 520px;">
                        <div class="mb-3">
                            <label class="form-label f-w-600">Nama Lengkap</label>
                            <input type="text" name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label f-w-600">Email</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label f-w-600">Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label f-w-600">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save" class="me-1"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formEdit" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Petugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-7 col-lg-8 col-md-10">
                            <input type="hidden" id="editId">

                            <div class="mb-3">
                                <label class="form-label f-w-600">Nama Lengkap</label>
                                <input type="text" name="nama" id="editNama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label f-w-600">Email</label>
                                <input type="email" name="email" id="editEmail" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label f-w-600">
                                    Password Baru
                                    <small class="text-muted">(kosongkan jika tidak ingin ubah)</small>
                                </label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                            </div>

                            <div class="mb-3">
                                <label class="form-label f-w-600">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-warning text-white">
                        <i data-feather="save" class="me-1"></i> Update
                    </button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formHapus" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="py-2">
                        <p class="mb-2">Yakin ingin menghapus petugas berikut?</p>
                        <h5 id="namaPetugasHapus" class="mb-0"></h5>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setEditData(id, nama, email) {
    document.getElementById('editId').value = id;
    document.getElementById('editNama').value = nama;
    document.getElementById('editEmail').value = email;
    document.getElementById('formEdit').action = '/admin/petugas/' + id;
}

function confirmDelete(id, nama) {
    document.getElementById('namaPetugasHapus').textContent = nama;
    document.getElementById('formHapus').action = '/admin/petugas/' + id;
}
</script>

@endsection