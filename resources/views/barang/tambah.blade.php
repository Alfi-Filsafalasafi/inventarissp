@extends('layouts.master')

@section('title')
    Data Barang di Lokasi  <b> {{$lokasis->nama}}</b>
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Tambah Data Barang di Lokasi <b> {{$lokasis->nama}}</b></li>
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
            <form action="{{route('barang.store', ['lokasi' => $lokasis])}}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @error('nama') has-error @enderror">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Masukkan nama">
                            @error('nama')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('tempat') has-error @enderror">
                          <label>Tempat</label>
                          <textarea name="tempat" class="form-control" rows="5" placeholder="Masukkan tempat">{{ old('tempat')}}</textarea>
                            @error('tempat')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('foto') has-error @enderror">
                          <label for="exampleInputFile">Foto</label>
                          <input type="file" name="foto" id="foto" value="{{old('foto')}}">
                          @error('foto')
                                    <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                <div class="form-group">
                <img id="preview-image-before-upload" src="{{asset('image/404.png')}}"
                      alt="preview image" style="max-height: 150px;">
                </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @error('kondisi') has-error @enderror">
                            <label for="exampleInputEmail1">Kondisi</label>
                            <input name="kondisi" value="{{old('kondisi')}}" class="form-control" id="exampleInputEmail1" placeholder="Masukkkan kondisi">
                            @error('kondisi')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('jenis') has-error @enderror">
                            <label for="exampleInputPassword1">Jenis</label>
                            <input type="text" name="jenis" value="{{old('jenis')}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan jenis">
                            @error('jenis')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('jumlah') has-error @enderror">
                            <label for="exampleInputPassword1">Jumlah</label>
                            <input type="number" name="jumlah" value="{{old('jumlah')}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan jumlah">
                            @error('jumlah')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('date') has-error @enderror">
                            <label for="exampleInputPassword1">Tanggal Masuk</label>
                            <input type="date" name="date" value="{{ $datenow->format('Y-m-d')}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan jumlah">
                            @error('date')
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
      <script src="{{ asset('jquery.js') }}"></script>
 
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