@extends('layouts.master')

@section('title')
    Data User
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Data User <small></small></li>
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
        <div class="box">
            <div class="box-header with-border">
                <a href="{{route('user.create')}}" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</a>
            </div>
            <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Level</th>
                  <th>Foto</th>
                  <th width="15%"><i class="fa fa-cog"></i></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->level}}</td>
                        <td><img src="{{asset('/image/user/'.$user->foto)}}" alt="" srcset="" width="50"></td>
                        <td>
                        <div class="btn-group">
                            <a href="{{route('user.edit',['user'=>$user->id])}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-edit"></i></a>
                            <a href="{{route('user.delete',['user'=>$user->id])}}" onclick="return confirm('Apakah Anda yakin menghapus data ini ?')" class="btn btn-danger btn-sm" style="margin: 2px;"
                            {{ $user->email == auth()->user()->email ? 'disabled': '' }} ><i class="fa fa-trash"></i></a>
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


