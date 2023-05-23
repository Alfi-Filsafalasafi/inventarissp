@extends('manajer.layouts.master')

@section('title')
    Data Peminjaman
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Data Peminjaman <small></small></li>
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
    @if(session()->has('info'))
    <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Berhasil !</h4>
                {{session()->get('info')}}
              </div>
    @endif
        <div class="box">
            <div class="box-header with-border">
                <a href="{{route('peminjaman.create.manajer', ['kode_pinjam'=>'0']) }}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</a>
                <a href="{{route('peminjaman.cetak.manajer')}}" target="_blank" class="btn btn-info btn-xs btn-flat"><i class="fa fa-print"></i> Print</a>
            </div>
            <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Peminjaman</th>
                  <th>Guru Pengampu</th>
                  <th>Alat</th>
                  <th>Lokasi</th>
                  <th>Tempat</th>
                  <th>Jumlah</th>
                  <th>Tanggal Pinjam</th>
                  <th>Tanggal Kembali</th>
                  <th>Status</th>
                  <th>Pemberi</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$peminjaman->nama_peminjam}}</td>
                        <td>{{$peminjaman->guru_pengampu ?? 'Di hapus'}}</td>
                        <td>{{$peminjaman->nama_barang ?? 'Di hapus'}}</td>
                        <td>{{$peminjaman->lokasi_barang ?? 'Di hapus'}}</td>
                        <td>{{$peminjaman->tempat ?? 'Di hapus'}}</td>
                        <td>{{$peminjaman->jumlah}}</td>
                        <td>{{$peminjaman->tgl_pinjam}}</td>
                        <td>{{$peminjaman->tgl_kembali}}</td>
                        <td>
                            @if($peminjaman->status == 'Di Proses')
                            
                            <span class="label label-warning">{{$peminjaman->status}}</span>
                            @elseif($peminjaman->status == 'Di Kembalikan')
                            
                            <span class="label label-success">{{$peminjaman->status}}</span>
                            @else
                                    <span class="label label-danger">{{$peminjaman->status}}</span>
                            @endif
                        </td>
                        <td>{{$peminjaman->pemberi}}</td>
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


