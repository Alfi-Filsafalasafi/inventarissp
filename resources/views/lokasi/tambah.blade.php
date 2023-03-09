@extends('layouts.master')

@section('title')
    Data Lokasi Barang
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Tambah Data Lokasi Barang</li>
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
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{route('lokasi.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="box-body">
                        <div class="form-group @error('nama') has-error @enderror">
                            <label for="exampleInputEmail1">Nama Lokasi</label>
                            <input type="text" id="password" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Masukkan lokasi">
                            @error('nama')
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