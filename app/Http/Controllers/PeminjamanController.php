<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjamans;


class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $peminjamans = DB::table('v_peminjaman')->get();
        return view('peminjaman.index', ['peminjamans' => $peminjamans]);
    }
    public function create()
    {
        $lokasi = DB::table('lokasis')->where('id', '!=', 0)->get();
        return view('peminjaman.tambah', ['lokasis' => $lokasi]);
    }

    public function getBarang(Request $request){
        $barang = DB::table('barangs')->where('id_lokasi',$request->id_lokasi)->pluck('id','nama'); 
        return response()->json($barang);
    }

    public function edit($peminjaman){
        // dump($peminjaman);
        $lokasi = DB::table('lokasis')->where('id', '!=', 0)->get();

        $peminjamans = DB::table('v_peminjaman')->where('id', $peminjaman)->first();
        return view('peminjaman.edit',['peminjamans' => $peminjamans, 'lokasis' => $lokasi]);
    }

    public function update(Request $request, Peminjamans $peminjaman)
    {
        $validateData = $request->validate([
            'tersedia' => 'required',
            'nama_peminjam' => 'required|min:3',
            'jumlah_pinjam' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali' => 'required',
            'kondisi' => 'required|min:3',
            'nama_pemberi' => 'required|min:3',
        ]);
            $peminjamans = Peminjamans::find($peminjaman->id); 
            $peminjamans->nama_peminjam = $validateData['nama_peminjam'];
            $peminjamans->id_barang = $request->barang;
            $peminjamans->jumlah = $validateData['jumlah_pinjam'];
            $peminjamans->tgl_pinjam = $validateData['tgl_pinjam'];
            $peminjamans->tgl_kembali = $validateData['tgl_kembali'];
            $peminjamans->kondisi = $validateData['kondisi'];
            $peminjamans->status = $request->status;
            $peminjamans->pemberi = $validateData['nama_pemberi'];
            $peminjamans->save();

            return redirect()->route('peminjaman.index')
            ->with('ubah',"perubahan data pinjaman {$validateData['nama_peminjam']} berhasil");
    }

    public function getTersedia(Request $request){
        $tersedia = DB::table('barangs')->where('id', $request->id_barang)->pluck('foto', 'jumlah');
        return response()->json($tersedia);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'tersedia' => 'required',
            'nama_peminjam' => 'required|min:3',
            'jumlah_pinjam' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali' => 'required',
            'kondisi' => 'required|min:3',
            'nama_pemberi' => 'required|min:3',
        ]);

        $peminjaman = new Peminjamans();
        $peminjaman->nama_peminjam = $validateData['nama_peminjam'];
        $peminjaman->id_barang = $request->barang;
        $peminjaman->jumlah = $validateData['jumlah_pinjam'];
        $peminjaman->tgl_pinjam = $validateData['tgl_pinjam'];
        $peminjaman->tgl_kembali = $validateData['tgl_kembali'];
        $peminjaman->kondisi = $validateData['kondisi'];
        $peminjaman->status = $request->status;
        $peminjaman->pemberi = $validateData['nama_pemberi'];
        $peminjaman->save();

        return redirect()->route('peminjaman.index')
                ->with('tambah',"peminjaman barang kepada {$validateData['nama_peminjam']} berhasil");
    }

    public function destroy(Peminjamans $peminjaman){

        $peminjaman = Peminjamans::where('id',$peminjaman->id)->first();
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('hapus',"Peminjaman atas nama $peminjaman->nama_peminjam berhasil di hapus");

    }
}
