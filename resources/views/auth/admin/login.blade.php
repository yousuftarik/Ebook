@extends('backend.layouts.auth')

@section('content')
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
    <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
      <div class="row w-100">
        <div class="col-lg-4 mx-auto">
          @if ($message = Session::get('sticky_error'))

          <div class="alert alert-danger alert-block">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <strong>{{ $message }}</strong>

          </div>

          @endif
          <div class="auto-form-wrapper">
            <form method="POST" action="{{ route('admin.login.submit') }}">
              @csrf
              <div class="form-group">
                <label class="label">Email</label>
                <div class="input-group">
                  <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    value="{{ old('email') }}" required autofocus placeholder="Email">
                  @if ($errors->has('email'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="label">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" required placeholder="Password">
                  @if ($errors->has('password'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                  @endif
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-primary submit-btn btn-block">Login</button>
              </div>
              <div class="form-group d-flex justify-content-between">
                <div class="form-check form-check-flat mt-0">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" {{ old('remember') ? 'checked' : '' }} checked> Keep
                    me signed in
                  </label>
                </div>
                <a href="{{ route('admin.password.request') }}" class="text-small forgot-password text-black">Forgot
                  Password</a>
              </div>

            </form>
          </div>
          <ul class="auth-footer">
            <li>
              <a href="#">Conditions</a>
            </li>
            <li>
              <a href="#">Help</a>
            </li>
            <li>
              <a href="#">Terms</a>
            </li>
          </ul>
          <p class="footer-text text-center">copyright © 2018 Tigerley. All rights reserved.</p>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
@endsection