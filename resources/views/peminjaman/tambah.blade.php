@extends('layouts.master')

@section('title')
    Data Peminjaman
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Tambah Data Peminjaman</li>
@endsection

@section('content')
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{route('peminjaman.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group @error('tersedia') has-error @enderror">
                      <label>Lokasi Barang</label>
                      <select class="form-control" name="lokasi" id="lokasi">
                      <option>---- Pilih Lokasi ----</option>
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group @error('tersedia') has-error @enderror">
                      <label>Nama Barang</label>
                      <select class="form-control" name="barang" id="barang">
                        <option>---- Pilih Barang ----</option>
                      </select>
                    </div>
                    <div class="form-group @error('tersedia') has-error @enderror">
                            <label for="exampleInputEmail1">Tersedia</label>
                            <input type="text" name="tersedia" id="tersedia" class="form-control" readonly>
                            @error('tersedia')
                            <span class="help-block">Belum ada data, silahkan pilih lokasi dan nama barang terlebih dahulu</span>
                            @enderror
                        </div>
                    <div class="form-group">
                          <label for="">Foto Barang</label> <br>
                          <img id="preview-image-before-upload" src="{{asset('image/404.png')}}"
                                alt="preview image" style="max-height: 109px;">
                        </div>
                        <div class="form-group @error('kondisi') has-error @enderror">
                            <label for="">Kondisi</label>
                            <input type="text" name="kondisi" id="kondisi" value="{{old('kondisi')}}" class="form-control">
                            @error('kondisi')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @error('nama_peminjam') has-error @enderror">
                            <label for="nama_peminjam">Nama Peminjam</label>
                            <input name="nama_peminjam" value="{{old('nama_peminjam')}}" class="form-control" id="nama_peminjam" placeholder="Masukkan nama peminjam">
                            @error('nama_peminjam')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('jumlah_pinjam') has-error @enderror">
                            <label for="exampleInputPassword1">Jumlah Pinjam</label>
                            <input type="number" name="jumlah_pinjam" value="{{old('jumlah_pinjam')}}" class="form-control" id="" placeholder="Masukkan jumlah pinjam">
                            @error('jumlah_pinjam')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('tgl_pinjam') has-error @enderror">
                            <label for="">Tanggal Pinjam</label>
                            <input type="date" name="tgl_pinjam" value="{{old('tgl_pinjam')}}" class="form-control" id="">
                            @error('tgl_pinjam')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('tgl_kembali') has-error @enderror">
                            <label for="exampleInputPassword1">Tanggal Kembali</label>
                            <input type="date" name="tgl_kembali" value="{{old('tgl_kembali')}}" class="form-control" id="">
                            @error('tgl_kembali')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('status') has-error @enderror">
                          <label>Status</label>
                          <select class="form-control" name="status">
                            <option value="Di Pinjam">Di Pinjam</option>
                            <option value="Di Kembalikan">Di Kembalikan</option>
                          </select>
                          @error('status')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('nama_pemberi') has-error @enderror">
                            <label for="nama_pemberi">Nama Pemberi Pinjaman</label>
                            <input name="nama_pemberi" value="{{old('nama_pemberi')}}" class="form-control" id="nama_pemberi" placeholder="Masukkan nama pemberi pinjaman">
                            @error('nama_pemberi')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
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
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
 
<script type="text/javascript">
      
$(document).ready(function (e) {
 
   
   $('#barang').change(function(){
            
    let reader = new FileReader();
 
    reader.onload = (e) => { 
 
      $('#preview-image-before-upload').attr('src', e.target.result); 
    }
 
    reader.readAsDataURL(this.files[0]); 
   
   });
   
});
 
</script>
<script>
  $('#lokasi').change(function(){
    $("#tersedia").val("");
    var id_lokasi = $(this).val();    
    if(id_lokasi){
        $.ajax({
           url:"/getbarang?id_lokasi="+id_lokasi,
           method:"GET",
           dataType: 'json',
           success:function(res){               
            if(res){
                $("#barang").empty();
                $("#barang").append('<option>--- Pilih Barang ---</option>');
                $.each(res,function(nama,id){
                    $("#barang").append('<option value="'+id+'">'+nama+'</option>');
                    
                });
            }else{
               $("#barang").empty();
            }
           }
        });
    }else{
        $("#barang").empty();
    }      
   });
</script>
<script>
  $('#barang').change(function(){
    $("#tersedia").val("");
    var id_barang = $(this).val();    
    if(id_barang){
        $.ajax({
           url:"/gettersedia?id_barang="+id_barang,
           method:"GET",
           dataType: 'json',
           success:function(res){               
            if(res){
              $.each(res, function(jumlah, foto){
                $("#tersedia").val(jumlah);
                var asline = "http://localhost:8000/image/barang/"+foto+"";
                $('#preview-image-before-upload').attr('src', asline); 
                
              });
            }else{
               $("#tersedia").val = "";
               $("#kondisi").val("");
            }
           }
        });
    }else{
        $("#tersedia").val = "";
        $("#kondisi").val("");
    }      
   });
</script>
@endsection