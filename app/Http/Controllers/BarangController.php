<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lokasi;
use App\Models\Barang;

use File;


class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Lokasi $lokasi)
    {
        $barang = DB::select("SELECT * from barangs where id_lokasi = $lokasi->id"); 
        return view('barang.index', ['barangs' => $barang, 'lokasis' => $lokasi]);
    }
    public function cetak(Lokasi $lokasi){
        $barang = DB::select("SELECT * from barangs where id_lokasi = $lokasi->id"); 
        return view('barang.cetak', ['barangs' => $barang, 'lokasis' => $lokasi]);
    }
    public function create(Lokasi $lokasi)
    {
        return view('barang.tambah',['lokasis' => $lokasi]);
    }
    public function store(Request $request, Lokasi $lokasi)
    {
        $validateData = $request->validate([
            'nama' => 'required|min:3',
            'spesifikasi' => 'required|min:3',
            'kondisi' => 'required',
            'jumlah' => 'required',
            'jenis' => 'required|min:3',
            'foto' => 'required|mimes:jpeg,jpg,png|max:1000',
        ]);
        
        $extFile = $request->nama;
        $extensi = $request->foto->getClientOriginalExtension();
        $namaFile = $extFile."-".time().".".$extensi;
        $path = $request->foto->move('image/barang',$namaFile);

        $barang = new Barang();
        $barang->nama = $validateData['nama'];
        $barang->spesifikasi = $validateData['spesifikasi'];
        $barang->kondisi = $validateData['kondisi'];
        $barang->jumlah = $validateData['jumlah'];
        $barang->jenis = $validateData['jenis'];
        $barang->foto = $namaFile;
        $barang->tgl_masuk = now();
        $barang->id_lokasi = $lokasi->id;
        $barang->save();

        return redirect()->route('barang.index', ['lokasi' => $lokasi->id])
                ->with('tambah',"penambahan data {$validateData['nama']} berhasil");
    }
    public function destroy(Barang $barang){
        // dump($lokasi);
        //hapus file 

        $gambar = Barang::where('id',$barang->id)->first();
        // dump($gambar->id_lokasi);
        File::delete('image/barang/'.$gambar->foto);
        $gambar->delete();
        return redirect()->route('barang.index', ['lokasi' => $gambar->id_lokasi])->with('hapus',"hapus data $barang->nama berhasil");

    }

    public function edit(Barang $barang){
        return view('barang.edit',['barang' => $barang]);
    }

    public function update(Request $request, Barang $barang)
    {

        if($request->foto == ""){
            $validateData = $request->validate([
                'nama' => 'required|min:3',
                'spesifikasi' => 'required|min:3',
                'kondisi' => 'required',
                'jumlah' => 'required',
                'jenis' => 'required|min:3',
            ]);
            $barang = Barang::find($barang->id); 
            $lokasi = $barang->id_lokasi;
            $barang->nama = $validateData['nama'];
            $barang->spesifikasi = $validateData['spesifikasi'];
            $barang->kondisi = $validateData['kondisi'];
            $barang->jumlah = $validateData['jumlah'];
            $barang->jenis = $validateData['jenis'];
            $barang->save();
        } else {
            $validateData = $request->validate([
                'nama' => 'required|min:3',
                'spesifikasi' => 'required|min:3',
                'kondisi' => 'required',
                'jumlah' => 'required',
                'jenis' => 'required|min:3',
                'foto' => 'required|mimes:jpeg,jpg,png|max:1000',
            ]);

            $gambar = Barang::where('id',$barang->id)->first();
            File::delete('image/barang/'.$gambar->foto);

            $extFile = $request->nama;
            $extensi = $request->foto->getClientOriginalExtension();
            $namaFile = $extFile."-".time().".".$extensi;
            $path = $request->foto->move('image/barang',$namaFile);

            $barang = Barang::find($barang->id); 
            $lokasi = $barang->id_lokasi;
            $barang->nama = $validateData['nama'];
            $barang->spesifikasi = $validateData['spesifikasi'];
            $barang->kondisi = $validateData['kondisi'];
            $barang->jumlah = $validateData['jumlah'];
            $barang->jenis = $validateData['jenis'];
            $barang->foto = $namaFile;
            $barang->save();
        }
        return redirect()->route('barang.index', ['lokasi' => $lokasi])
                ->with('ubah',"perubahan data {$validateData['nama']} berhasil");
    }
}
