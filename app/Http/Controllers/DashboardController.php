<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today()->toDateString();

        // Ambil pesanan terbaru (5 terakhir) beserta relasi komputer & user
        $pesananTerbaru = Pemesanan::with(['komputer', 'user'])
            ->orderBy('id_pemesanan', 'desc')
            ->limit(5)
            ->get();

        // Pendapatan hari ini = total nominal semua pesanan hari ini (1 jam = Rp 7.000)
        $pendapatanHariIni = (int) Pemesanan::where('tanggal_pemesanan', $today)
            ->sum('nominal');

        // Total transaksi hari ini = jumlah pesanan masuk hari ini
        $totalTransaksiHariIni = Pemesanan::where('tanggal_pemesanan', $today)
            ->count();

        return view('dashboard', compact(
            'pesananTerbaru',
            'pendapatanHariIni',
            'totalTransaksiHariIni'
        ));
    }
}
