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
        $total_transaksi = DB::select("SELECT count(id) as jumlah from peminjamans WHERE MONTH(tgl_pinjam) = $now->month AND YEAR(tgl_pinjam) = $now->year");
        $belum = Peminjamans::where('status', 'Di Pinjam')
                    ->orWhere('status', 'Di Proses')
                    ->count();
        $sudah = DB::select("SELECT count(id) as jumlah from peminjamans WHERE MONTH(tgl_pinjam) = $now->month AND YEAR(tgl_pinjam) = $now->year AND status = 'Di Kembalikan'");
        // dump($sudah[0]->jumlah);
        return view('home', compact('user', 'lokasi', 'total_transaksi','belum','sudah'));
    }
}
?>