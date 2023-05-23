<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class LokasiManajerController extends Controller
{
    public function index()
    {
        $pemin = Lokasi::all();
        $lokasi = DB::table('v_jumlah_barang_lokasi')->get();
        
        return view('manajer.lokasi.index', ['lokasis' => $lokasi]);
    }
}
