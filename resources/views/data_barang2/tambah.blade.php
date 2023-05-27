@extends('layouts.master')

@section('title')
    Data Barang {{$nama}}
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Tambah Data Barang {{$nama}}</li>
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
            <form action="{{route('data2.barang.store',['data_barang1' => $data_barang1 , 'nama' => $nama])}}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="box-body">
                        <div class="form-group @error('nama') has-error @enderror">
                            <label for="exampleInputEmail1">Nama Barang</label>
                            <input type="text" id="password" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Masukkan Data Barang">
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