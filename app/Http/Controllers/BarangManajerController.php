<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lokasi;
use App\Models\Barang;
use Carbon\Carbon;

class BarangManajerController extends Controller
{
    public function index(Lokasi $lokasi)
    {
        $barang = DB::select("SELECT * from barangs where id_lokasi = $lokasi->id"); 
        return view('manajer.barang.index', ['barangs' => $barang, 'lokasis' => $lokasi]);
    }
    public function cetak(Lokasi $lokasi){
        $barang = DB::select("SELECT * from barangs where id_lokasi = $lokasi->id"); 
        return view('manajer.barang.cetak', ['barangs' => $barang, 'lokasis' => $lokasi]);
    }
}
