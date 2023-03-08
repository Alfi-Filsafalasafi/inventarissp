<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lokasi;
use App\Models\Barang;
use App\Models\Peminjamans;
use App\Models\User;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lokasi = Lokasi::count();
        $user = User::count();
        $now = Carbon::now();
        $total_transaksi = DB::select("SELECT count(id) as jumlah from peminjamans where MONTH(tgl_pinjam) = $now->month");
        $total_transaksi = Peminjamans::whereMonth('tgl_pinjam', '=', "$now->month")->count();
        $belum = Peminjamans::where('status', '=', "Di Pinjam")->count();
        $sudah = Peminjamans::where('status', '=', "Di Kembalikan")->count();
        return view('home', compact('user', 'lokasi', 'total_transaksi','belum','sudah'));
    }
}
?>