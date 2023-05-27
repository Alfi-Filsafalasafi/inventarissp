<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang1;
use Illuminate\Support\Facades\DB;


class DataBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // $data_barang = DataBarang1::all();
        $data_barang = DB::table('v_jumlah_barangtambahan1')->get();
        
        return view('data_barang.index', ['data_barangs' => $data_barang]);
    }

    public function create()
    {
        return view('data_barang.tambah');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|min:3',
        ]);
        

        $lokasi = new DataBarang1();
        $lokasi->nama = $validateData['nama'];
        $lokasi->save();

        return redirect()->route('data.barang.index')
                ->with('tambah',"penambahan data {$validateData['nama']} berhasil");
    }

    public function edit(DataBarang1 $data_barang){
        return view('data_barang.edit',['data_barang' => $data_barang]);
    }

    public function update(Request $request, DataBarang1 $data_barang)
    {
            $validateData = $request->validate([
                'nama' => 'required|min:3',
            ]);
            $data_barang = DataBarang1::find($data_barang->id); 
            $data_barang->nama = $validateData['nama'];
            $data_barang->save();
        
        return redirect()->route('data.barang.index')
                ->with('ubah',"perubahan data {$validateData['nama']} berhasil");
    }

    public function destroy(DataBarang1 $data_barang){
        //hapus file 
        $data_barang->delete(); 
        // $hapusbarangdilokasi = Barang::where('id_lokasi', $lokasi->id)->delete();
        // dump($hapusbarangdilokasi);
        // $hapusbarangdilokasi->delete();
        return redirect()->route('data.barang.index')->with('hapus',"hapus data $data_barang->nama beserta barang di lokasinya berhasil");

    }
}
