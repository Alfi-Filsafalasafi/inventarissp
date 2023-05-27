<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang2;
use App\Models\DataBarang1;
use Illuminate\Support\Facades\DB;



class DataBarang2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($data_barang1, $nama)
    {
        // $data_barang = DataBarang2::all();
        // $data_barang = DataBarang2::where('id_barangtambahan1', $data_barang1)->get();
        $data_barang = DB::table('v_jumlah_barangtambahan2')
                    ->where('id_barangtambahan1', $data_barang1)
                    ->get();
        
        return view('data_barang2.index', ['data_barang1' => $data_barang1,'data_barangs' => $data_barang, 'nama' =>$nama]);
    }
    public function create($data_barang1, $nama)
    {
        return view('data_barang2.tambah', ['data_barang1' => $data_barang1, 'nama' =>$nama]);
    }

    public function store(Request $request, $data_barang1, $nama)
    {
        $validateData = $request->validate([
            'nama' => 'required|min:3',
        ]);
        

        $lokasi = new DataBarang2();
        $lokasi->nama = $validateData['nama'];
        $lokasi->id_barangtambahan1 = $data_barang1;
        $lokasi->save();

        return redirect()->route('data2.barang.index',['data_barang1' => $data_barang1, 'nama' =>$nama])
                ->with('tambah',"penambahan data {$validateData['nama']} berhasil");
    }

    public function edit(DataBarang2 $data_barang, $data_barang1, $nama){
        // dump($data_barang1);
        return view('data_barang2.edit',['data_barang' => $data_barang, 'data_barang1' => $data_barang1, 'nama' =>$nama]);
    }

    public function update(Request $request, DataBarang2 $data_barang,$data_barang1, $nama)
    {
            $validateData = $request->validate([
                'nama' => 'required|min:3',
            ]);
            $data_barang = DataBarang2::find($data_barang->id); 
            $data_barang->nama = $validateData['nama'];
            $data_barang->save();
        
        return redirect()->route('data2.barang.index', ['data_barang1' => $data_barang1, 'nama' =>$nama])
                ->with('ubah',"perubahan data {$validateData['nama']} berhasil");
    }

    public function destroy(DataBarang2 $data_barang, $data_barang1, $nama){
        //hapus file 
        $data_barang->delete(); 
        // $hapusbarangdilokasi = Barang::where('id_lokasi', $lokasi->id)->delete();
        // dump($hapusbarangdilokasi);
        // $hapusbarangdilokasi->delete();
        return redirect()->route('data2.barang.index', ['data_barang1' => $data_barang1, 'nama' =>$nama])->with('hapus',"hapus data $data_barang->nama beserta barang di lokasinya berhasil");

    }
}
