@extends('manajer.layouts.master')

@section('title')
    Data Alat di Lokasi <b> {{$lokasis->nama}}</b>
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Data Alat <b> {{$lokasis->nama}}</b></li>
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
                <a href="{{route('barang.cetak.manajer', ['lokasi'=>$lokasis])}}" target="_blank" class="btn btn-info btn-xs btn-flat"><i class="fa fa-print"></i> Print</a>
            </div>
            <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Tempat</th>
                  <th>Kondisi</th>
                  <th>Jumlah</th>
                  <th>Kebutuhan</th>
                  <th>Keterangan</th>
                  <th>Foto</th>
                  <th>Tanggal Masuk</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <!-- <th>{{$loop->iteration}}</th> -->
                       <th>
                       {{ ($loop->iteration - 1) + ((isset($_GET['page'])) ? ($_GET['page'] - 1) * $barangs->perPage() : 1) }}

                       </th>
                        <td>{{$barang->nama}}</td>
                        <td>{{$barang->tempat}}</td>
                        <td>{{$barang->kondisi}}</td>
                        <td>{{$barang->total_barang}}</td>
                        <td>{{$barang->kebutuhan }}</td>
                        <td>{{$barang->total_barang - $barang->kebutuhan}}</td>
                        <td><img src="{{asset('/image/barang/'.$barang->foto)}}" alt="" srcset="" width="50"></td>
                        <td>{{$barang->tgl_masuk}}</td>
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




