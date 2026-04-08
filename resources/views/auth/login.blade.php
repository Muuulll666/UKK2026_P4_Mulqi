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
            <form class="theme-form" action="{{ route('login') }}" method="POST">
              @csrf

              <h2 class="text-center">Sign in to account</h2>
              <p class="text-center">Enter your email &amp; password to login</p>

              {{-- Alert Error Global --}}
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

              {{-- Session Success (misal setelah logout) --}}
              @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
              @endif

              {{-- Email --}}
              <div class="form-group">
                <label class="col-form-label">Email Address</label>
                <input
                  class="form-control @error('email') is-invalid @enderror"
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  placeholder="Test@gmail.com"
                  required
                  autocomplete="email"
                >
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Password --}}
              <div class="form-group">
                <label class="col-form-label">Password</label>
                <div class="form-input position-relative">
                  <input
                    class="form-control @error('password') is-invalid @enderror"
                    type="password"
                    name="password"
                    placeholder="*********"
                    required
                    autocomplete="current-password"
                  >
                  <div class="show-hide"><span class="show"></span></div>
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Remember Me & Forgot Password --}}
              <div class="form-group mb-0 checkbox-checked">
                <div class="form-check checkbox-solid-info">
                  <input
                    class="form-check-input"
                    id="solid6"
                    type="checkbox"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                  >
                  <label class="form-check-label" for="solid6">Remember password</label>
                </div>
                <a class="link" href="">Forgot password?</a>

                <div class="text-end mt-3">
                  <button class="btn btn-primary btn-block w-100" type="submit">
                    Sign in
                  </button>
                </div>
              </div>

              {{-- Social Login --}}
              <div class="login-social-title">
                <h6>Or Sign in with</h6>
              </div>
              <div class="form-group">
                <ul class="login-social">
                  <li><a href="https://www.linkedin.com/" target="_blank"><i class="icon-linkedin"></i></a></li>
                  <li><a href="https://twitter.com/" target="_blank"><i class="icon-twitter"></i></a></li>
                  <li><a href="https://www.facebook.com/" target="_blank"><i class="icon-facebook"></i></a></li>
                  <li><a href="https://www.instagram.com/" target="_blank"><i class="icon-instagram"></i></a></li>
                </ul>
              </div>

              <p class="mt-4 mb-0 text-center">
                Don't have account?
                <a class="ms-2" href="{{ url('/register') }}">Create Account</a>
              </p>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Scripts --}}
  <script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/vendors/bootstrap/dist/js/popper.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/vendors/font-awesome/fontawesome-min.js') }}"></script>
  <script src="{{ asset('assets/js/password.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</div>
@endsection