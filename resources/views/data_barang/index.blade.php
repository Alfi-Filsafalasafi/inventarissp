@extends('layouts.master')

@section('title')
    Data Barang
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Data Barang<small></small></li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12" style="margin-bottom :10px;">
        <a href="{{route('data.barang.create')}}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</a>
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
    @forelse ($data_barangs as $data_barang)
    <div class="col-lg-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="{{route('data2.barang.index' , ['data_barang1' => $data_barang->id, 'nama' => $data_barang->nama])}}"><span class="info-box-icon bg-aqua "><i class="fa fa-inbox"></i></span></a>

            <div class="info-box-content">
                <span class="info-box-text">{{$data_barang->nama}}</span>
                <span class="info-box-number" name="jumlah" id="jumlah">{{$data_barang->jumlah}} <small>Model Barang</small></span>
                <span>
                    <form method="POST" action="{{route('data.barang.delete' , ['data_barang' => $data_barang->id])}}">
                        @csrf
                        
                         <input name="_method" type="hidden" value="DELETE">
                            <a href="{{route('data.barang.edit' , ['data_barang' => $data_barang->id])}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-edit"></i></a>
                            <a href="{{route('data.barang.delete' , ['data_barang' => $data_barang->id])}}" class="btn btn-danger btn-sm show_confirm" style="margin: 2px;"><i class="fa fa-trash"></i></a>
                    </form>
                </span>
                
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
              text: "Data Alat yang ada di lokasi ini juga akan terhapus.",
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


