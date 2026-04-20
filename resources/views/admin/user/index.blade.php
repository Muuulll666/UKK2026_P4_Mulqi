@extends('layouts.dashboard')
@section('title', 'Kelola User')

@section('content')
<aside class="page-sidebar">
    
    <div class="left-arrow" id="left-arrow">
      <i data-feather="arrow-left"></i>
    </div>
  
    <div class="main-sidebar" id="main-sidebar">
      <ul class="sidebar-menu" id="simple-bar">
  
        {{-- GENERAL --}}
        <li class="sidebar-main-title">
          <div><h5 class="lan-1 f-w-700 sidebar-title">General</h5></div>
        </li>
  
        <li class="sidebar-list">
          <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
            <svg class="stroke-icon">
              <use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Home-dashboard"></use>
            </svg>
            <h6>Dashboard</h6>
          </a>
        </li>
  
        <li class="sidebar-list">
          <a class="sidebar-link sidebar-title" href="javascript:void(0)">
            <svg class="stroke-icon">
              <use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Folder"></use>
            </svg>
            <h6>Manajemen Buku</h6>
          </a>
  
          <ul class="sidebar-submenu">
            <li>
              <a href="{{ route('admin.buku.index') }}">Data Buku</a>
            </li>
            <li>
              <a href="{{ route('admin.pengarang.index') }}">Pengarang</a>
            </li>
            <li>
              <a href="{{ route('admin.penerbit.index') }}">Penerbit</a>
            </li>
            <li>
              <a href="{{ route('admin.rak.index') }}">Rak</a>
            </li>
            <li>
              <a href="{{ route('admin.kelas.index') }}">Kelas</a>
            </li>
            <li>
              <a href="{{ route('admin.kategori.index') }}">Kategori Buku</a>
            </li>
          </ul>
        </li>
  
    
        <li class="sidebar-list">
          <a class="sidebar-link" href="{{ route('admin.user.index') }}">
            <svg class="stroke-icon">
              <use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Profile"></use>
            </svg>
            <h6>Kelola User</h6>
          </a>
        </li>
  
        
        <li class="sidebar-list">
          <a class="sidebar-link" href="{{ route('admin.laporan.index') }}">
            <svg class="stroke-icon">
              <use href="https://admin.pixelstrap.net/admiro/assets/svg/iconly-sprite.svg#Paper-plus"></use>
            </svg>
            <h6>Laporan</h6>
          </a>
        </li>
  
      </ul>
    </div>
  
    <div class="right-arrow" id="right-arrow">
      <i data-feather="arrow-right"></i>
    </div>
  </aside>

