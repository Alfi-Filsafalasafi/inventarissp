<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjamans;
use Carbon\Carbon;


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
    public function cetak()
    {
        $peminjamans = DB::table('v_peminjaman')->get();
        return view('peminjaman.cetak', ['peminjamans' => $peminjamans]);
    }
    public function create($kode_pinjam)
    {
        $lokasi = DB::table('lokasis')->where('id', '!=', 0)->get();
        $datenow = Carbon::now();
        $perpage = 3;
        $barangdipinjam = DB::table('v_peminjaman')->where('kode_pinjam', $kode_pinjam)->get();
        if($kode_pinjam == 0) {
            $kode_pinjam = $datenow->format('YmdHis'); 
        }else {

        }// Mengubah format tanggal menjadi string YmdHis
        return view('peminjaman.tambah', ['lokasis' => $lokasi,  'kode_pinjam' => $kode_pinjam, 'datenow' => $datenow, 'barangpinjam' => $barangdipinjam]);
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
            'nama_pemberi' => 'required|min:3',
        ]);
            $peminjamans = Peminjamans::find($peminjaman->id); 
            $peminjamans->nama_peminjam = $validateData['nama_peminjam'];
            $peminjamans->id_barang = $request->barang;
            $peminjamans->jumlah = $validateData['jumlah_pinjam'];
            $peminjamans->tgl_pinjam = $validateData['tgl_pinjam'];
            if($request->tgl_kembali != ''){
            $peminjamans->tgl_kembali = $request->tgl_kembali;
            }
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

    public function storebarang(Request $request)
    {
        $validateData = $request->validate([
            'tersedia' => 'required',
            // 'nama_peminjam' => 'required|min:3',
            'jumlah_pinjam' => 'required',
            // 'tgl_pinjam' => 'required',
            // 'tgl_kembali' => 'required',
            // 'kondisi' => 'required|min:3',
            // 'nama_pemberi' => 'required|min:3',
        ]);
        $datenow = Carbon::now();
        $kode_pinjam = $request->kode_pinjam;

        $peminjaman = new Peminjamans();
        // $peminjaman->nama_peminjam = $validateData['nama_peminjam'];
        $peminjaman->id_barang = $request->barang;
        $peminjaman->jumlah = $validateData['jumlah_pinjam'];
        $peminjaman->kode_pinjam = $request->kode_pinjam;
        $peminjaman->save();

        $lokasi = DB::table('lokasis')->where('id', '!=', 0)->get();
        $datenow = Carbon::now();
        $barangdipinjam = DB::table('v_peminjaman')->where('kode_pinjam', $kode_pinjam)->get();
        // $kode_pinjam = array_map('intval', $kode_pinjam);
        if($kode_pinjam == 0) {
            $kode_pinjam = $datenow->format('YmdHis'); 
        }else {

        }// Mengubah format tanggal menjadi string YmdHis
        return redirect()->route('peminjaman.create', ['lokasis' => $lokasi,  'kode_pinjam' => $kode_pinjam, 'datenow' => $datenow, 'barangpinjam' => $barangdipinjam]);
        
    }

    public function finalisasi(Request $request, $kode_pinjam)
    {
        
        $validateData = $request->validate([
            'nama_peminjam' => 'required|min:3',
            'tgl_pinjam' => 'required',
            'nama_pemberi' => 'required|min:3',
        ]);
            $peminjamans = Peminjamans::where('kode_pinjam',$kode_pinjam)
            ->update(['nama_peminjam' => $validateData['nama_peminjam'], 'tgl_pinjam' => $validateData['tgl_pinjam'], 'pemberi' => $validateData['nama_pemberi'], 'status' => 'Di Pinjam']); 
            
            return redirect()->route('peminjaman.index')
            ->with('ubah',"Peminjaman barang untuk {$validateData['nama_peminjam']} berhasil");
        
    }

    public function destroy(Peminjamans $peminjaman){

        $peminjaman = Peminjamans::where('id',$peminjaman->id)->first();
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('hapus',"Peminjaman atas nama $peminjaman->nama_peminjam berhasil di hapus");

    }

    public function batalPinjam($kode_pinjam){

        $peminjaman = Peminjamans::where('kode_pinjam',$kode_pinjam);
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('hapus',"Peminjaman Di Batalkan");

    }

    public function destroybarangpinjam(Peminjamans $peminjaman, $kode_pinjam){

        $peminjaman = Peminjamans::where('id',$peminjaman->id)->first();
        $peminjaman->delete();

        $lokasi = DB::table('lokasis')->where('id', '!=', 0)->get();
        $datenow = Carbon::now();
        $barangdipinjam = DB::table('v_peminjaman')->where('kode_pinjam', $kode_pinjam)->get();
        // $kode_pinjam = array_map('intval', $kode_pinjam);
        if($kode_pinjam == 0) {
            $kode_pinjam = $datenow->format('YmdHis'); 
        }else {

        }// Mengubah format tanggal menjadi string YmdHis
        return redirect()->route('peminjaman.create', ['lokasis' => $lokasi,  'kode_pinjam' => $kode_pinjam, 'datenow' => $datenow, 'barangpinjam' => $barangdipinjam]);
    }


    public function statusUbah($id)
    {
        
        
            $peminjamans = Peminjamans::find($id)->first();
            $datenow = Carbon::now();
            // dump($peminjamans->status);
            if($peminjamans->status == "Di Pinjam"){
                $peminjamans = Peminjamans::where('id',$id)
                ->update(['status' => 'Di Kembalikan', 'tgl_kembali' => $datenow]); 
            }
            elseif($peminjamans->status == "Di Kembalikan"){
                $peminjamans = Peminjamans::where('id',$id)
                ->update(['status' => 'Di Pinjam', 'tgl_kembali' => '']); 
            }
            return redirect()->route('peminjaman.index')
            ->with('ubah',"berhasil status");
        
    }
}
