@extends('layouts.auth')
@section('login')


<div class="login-box">
@if(session()->has('error'))

<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4> Login Gagal !</h4>
    <h5>{{session()->get('error')}}</h5>
  </div>
  @endif
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
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="display: flex; justify-content: center;">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
      <p class="login-box-msg">atau</p>
      <a href="{{route('home.manajer')}}" style="display: block; margin: 0 auto; text-align: center;">Masuk sebagai Manager</a>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection