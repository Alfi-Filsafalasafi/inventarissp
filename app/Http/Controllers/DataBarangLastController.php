<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang2;
use App\Models\DataBarang1;
use App\Models\DataBarangLast;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use File;



class DataBarangLastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($data_barang1, $nama, $nama_barang2){
        $data_barang = DB::table('barangtambahanlast')
               ->where('id_barangtambahan2', $data_barang1)
               ->get();

        return view('data_baranglast.index', 
        ['data_barang2' => $data_barang1,
        'data_barangs' => $data_barang, 
        'nama' =>$nama,
        'nama_barang2' => $nama_barang2]);
    }

    public function cetak($data_barang1, $nama, $nama_barang2){
        $data_barang = DB::table('barangtambahanlast')
        ->where('id_barangtambahan2', $data_barang1)
        ->get();
        return view('data_baranglast.cetak', 
        ['data_barang2' => $data_barang1,
        'data_barangs' => $data_barang, 
        'nama' =>$nama,
        'nama_barang2' => $nama_barang2]);  
    }

    public function  create($data_barang2, $nama, $nama_barang2){
        $datenow = Carbon::now();
        
        return view('data_baranglast.tambah', 
        ['data_barang2' => $data_barang2, 
        'nama' =>$nama,
        'nama_barang2' => $nama_barang2,
    'datenow' => $datenow]);
    }

    public function store(Request $request, $data_barang2, $nama, $nama_barang2)
    {
        $validateData = $request->validate([
            'nama' => 'required|min:3',
            'keterangan' => 'required|min:3',
            'masuk' => 'required',
            'keluar' => 'required',
            'kebutuhan' => 'required',
            'tersedia' => 'required',
            'date' => 'required',
            'foto' => 'mimes:jpeg,jpg,png|max:1000',
        ]);
        
        

        $barang = new DataBarangLast();
        $barang->nama = $validateData['nama'];
        $barang->keterangan= $validateData['keterangan'];
        $barang->masuk = $validateData['masuk'];
        $barang->keluar = $validateData['keluar'];
        $barang->tersedia = $validateData['tersedia'];
        $barang->kebutuhan = $validateData['kebutuhan'];
        if($request->foto == '') {

        }else {
            $extFile = $request->nama;
            $extensi = $request->foto->getClientOriginalExtension();
            $namaFile = $extFile."-".time().".".$extensi;
            $path = $request->foto->move('image/data_barang',$namaFile);
            $barang->foto = $namaFile;
        }
        $barang->tgl = $validateData['date'];
        $barang->id_barangtambahan2 = $data_barang2;
        $barang->save();

        return redirect()->route('datalast.barang.index', 
        ['data_barang2' => $data_barang2,
        'nama' =>$nama,
        'nama_barang2' => $nama_barang2])
                ->with('tambah',"penambahan data {$validateData['nama']} berhasil");
    }

    public function destroy($data_barang2, $nama, $nama_barang2, DataBarangLast $data_baranglast){
        $barang = DataBarangLast::where('id',$data_baranglast->id)->first();
        File::delete('image/data_barang/'.$barang->foto);
        

        $data_baranglast->delete();
        
        return redirect()->route('datalast.barang.index', 
        ['data_barang2' => $data_barang2, 
        'nama' =>$nama,
        'nama_barang2' => $nama_barang2])
        ->with('hapus',"hapus data $data_baranglast->nama berhasil");
    }

    public function edit($data_barang2, $nama, $nama_barang2, DataBarangLast $data_baranglast){
        return view('data_baranglast.edit', 
        ['data_baranglast' => $data_baranglast,
            'data_barang2' => $data_barang2, 
        'nama' =>$nama,
        'nama_barang2' => $nama_barang2]);
    }

    public function update(Request $request, $data_barang2, $nama, $nama_barang2,DataBarangLast $data_baranglast)
    {
        // dump($data_baranglast->id);
        $validateData = $request->validate([
            'nama' => 'required|min:3',
            'keterangan' => 'required|min:3',
            'masuk' => 'required',
            'keluar' => 'required',
            'kebutuhan' => 'required',
            'tersedia' => 'required',
            'date' => 'required',
            'foto' => 'mimes:jpeg,jpg,png|max:1000',
        ]);
        
        

        $barang = DataBarangLast::where('id',$data_baranglast->id)->first();
        $barang->nama = $validateData['nama'];
        $barang->keterangan= $validateData['keterangan'];
        $barang->masuk = $validateData['masuk'];
        $barang->keluar = $validateData['keluar'];
        $barang->tersedia = $validateData['tersedia'];
        $barang->kebutuhan = $validateData['kebutuhan'];
        if($request->foto == '') {

        }else {
            File::delete('image/data_barang/'.$barang->foto);

            $extFile = $request->nama;
            $extensi = $request->foto->getClientOriginalExtension();
            $namaFile = $extFile."-".time().".".$extensi;
            $path = $request->foto->move('image/data_barang',$namaFile);
            $barang->foto = $namaFile;
        }
        $barang->tgl = $validateData['date'];
        $barang->id_barangtambahan2 = $data_barang2;
        $barang->save();

        return redirect()->route('datalast.barang.index', 
        ['data_barang2' => $data_barang2,
        'nama' =>$nama,
        'nama_barang2' => $nama_barang2])
                ->with('tambah',"penambahan data {$validateData['nama']} berhasil");
    }


}
