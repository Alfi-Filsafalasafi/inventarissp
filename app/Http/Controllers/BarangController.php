<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lokasi;
use App\Models\Barang;
use Carbon\Carbon;


use File;


class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Lokasi $lokasi)
    {
        $barang = DB::table('barangs')
          ->where('id_lokasi', $lokasi->id)
          ->orderByDesc('created_at')
          ->get();
        return view('barang.index', ['barangs' => $barang, 'lokasis' => $lokasi]);
    }
    public function cetak(Lokasi $lokasi){
        $barang = DB::select("SELECT * from barangs where id_lokasi = $lokasi->id"); 
        return view('barang.cetak', ['barangs' => $barang, 'lokasis' => $lokasi]);
    }
    public function create(Lokasi $lokasi)
    {
        $datenow = Carbon::now();
        return view('barang.tambah',['lokasis' => $lokasi, 'datenow' => $datenow]);
    }
    public function store(Request $request, Lokasi $lokasi)
    {
        $validateData = $request->validate([
            'nama' => 'required|min:3',
            'tempat' => 'required|min:3',
            'kondisi' => 'required',
            'jumlah' => 'required',
            'kebutuhan' => 'required',
            'jenis' => 'required|min:3',
            'date' => 'required',
            // 'foto' => 'required|mimes:jpeg,jpg,png|max:1000',
            'foto' => 'mimes:jpeg,jpg,png|max:1000',
        ]);
        
        

        $barang = new Barang();
        $barang->nama = $validateData['nama'];
        $barang->tempat = $validateData['tempat'];
        $barang->kondisi = $validateData['kondisi'];
        $barang->jumlah = $validateData['jumlah'];
        $barang->total_barang = $validateData['jumlah'];
        $barang->kebutuhan = $validateData['kebutuhan'];
        $barang->jenis = $validateData['jenis'];
        if($request->foto == '') {

        }else {
            $extFile = $request->nama;
            $extensi = $request->foto->getClientOriginalExtension();
            $namaFile = $extFile."-".time().".".$extensi;
            $path = $request->foto->move('image/barang',$namaFile);
            $barang->foto = $namaFile;
        }
        $barang->tgl_masuk = $validateData['date'];
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

    public function edit(Barang $barang, Lokasi $lokasi){
        return view('barang.edit',['barang' => $barang, 'lokasi' => $lokasi]);
    }

    public function update(Request $request, Barang $barang)
    {
        

        // dump($total_awal, $tersedia, $total_akhir, $hasil_tersedia);

        if($request->foto == ""){
            $validateData = $request->validate([
                'nama' => 'required|min:3',
                'tempat' => 'required|min:3',
                'kondisi' => 'required',
                'jumlah' => 'required',
                'date' => 'required',
                'kebutuhan' => 'required',
                'jenis' => 'required|min:3',
            ]);

            $barangnih = Barang::where('id',$barang->id)->first();
            $total_awal = $barangnih->total_barang;
            $tersedia = $barangnih->jumlah;
            $total_akhir = $request->jumlah;

            if($total_awal > $total_akhir) {
                $selisih = $total_awal - $total_akhir;
                $hasil_tersedia = $tersedia - $selisih;
            }else {
                $selisih = $total_akhir - $total_awal;
                $hasil_tersedia = $tersedia + $selisih;
            }
            $barang = Barang::find($barang->id); 
            $lokasi = $barang->id_lokasi;
            $barang->nama = $validateData['nama'];
            $barang->tempat = $validateData['tempat'];
            $barang->kondisi = $validateData['kondisi'];
            $barang->tgl_masuk = $validateData['date'];
            $barang->total_barang = $validateData['jumlah'];
            $barang->kebutuhan = $validateData['kebutuhan'];
            $barang->jumlah = $hasil_tersedia;
            $barang->jenis = $validateData['jenis'];
            $barang->save();
        } else {
            $validateData = $request->validate([
                'nama' => 'required|min:3',
                'tempat' => 'required|min:3',
                'kondisi' => 'required',
                'jumlah' => 'required',
                'kebutuhan' => 'required',
                'jenis' => 'required|min:3',
                'foto' => 'required|mimes:jpeg,jpg,png|max:1000',
            ]);
            $barangnih = Barang::where('id',$barang->id)->first();
            $total_awal = $barangnih->total_barang;
            $tersedia = $barangnih->jumlah;
            $total_akhir = $request->jumlah;

            if($total_awal > $total_akhir) {
                $selisih = $total_awal - $total_akhir;
                $hasil_tersedia = $tersedia - $selisih;
            }else {
                $selisih = $total_akhir - $total_awal;
                $hasil_tersedia = $tersedia + $selisih;
            }

            $gambar = Barang::where('id',$barang->id)->first();
            File::delete('image/barang/'.$gambar->foto);

            $extFile = $request->nama;
            $extensi = $request->foto->getClientOriginalExtension();
            $namaFile = $extFile."-".time().".".$extensi;
            $path = $request->foto->move('image/barang',$namaFile);

            $barang = Barang::find($barang->id); 
            $lokasi = $barang->id_lokasi;
            $barang->nama = $validateData['nama'];
            $barang->tempat = $validateData['tempat'];
            $barang->kondisi = $validateData['kondisi'];
            $barang->total_barang = $validateData['jumlah'];
            $barang->kebutuhan = $validateData['kebutuhan'];
            $barang->jumlah = $hasil_tersedia;
            $barang->jenis = $validateData['jenis'];
            $barang->foto = $namaFile;
            $barang->save();
        }
        return redirect()->route('barang.index', ['lokasi' => $lokasi])
                ->with('ubah',"perubahan data {$validateData['nama']} berhasil");
    }
}
