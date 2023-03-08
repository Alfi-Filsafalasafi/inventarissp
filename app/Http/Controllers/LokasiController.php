<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;


class LokasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $lokasi = Lokasi::all();
        return view('lokasi.index', ['lokasis' => $lokasi]);
    }
    public function create()
    {
        return view('lokasi.tambah');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|min:3|unique:lokasis',
        ]);
        

        $lokasi = new Lokasi();
        $lokasi->nama = $validateData['nama'];
        $lokasi->save();

        return redirect()->route('lokasi.index')
                ->with('tambah',"penambahan data {$validateData['nama']} berhasil");
    }

    public function destroy(Lokasi $lokasi){
        //hapus file 
        $lokasi->delete();
        return redirect()->route('lokasi.index')->with('hapus',"hapus data $lokasi->nama berhasil");

    }

    public function edit(Lokasi $lokasi){
        return view('lokasi.edit',['lokasi' => $lokasi]);
    }

    public function update(Request $request, Lokasi $lokasi)
    {
            $validateData = $request->validate([
                'nama' => 'required|min:3|unique:lokasis,nama,'.$lokasi->id,
            ]);
            $lokasi = Lokasi::find($lokasi->id); 
            $lokasi->nama = $validateData['nama'];
            $lokasi->save();
        
        return redirect()->route('lokasi.index')
                ->with('ubah',"perubahan data {$validateData['nama']} berhasil");
    }
}
