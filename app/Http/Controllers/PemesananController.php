<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\View\View;

class PemesananController extends Controller
{
    /**
     * Tampilkan semua data pemesanan dari tb_pemesanan
     * beserta relasi komputer & user.
     */
    public function index(): View
    {
        $pemesanans = Pemesanan::with(['komputer', 'user'])
            ->orderBy('id_pemesanan', 'desc')
            ->get();

        return view('pemesanan', compact('pemesanans'));
    }
}
