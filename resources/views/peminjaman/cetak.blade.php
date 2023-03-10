<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('AdminLTE-2/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('AdminLTE-2/bower_components/font-awesome/css/font-awesome.min.css')}}">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('AdminLTE-2/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{asset('AdminLTE-2/dist/css/AdminLTE.min.css')}}">

  <style>
    @page {
    width: 100%;   /* auto is the initial value */
    margin: 20px;  /* this affects the margin in the printer settings */
}


  </style>
  <title>
        <h3>
          <i class="fa fa-globe"></i> InventarisSP - Data Peminjaman
          <br>
        </h3>
        <div>
        <b>Di cetak  : </b>{{now()}}<br>
        <b>User pencetak : </b>{{ auth()->user()->name }} <br>
        </div>
        <br>
  </title>
</head>
<body>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
            <h3>
              <i class="fa fa-globe"></i> InventarisSP - Data Barang
              <br>
            </h3>
              <b>User pencetak : </b>{{ auth()->user()->name }} <br>
            </div>
        </div>
        <div class="box-body">
        <table id="example1" class="display" style="width:100%">
        <thead>
            <tr>
            <th>No</th>
            <th>Nama Peminjaman</th>
            <th>Barang</th>
            <th>Lokasi</th>
            <th>QTY</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Kondisi</th>
            <th>Status</th>
            <th>Pemberi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$peminjaman->nama_peminjam}}</td>
                        <td>{{$peminjaman->nama_barang ?? 'Di hapus'}}</td>
                        <td>{{$peminjaman->lokasi_barang ?? 'Di hapus'}}</td>
                        <td>{{$peminjaman->jumlah}}</td>
                        <td>{{$peminjaman->tgl_pinjam}}</td>
                        <td>{{$peminjaman->tgl_kembali}}</td>
                        <td>{{$peminjaman->kondisi}}</td>
                        <td>
                            @if($peminjaman->status == 'Di Kembalikan')
                            <span class="label label-success">{{$peminjaman->status}}</span>
                            @else
                            <span class="label label-danger">{{$peminjaman->status}}</span>
                            @endif
                        </td>
                        <td>{{$peminjaman->pemberi}}</td>
                        
                        
                        
                    @empty
                    <td colspan="6" class="text-center">Tidak ada data...</td>
                    </tr>
                    @endforelse
                    @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$peminjaman->nama_peminjam}}</td>
                        <td>{{$peminjaman->nama_barang ?? 'Di hapus'}}</td>
                        <td>{{$peminjaman->lokasi_barang ?? 'Di hapus'}}</td>
                        <td>{{$peminjaman->jumlah}}</td>
                        <td>{{$peminjaman->tgl_pinjam}}</td>
                        <td>{{$peminjaman->tgl_kembali}}</td>
                        <td>{{$peminjaman->kondisi}}</td>
                        <td>
                            @if($peminjaman->status == 'Di Kembalikan')
                            <span class="label label-success">{{$peminjaman->status}}</span>
                            @else
                            <span class="label label-danger">{{$peminjaman->status}}</span>
                            @endif
                        </td>
                        <td>{{$peminjaman->pemberi}}</td>
                        
                        
                        
                    @empty
                    <td colspan="6" class="text-center">Tidak ada data...</td>
                    </tr>
                    @endforelse

        </tbody>
    </table>
        </div>
    </div>
</div>
    <script src="{{asset('js/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
    <script>
    $(document).ready(function() {
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                className: 'btn-primary',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '12px' )
                        .prepend(
                        );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                    $(win.document.body).find( 'section' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            }
        ]
    } );
} );
</script> 
</body>
</html>
