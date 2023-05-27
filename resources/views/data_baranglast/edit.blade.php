@extends('layouts.master')

@section('title')
  Data Barang <b> {{$nama_barang2}}</b>
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Edit Data Barang <b> {{$nama_barang2}}</b></li>
@endsection

@section('content')
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Edit</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('datalast.barang.update', ['data_baranglast' => $data_baranglast->id, 'data_barang2' => $data_barang2, 'nama' => $nama, 'nama_barang2' => $nama_barang2])}}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @error('nama') has-error @enderror">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') ?? $data_baranglast->nama }}" placeholder="Masukkan nama">
                            @error('nama')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('keterangan') has-error @enderror">
                          <label>Keterangan</label>
                          <textarea name="keterangan" class="form-control" rows="5" placeholder="Masukkan keterangan">{{ old('keterangan') ?? $data_baranglast->keterangan}}</textarea>
                            @error('tempat')
                            <span class="help-block">{{$message}}</span>
                            @enderror
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
                        <img id="preview-image-before-upload" src="{{ asset('image/data_barang/'. $data_baranglast->foto)}}"
                              alt="Belum ada foto yang di upload" style="max-height: 150px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @error('masuk') has-error @enderror">
                            <label for="exampleInputEmail1">Masuk</label>
                            <input type="number" name="masuk" value="{{old('masuk') ?? $data_baranglast->masuk}}" class="form-control" id="exampleInputEmail1" placeholder="Masukkkan masuk">
                            @error('masuk')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('keluar') has-error @enderror">
                            <label for="exampleInputPassword1">Keluar</label>
                            <input type="text" name="keluar" value="{{old('keluar') ?? $data_baranglast->keluar}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan keluar">
                            @error('keluar')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('tersedia') has-error @enderror">
                            <label for="exampleInputPassword1">Tersedia</label>
                            <input type="number" name="tersedia" value="{{old('tersedia') ?? $data_baranglast->tersedia}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan jumlah">
                            @error('tersedia')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('kebutuhan') has-error @enderror">
                            <label for="exampleInputPassword1">Kebutuhan</label>
                            <input type="number" name="kebutuhan" value="{{old('kebutuhan') ?? $data_baranglast->kebutuhan}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan jumlah">
                            @error('kebutuhan')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('date') has-error @enderror">
                            <label for="exampleInputPassword1">Tanggal Masuk</label>
                            <input type="date" name="date" value="{{old('date') ?? $data_baranglast->tgl}}" class="form-control" id="exampleInputPassword1" placeholder="Masukkan jumlah">
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