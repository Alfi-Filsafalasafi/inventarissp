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
              <h3 class="box-title">Edit</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('user.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
              <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @error('nama') has-error @enderror">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" id="name" name="nama" class="form-control" value="{{ old('nama') ?? $user->name }}" placeholder="Masukkan nama">
                            @error('nama')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control" name="level">
                                <option value="admin"
                                {{(old('level') ?? $user->level) == 'admin' ? 'selected' : ''}}>
                                Admin</option>
                                <option value="manajer" 
                                {{(old('level') ?? $user->level) == 'manajer' ? 'selected' : ''}}>
                                Manajer</option>
                            </select>
                        </div>
                        <div class="form-group @error('foto') has-error @enderror">
                          <label for="exampleInputFile">Foto</label>
                          <input type="file" name="foto" id="foto" value="{{old('foto') }}">
                          @error('foto')
                                    <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                          <img id="preview-image-before-upload" src="{{asset('image/user/'.$user->foto)}}"
                            alt="preview image" style="max-height: 150px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @error('email') has-error @enderror">
                            <label for="exampleInputEmail1">Email address</label>
                            <input name="email" value="{{old('email') ?? $user->email}}" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            @error('email')
                            <span class="help-block">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('password') has-error @enderror">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" value="{{old('password')}}" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            <small>Kosongi jika tidak ingin merubah password</small>
                            @error('password')
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