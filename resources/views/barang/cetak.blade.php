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
    @page {   /* auto is the initial value */
    margin: 20px;  /* this affects the margin in the printer settings */
}
.dt-buttons {
  margin-bottom: 10px;
  width:100%;
}


  </style>
  <title>
        <h3>
          <i class="fa fa-globe"></i> InventarisSP - Data Alat
          <br>
        </h3>
        <div>
        <b>Di cetak  : </b>{{now()}}<br>
        <b>Lokasi  : </b>{{$lokasis->nama}}<br>
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
              <i class="fa fa-globe"></i> InventarisSP - Data Alat
              <br>
            </h3>
              <b>Lokasi  : </b>{{$lokasis->nama}}<br>
              <b>User pencetak : </b>{{ auth()->user()->name }} <br>
            </div>
        <div class="box-body">
        <table id="example1" class="display" style="width:100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tempat</th>
            <th>Kondisi</th>
            <th>Jumlah</th>
            <th>Kebutuhan</th>
            <th>Keterangan</th>
            <th>Tanggal Masuk</th>
          </tr>
          </thead>
          <tbody>
          @forelse ($barangs as $barang)
                    <tr>
                        <td></td>
                        <td>{{$barang->nama}}</td>
                        <td>{{$barang->tempat}}</td>
                        <td>{{$barang->kondisi}}</td>
                        <td>{{$barang->total_barang}}</td>
                        <td>{{$barang->kebutuhan}}</td>
                        <td>{{$barang->total_barang - $barang->kebutuhan}}</td>
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
    <script src="{{asset('js/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
    <script>
    $(document).ready(function() {
    var table = $('#example1').DataTable({
        dom: 'lrtipB',
        columnDefs: [{
            searchable: false,
            orderable: false,
            targets: 0
        }],
        order: [[7, 'asc']],
        buttons: [
            {
                extend: 'print',
                className: 'btn-primary',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '12px' );

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                        var num = 1;
                        // $(win.document.body).find('table thead').append('<th>No</th>');
                        $(win.document.body).find('table tbody tr').each(function(index) {
    $(this).find('td:first').text(index + 1);
});


                    // move the div containing the data count information to the bottom of the body
                    var div = $('')
                        .insertAfter($(win.document.body).find( 'table' ));

                    // add CSS style to position the div at the bottom of the body
                    div.css({
                        'position': 'absolute',
                        'bottom': 0,
                        'left': 0,
                        'right': 0,
                        'text-align': 'left',
                        'float' : 'left'
                    });
                }
            }
        ]
    });

    var row_number = 1;

    table.on('order.dt search.dt draw.dt', function () {
        row_number = 1;
        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = row_number++;
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

    $('.dataTables_length', table.table().container()).parent().prepend(table.buttons().container());
});

</script>

</body>
</html>
