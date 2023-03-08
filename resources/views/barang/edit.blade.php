@extends('layouts.master')

@section('title')
    Data User
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Edit Data User</li>
@endsection

@section('content')
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('barang.update', ['barang' => $barang->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @error('nama') has-error @enderror">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') ?? $barang->nama }}" placeholder="Masukkan nama">
                            @error('nama')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('spesifikasi') has-error @enderror">
                          <label>Spesifikasi</label>
                          <textarea name="spesifikasi" class="form-control" rows="5" placeholder="Masukkan spesifikasi">{{ old('spesifikasi') ?? $barang->spesifikasi}}</textarea>
                            @error('spesifikasi')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @error('kondisi') has-error @enderror">
                            <label for="exampleInputEmail1">Kondisi</label>
                            <input name="kondisi" value="{{old('kondisi') ?? $barang->kondisi}}" class="form-control" id="exampleInputEmail1" placeholder="Masukkkan kondisi">
                            @error('kondisi')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('jenis') has-error @enderror">
                            <label for="exampleInputPassword1">Jenis</label>
                            <input type="text" name="jenis" value="{{old('jenis') ?? $barang->jenis}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan jenis">
                            @error('jenis')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('jumlah') has-error @enderror">
                            <label for="exampleInputPassword1">Jumlah</label>
                            <input type="number" name="jumlah" value="{{old('jumlah') ?? $barang->jumlah}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan jumlah">
                            @error('jumlah')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                  
                <div class="form-group @error('foto') has-error @enderror">
                  <label for="exampleInputFile">Foto</label>
                  <input type="file" name="foto" id="foto" value="{{old('foto')}}">
                  <small>Kosongi jika tidak ingin merubah</small>
                  @error('foto')
                            <span class="help-block">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                <img id="preview-image-before-upload" src="{{asset('image/barang/'. $barang->foto)}}"
                      alt="preview image" style="max-height: 150px;">
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
 
<script type="text/javascript">
      
$(document).ready(function (e) {
 
   
   $('#foto').change(function(){
            
    let reader = new FileReader();
 
    reader.onload = (e) => { 
 
      $('#preview-image-before-upload').attr('src', e.target.result); 
    }
 
    reader.readAsDataURL(this.files[0]); 
   
   });
   
});
 
</script>
@endsection