@extends('layouts.master')

@section('title')
    Ganti Password
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Ganti Password</li>
@endsection

@section('content')
      <div class="row">
        <!-- left column -->
        
        <div class="col-md-6">
        @if(session()->has('tambah'))
        <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Berhasil !</h4>
                    {{session()->get('tambah')}}
        </div>
        @endif
          <!-- general form elements -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Ganti Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{route('pass.update')}}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
              <div class="box-body">
                        <div class="form-group @error('password') has-error @enderror">
                            <label for="exampleInputEmail1">Password Baru</label>
                            <input type="hidden" value="{{ auth()->user()->id }}" name="id">
                            <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Masukkan nama">
                            @error('password')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>   
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
            </form>
          </div>
         

        </div>
      </div>

@endsection