<div class="page-body-wrapper">
  <div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-sm-6 col-12"><h2>Kelola User</h2></div>
          <div class="col-sm-6 col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="iconly-Home icli svg-color"></i></a></li>
              <li class="breadcrumb-item">Admin</li>
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">

      {{-- Alert --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
      @endif

      {{-- Filter + Tambah --}}
      <div class="card mb-3">
        <div class="card-body py-3">
          <form method="GET" action="{{ route('admin.user.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
              <label class="form-label fw-semibold mb-1">Cari</label>
              <div class="input-group">
                <span class="input-group-text"><i data-feather="search" style="width:14px;height:14px"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Nama atau email..." value="{{ $search ?? '' }}">
              </div>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold mb-1">Role</label>
              <select name="role" class="form-select">
                <option value="">-- Semua Role --</option>
                <option value="admin"   @selected($role === 'admin')>Admin</option>
                <option value="petugas" @selected($role === 'petugas')>Petugas</option>
                <option value="anggota" @selected($role === 'anggota')>Anggota</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">
                <iconify-icon icon="solar:filter-bold" class="me-1"></iconify-icon> Filter
              </button>
            </div>
            <div class="col-md-2">
              @if($search || $role)
                <a href="{{ route('admin.user.index') }}" class="btn btn-light w-100">Reset</a>
              @else
                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modalTambah">
                  <i class="iconly-Plus icli me-1"></i> Tambah User
                </button>
              @endif
            </div>
          </form>
          @if($search || $role)
          <div class="mt-2">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
              <i class="iconly-Plus icli me-1"></i> Tambah User
            </button>
          </div>
          @endif
        </div>
      </div>

      {{-- ===== SECTION ADMIN ===== --}}
      @if($admins->isNotEmpty() || !$role || $role === 'admin')
      <div class="card mb-4">
        <div class="card-header card-no-border pb-0">
          <div class="header-top">
            <h3>
              <iconify-icon icon="solar:shield-user-bold" class="text-danger me-1"></iconify-icon>
              Data Admin
              <span class="badge bg-light-danger text-danger ms-2">{{ $admins->count() }}</span>
            </h3>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="table-responsive theme-scrollbar mt-3">
            <table class="table display table-bordernone" style="width:100%">
              <thead>
                <tr>
                  <th width="50">#</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Dibuat</th>
                  <th class="text-center" width="100">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($admins as $i => $u)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width:32px;height:32px;flex-shrink:0;">
                        <span class="fw-bold text-danger small">{{ strtoupper(substr($u->nama, 0, 1)) }}</span>
                      </div>
                      <h6 class="mb-0">{{ $u->nama }}</h6>
                    </div>
                  </td>
                  <td>{{ $u->email }}</td>
                  <td>{{ $u->created_at ? \Carbon\Carbon::parse($u->created_at)->format('d M Y') : '-' }}</td>
                  <td class="text-center">
                    <button type="button" class="btn bg-light-warning border-light-warning text-warning btn-sm me-1 btn-edit"
                      data-id="{{ $u->id }}" data-nama="{{ $u->nama }}" data-email="{{ $u->email }}" data-role="{{ $u->role }}"
                      data-bs-toggle="modal" data-bs-target="#modalEdit">
                      <i data-feather="edit-2" style="width:14px;height:14px"></i>
                    </button>
                    <button type="button" class="btn bg-light-danger border-light-danger text-danger btn-sm btn-hapus"
                      data-id="{{ $u->id }}" data-nama="{{ $u->nama }}"
                      data-bs-toggle="modal" data-bs-target="#modalHapus">
                      <i data-feather="trash-2" style="width:14px;height:14px"></i>
                    </button>
                  </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada data admin</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif

      {{-- ===== SECTION PETUGAS ===== --}}
      @if($petugas->isNotEmpty() || !$role || $role === 'petugas')
      <div class="card mb-4">
        <div class="card-header card-no-border pb-0">
          <div class="header-top">
            <h3>
              <iconify-icon icon="solar:user-id-bold" class="text-warning me-1"></iconify-icon>
              Data Petugas
              <span class="badge bg-light-warning text-warning ms-2">{{ $petugas->count() }}</span>
            </h3>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="table-responsive theme-scrollbar mt-3">
            <table class="table display table-bordernone" style="width:100%">
              <thead>
                <tr>
                  <th width="50">#</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Dibuat</th>
                  <th class="text-center" width="100">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($petugas as $i => $u)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width:32px;height:32px;flex-shrink:0;">
                        <span class="fw-bold text-warning small">{{ strtoupper(substr($u->nama, 0, 1)) }}</span>
                      </div>
                      <h6 class="mb-0">{{ $u->nama }}</h6>
                    </div>
                  </td>
                  <td>{{ $u->email }}</td>
                  <td>{{ $u->created_at ? \Carbon\Carbon::parse($u->created_at)->format('d M Y') : '-' }}</td>
                  <td class="text-center">
                    <button type="button" class="btn bg-light-warning border-light-warning text-warning btn-sm me-1 btn-edit"
                      data-id="{{ $u->id }}" data-nama="{{ $u->nama }}" data-email="{{ $u->email }}" data-role="{{ $u->role }}"
                      data-bs-toggle="modal" data-bs-target="#modalEdit">
                      <i data-feather="edit-2" style="width:14px;height:14px"></i>
                    </button>
                    <button type="button" class="btn bg-light-danger border-light-danger text-danger btn-sm btn-hapus"
                      data-id="{{ $u->id }}" data-nama="{{ $u->nama }}"
                      data-bs-toggle="modal" data-bs-target="#modalHapus">
                      <i data-feather="trash-2" style="width:14px;height:14px"></i>
                    </button>
                  </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada data petugas</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif

      {{-- ===== SECTION ANGGOTA ===== --}}
      @if($anggota->isNotEmpty() || !$role || $role === 'anggota')
      <div class="card mb-4">
        <div class="card-header card-no-border pb-0">
          <div class="header-top">
            <h3>
              <iconify-icon icon="solar:users-group-rounded-bold" class="text-success me-1"></iconify-icon>
              Data Anggota
              <span class="badge bg-light-success text-success ms-2">{{ $anggota->count() }}</span>
            </h3>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="table-responsive theme-scrollbar mt-3">
            <table class="table display table-bordernone" style="width:100%">
              <thead>
                <tr>
                  <th width="50">#</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Dibuat</th>
                  <th class="text-center" width="100">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($anggota as $i => $u)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width:32px;height:32px;flex-shrink:0;">
                        <span class="fw-bold text-success small">{{ strtoupper(substr($u->nama, 0, 1)) }}</span>
                      </div>
                      <h6 class="mb-0">{{ $u->nama }}</h6>
                    </div>
                  </td>
                  <td>{{ $u->email }}</td>
                  <td>{{ $u->created_at ? \Carbon\Carbon::parse($u->created_at)->format('d M Y') : '-' }}</td>
                  <td class="text-center">
                    <button type="button" class="btn bg-light-warning border-light-warning text-warning btn-sm me-1 btn-edit"
                      data-id="{{ $u->id }}" data-nama="{{ $u->nama }}" data-email="{{ $u->email }}" data-role="{{ $u->role }}"
                      data-bs-toggle="modal" data-bs-target="#modalEdit">
                      <i data-feather="edit-2" style="width:14px;height:14px"></i>
                    </button>
                    <button type="button" class="btn bg-light-danger border-light-danger text-danger btn-sm btn-hapus"
                      data-id="{{ $u->id }}" data-nama="{{ $u->nama }}"
                      data-bs-toggle="modal" data-bs-target="#modalHapus">
                      <i data-feather="trash-2" style="width:14px;height:14px"></i>
                    </button>
                  </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Tidak ada data anggota</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif

    </div>
  </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form action="{{ route('admin.user.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
          <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
          <select name="role" class="form-select" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
            <option value="anggota">Anggota</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div></div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog"><div class="modal-content">
    <form id="formEdit" method="POST">
      @csrf @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" id="editNama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" id="editEmail" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
          <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
          <select name="role" id="editRole" class="form-select" required>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
            <option value="anggota">Anggota</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Update</button>
      </div>
    </form>
  </div></div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm"><div class="modal-content">
    <form id="formHapus" method="POST">
      @csrf @method('DELETE')
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title text-danger">Hapus User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-2">
        <p class="mb-0">Yakin hapus user <strong id="hapusNama"></strong>?</p>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
      </div>
    </form>
  </div></div>
</div>

@push('scripts')
<script>
  document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('formEdit').action = `/admin/user/${this.dataset.id}`;
      document.getElementById('editNama').value  = this.dataset.nama;
      document.getElementById('editEmail').value = this.dataset.email;
      document.getElementById('editRole').value  = this.dataset.role;
    });
  });
  document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('formHapus').action = `/admin/user/${this.dataset.id}`;
      document.getElementById('hapusNama').textContent = this.dataset.nama;
    });
  });
</script>
@endpush
@endsection
