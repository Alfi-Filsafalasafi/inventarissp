<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjamans;
use App\Models\Barang;
use Carbon\Carbon;

class PeminjamanManajerController extends Controller
{
    public function index()
    {
        $peminjamans = DB::table('v_peminjaman')->orderByDesc('created_at')->get();
        return view('manajer.peminjaman.index', ['peminjamans' => $peminjamans]);
    }
    public function cetak()
    {
        $peminjamans = DB::table('v_peminjaman')->orderBy('created_at', 'asc')->get();
        return view('manajer.peminjaman.cetak', ['peminjamans' => $peminjamans]);
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
        return view('manajer.peminjaman.tambah', ['lokasis' => $lokasi,  'kode_pinjam' => $kode_pinjam, 'datenow' => $datenow, 'barangpinjam' => $barangdipinjam]);
    }

    public function getBarang(Request $request){
        $barang = DB::table('barangs')->where('id_lokasi',$request->id_lokasi)->pluck('id','nama'); 
        return response()->json($barang);
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
        return redirect()->route('peminjaman.create.manajer', ['lokasis' => $lokasi,  'kode_pinjam' => $kode_pinjam, 'datenow' => $datenow, 'barangpinjam' => $barangdipinjam]);
        
    }

    public function finalisasi(Request $request, $kode_pinjam)
    {
        
        $validateData = $request->validate([
            'nama_peminjam' => 'required|min:3',
            'tgl_pinjam' => 'required',
            'nama_pemberi' => 'required|min:3',
            'guru_pengampu' => 'required|min:3',
        ]);
            $peminjamans = Peminjamans::where('kode_pinjam',$kode_pinjam)
            ->update(['nama_peminjam' => $validateData['nama_peminjam'],'guru_pengampu' => $validateData['guru_pengampu'], 'tgl_pinjam' => $validateData['tgl_pinjam'], 'pemberi' => $validateData['nama_pemberi'], 'status' => 'Di Proses']); 
            
            return redirect()->route('peminjaman.index.manajer')
            ->with('ubah',"Peminjaman barang untuk {$validateData['nama_peminjam']} berhasil");
        
    }


    public function batalPinjam($kode_pinjam){

        $peminjaman = Peminjamans::where('kode_pinjam',$kode_pinjam);
        $peminjaman->delete();
        return redirect()->route('peminjaman.index.manajer')->with('hapus',"Peminjaman Di Batalkan");

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
        return redirect()->route('peminjaman.create.manajer', ['lokasis' => $lokasi,  'kode_pinjam' => $kode_pinjam, 'datenow' => $datenow, 'barangpinjam' => $barangdipinjam]);
    }


    public function statusUbah($id)
    {
        
        
            $peminjamans = Peminjamans::find($id);
            $datenow = Carbon::now();
            // dump($peminjamans->status);
            if($peminjamans->status == "Di Proses"){
                $id_barang = $peminjamans->id_barang;
                $databarang = DB::table('barangs')->where('id', $peminjamans->id_barang)->first();
                $tersedia = $databarang->jumlah;
                $jumlahpinjam = $peminjamans->jumlah;
                $stokakhir = $tersedia - $jumlahpinjam;
                // dump($tersedia, $jumlahpinjam, $stokakhir);
                $peminjamans = Peminjamans::where('id',$id)
                ->update(['status' => 'Di Pinjam']); 

                $barangs = Barang::where('id',$id_barang)
                ->update(['jumlah' => $stokakhir]); 

                $keterangan = DB::table('v_peminjaman')->where('id', $id)->first();
                return redirect()->route('peminjaman.index')
                ->with('info',"Peminjaman barang $keterangan->nama_barang oleh $keterangan->nama_peminjam berhasil di Pinjam");
            }elseif($peminjamans->status == "Di Pinjam"){
                $id_barang = $peminjamans->id_barang;
                $databarang = DB::table('barangs')->where('id', $peminjamans->id_barang)->first();
                $tersedia = $databarang->jumlah;
                $jumlahpinjam = $peminjamans->jumlah;
                $stokakhir = $tersedia + $jumlahpinjam;
                $peminjamans = Peminjamans::where('id',$id)
                ->update(['status' => 'Di Kembalikan', 'tgl_kembali' => $datenow]); 

                $barangs = Barang::where('id',$id_barang)
                ->update(['jumlah' => $stokakhir]); 

                $keterangan = DB::table('v_peminjaman')->where('id', $id)->first();
                return redirect()->route('peminjaman.index.manajer')
                ->with('info',"Peminjaman barang $keterangan->nama_barang oleh $keterangan->nama_peminjam berhasil di kembalikan");
            }
            
        
    }
}
