@extends('manajer.layouts.master')

@section('title')
    Data Lokasi Alat
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Data Lokasi Alat <small></small></li>
@endsection

@section('content')
<div class="row">
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
    <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="{{route('barang.index.manajer',['lokasi'=>$lokasi->id])}}"><span class="info-box-icon bg-aqua "><i class="fa fa-inbox"></i></span></a>

            <div class="info-box-content">
                <span class="info-box-text">{{$lokasi->nama}}</span>
                <span class="info-box-number" name="jumlah" id="jumlah"> {{$lokasi->jumlah_barang}} <small>Model Alat</small></span>  
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
    </div>
    @empty
    <center>Tidak ada Data</center>
    @endforelse
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
              text: "Data barang yang ada di lokasi ini juga akan terhapus.",
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


