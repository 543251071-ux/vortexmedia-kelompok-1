<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pesananDiterima = Pemesanan::where('status', 'diterima');

        // Ambil pesanan terbaru (5 terakhir) beserta relasi komputer & user
        $pesananTerbaru = Pemesanan::with(['komputer', 'user'])
            ->orderBy('id_pemesanan', 'desc')
            ->limit(5)
            ->get();

        // Hitung pendapatan dari semua pesanan yang telah diterima
        $pendapatanHariIni = (int) $pesananDiterima
            ->select(DB::raw('SUM(lama_pemesanan * 7000) as total'))
            ->value('total');

        // Hitung total transaksi yang sudah diterima
        $totalTransaksiHariIni = $pesananDiterima->count();

        return view('dashboard', compact(
            'pesananTerbaru',
            'pendapatanHariIni',
            'totalTransaksiHariIni'
        ));
    }
}
