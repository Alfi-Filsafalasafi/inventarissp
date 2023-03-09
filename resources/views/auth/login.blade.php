@extends('layouts.auth')
@section('login')
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>InventarisSP</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Silahkan Login</p>

    <form action="{{ route('login') }}" method="post">
        @csrf
      <div class="form-group has-feedback @error('email') has-error @enderror">
        <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @error('email')
            <span class="help-block"> {{ $message }}</span>
        @enderror
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection