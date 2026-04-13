@extends('auth.auth')
@section('form')
<div class="container-fluid p-0">
  <div class="row m-0">
    <div class="col-12 p-0">
      <div class="login-card login-dark">
        <div>
          <div>
            <a class="logo" href="{{ url('/') }}">
              <img class="img-fluid for-light m-auto" src="{{ asset('assets/images/logo/logo1.png') }}" alt="loginpage">
              <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo">
            </a>
          </div>

          <div class="login-main">
            <form class="theme-form" action="{{ route('register') }}" method="POST">
              @csrf

              <h2 class="text-center">Create your account</h2>
              <p class="text-center">Enter your details to register</p>

              @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
              @endif

              <div class="form-group">
                <label class="col-form-label">Nama Lengkap</label>
                <input
                  class="form-control @error('nama') is-invalid @enderror"
                  type="text"
                  name="nama"
                  value="{{ old('nama') }}"
                  placeholder="Masukkan nama lengkap"
                  required
                  autofocus
                >
                @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label class="col-form-label">Email Address</label>
                <input
                  class="form-control @error('email') is-invalid @enderror"
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  placeholder="nama@email.com"
                  required
                >
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label class="col-form-label">Password</label>
                <div class="form-input position-relative">
                  <input
                    class="form-control @error('password') is-invalid @enderror"
                    type="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    required
                  >
                  <div class="show-hide"><span class="show"></span></div>
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="form-group">
                <label class="col-form-label">Konfirmasi Password</label>
                <div class="form-input position-relative">
                  <input
                    class="form-control"
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                  >
                </div>
              </div>

              <div class="form-group mb-0">
                <div class="text-end mt-3">
                  <button class="btn btn-primary btn-block w-100" type="submit">Create Account</button>
                </div>
              </div>

              <div class="login-social-title">
                <h6>Or</h6>
              </div>

              <p class="mt-4 mb-0 text-center">
                Already have an account?
                <a class="ms-2" href="{{ route('login') }}">Sign in</a>
              </p>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/vendors/bootstrap/dist/js/popper.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/vendors/font-awesome/fontawesome-min.js') }}"></script>
  <script src="{{ asset('assets/js/password.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</div>
@endsection
