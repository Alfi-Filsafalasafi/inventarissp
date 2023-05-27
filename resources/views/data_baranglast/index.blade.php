@extends('layouts.master')

@section('title')
    Data {{$nama_barang2}}
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Data <b> {{$nama_barang2}}</b></li>
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
                <a href="{{route('datalast.barang.create', ['data_barang2' => $data_barang2, 'nama' => $nama, 'nama_barang2' => $nama_barang2])}}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</a>
                <a href="{{route('datalast.barang.cetak', ['data_barang2'=> $data_barang2, 'nama' => $nama, 'nama_barang2' => $nama_barang2])}} " target="_blank" class="btn btn-info btn-xs btn-flat"><i class="fa fa-print"></i> Print</a>
            </div>
            <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Masuk</th>
                  <th>Keluar</th>
                  <th>Tersedia</th>
                  <th>Kebutuhan</th>
                  <th>Realisasi</th>
                  <th>Keterangan</th>
                  <th>Foto</th>
                  <th>Tanggal</th>
                  <th width="55"><i class="fa fa-cog"></i></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($data_barangs as $barang)
                    <tr>
                        <!-- <th>{{$loop->iteration}}</th> -->
                       <th>
                       {{ ($loop->iteration - 1) + ((isset($_GET['page'])) ? ($_GET['page'] - 1) * $barangs->perPage() : 1) }}

                       </th>
                        <td>{{$barang->nama}}</td>
                        <td>{{$barang->masuk}}</td>
                        <td>{{$barang->keluar}}</td>
                        <td>{{$barang->tersedia}}</td>
                        <td>{{$barang->kebutuhan }}</td>
                        <td>{{$barang->tersedia - $barang->kebutuhan}}</td>
                        <td>{{$barang->keterangan}}</td>
                        <td><img src="{{asset('/image/data_barang/'.$barang->foto)}}" alt="" srcset="" width="50"></td>
                        <td>{{$barang->tgl}}</td>
                        <td>
                        <div class="btn-group">
                            <form method="POST" action="{{route('datalast.barang.delete', ['data_baranglast' => $barang->id,'data_barang2'=> $data_barang2, 'nama' => $nama, 'nama_barang2' => $nama_barang2])}}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <a href="{{route('datalast.barang.edit', ['data_baranglast' => $barang->id, 'data_barang2'=> $data_barang2, 'nama' => $nama, 'nama_barang2' => $nama_barang2])}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-edit"></i></a>
                                <a href="{{route('datalast.barang.delete', ['data_baranglast' => $barang->id, 'data_barang2'=> $data_barang2, 'nama' => $nama, 'nama_barang2' => $nama_barang2])}}" class="btn btn-danger btn-sm show_confirm" style="margin: 2px;"><i class="fa fa-trash"></i></a>
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
<script>
  $(function () {
    var table = $('#example1').DataTable({
      'dom': 'lrtipB',
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
    });

    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // add new column for searching all columns
    table.columns().every(function () {
        var column = this;
        var header = $(column.header());
        var title = header.text().trim();
        if (title === "") {
            title = "column-" + column.index();
        }
        $('<input class="form-control form-control-sm" type="text" placeholder="Search ' + title + '" style="width:100%" />').appendTo(header).on('keyup change clear', function () {
            if (column.search() !== this.value) {
                column.search(this.value).draw();
            }
        });
    });
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>
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




