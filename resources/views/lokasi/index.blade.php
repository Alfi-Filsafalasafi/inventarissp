@extends('layouts.master')

@section('title')
    Daftar Lokasi Barang
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Lokasi Barang <small></small></li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12" style="margin-bottom :10px;">
        <a href="{{route('lokasi.create')}}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</a>
    </div>
    <div class="col-lg-12">
        @if(session()->has('tambah'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Berhasil !</h4>
                {{session()->get('tambah')}}
              </div>
        @endif
        @if(session()->has('ubah'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Berhasil !</h4>
                {{session()->get('ubah')}}
              </div>
        @endif
        @if(session()->has('hapus'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Berhasil !</h4>
                {{session()->get('hapus')}}
              </div>
        @endif
       
    </div>
    @forelse ($lokasis as $lokasi)
    <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="{{route('barang.index',['lokasi'=>$lokasi->id])}}"><span class="info-box-icon bg-aqua "><i class="fa fa-envelope-o"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">{{$lokasi->nama}}</span>
              <span class="info-box-number">0 <small>barang</small></span>
                <span><a href="{{route('lokasi.edit',['lokasi'=>$lokasi->id])}}" class="btn btn-warning btn-xs" style="margin: 2px;"><i class="fa fa-edit"></i></a>
                <a href="{{route('lokasi.delete',['lokasi'=>$lokasi->id])}}" class="btn btn-danger btn-xs" style="margin: 2px;"><i class="fa fa-trash"></i></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
    </div>
    @empty
    <td colspan="6" class="text-center">Tidak ada data...</td>
    @endforelse
</div>
@endsection


