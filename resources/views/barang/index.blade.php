@extends('layouts.master')

@section('title')
    Data Barang di Lokasi <b> {{$lokasis->nama}}</b>
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Data Barang <b> {{$lokasis->nama}}</b></li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
    @if(session()->has('tambah'))
    <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" style="color-white" data-dismiss="alert" aria-hidden="true">&times;</button>
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
        <div class="box">
            <div class="box-header with-border">
                <a href="{{route('barang.create', ['lokasi'=>$lokasis])}}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</a>
                <a href="{{route('barang.cetak', ['lokasi'=>$lokasis])}}" target="_blank" class="btn btn-info btn-xs btn-flat"><i class="fa fa-print"></i> Print</a>
            </div>
            <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Spesifikasi</th>
                  <th>Kondisi</th>
                  <th>Jumlah</th>
                  <th>Tanggal Masuk</th>
                  <th>Foto</th>
                  <th width="55"><i class="fa fa-cog"></i></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$barang->nama}}</td>
                        <td>{{$barang->spesifikasi}}</td>
                        <td>{{$barang->kondisi}}</td>
                        <td>{{$barang->jumlah}}</td>
                        <td>{{$barang->tgl_masuk}}</td>
                        <td><img src="{{asset('/image/barang/'.$barang->foto)}}" alt="" srcset="" width="50"></td>
                        <td>
                        <div class="btn-group">
                            <form method="POST" action="{{ route('barang.delete', $barang->id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <a href="{{route('barang.edit',['barang'=>$barang->id, 'lokasi'=>$barang->id_lokasi])}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-edit"></i></a>
                                <a href="{{route('barang.delete',['barang'=>$barang->id])}}" class="btn btn-danger btn-sm show_confirm" style="margin: 2px;"><i class="fa fa-trash"></i></a>
                            </form>
                        </div>
                        </td>
                        </tr>
                    @empty
                    <td colspan="6" class="text-center">Tidak ada data...</td>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script_alert_confir')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: "Apakah anda yakin untuk menghapus data ini ?",
              text: "",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
@endsection




