<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Ambil pesanan terbaru (5 terakhir) beserta relasi komputer & user
        $pesananTerbaru = Pemesanan::with(['komputer', 'user'])
            ->orderBy('id_pemesanan', 'desc')
            ->limit(5)
            ->get();

        // Hitung pendapatan hari ini (status = diterima atau selesai)
        $pendapatanHariIni = Pemesanan::whereDate('tanggal_pemesanan', $today)
            ->whereIn('status', ['diterima', 'selesai'])
            ->sum('nominal');

        // Hitung total transaksi hari ini
        $totalTransaksiHariIni = Pemesanan::whereDate('tanggal_pemesanan', $today)->count();

        return view('dashboard', compact(
            'pesananTerbaru',
            'pendapatanHariIni',
            'totalTransaksiHariIni'
        ));
    }
}
