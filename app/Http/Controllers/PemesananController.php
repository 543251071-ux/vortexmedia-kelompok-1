<?php

namespace App\Http\Controllers;

use App\Models\Komputer;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PemesananController extends Controller
{
    public function rent(Request $request): View
    {
        $komputers = Komputer::where('status_komputer', 'kosong')
            ->orderBy('nomor_komputer')
            ->get();
        $pemesananId = $request->session()->get('pemesanan_id');
        $pemesanan = $pemesananId
            ? Pemesanan::with('komputer')
                ->where('id_user', $request->user()->id_user)
                ->find($pemesananId)
            : null;

        return view('rent', compact('komputers', 'pemesanan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'computer_id' => ['required', 'integer', 'exists:tb_komputer,id_komputer'],
            'tanggal_pemesanan' => ['required', 'date', 'after_or_equal:today'],
            'lama_pemesanan' => ['required', 'integer', 'min:1', 'max:24'],
        ]);

        $mulai = Carbon::createFromFormat('Y-m-d', $validated['tanggal_pemesanan'])->startOfDay();
        $akhir = $mulai->copy()->addHours((int) $validated['lama_pemesanan']);

        if ($akhir->toDateString() !== $mulai->toDateString()) {
            return back()->withErrors([
                'lama_pemesanan' => 'Durasi pemesanan tidak boleh melewati tengah malam.',
            ])->withInput();
        }

        $user = $request->user();
        $lamaPemesanan = (int) $validated['lama_pemesanan'];
        $pemesanan = DB::transaction(function () use ($validated, $user, $lamaPemesanan, $mulai, $akhir): Pemesanan {
            $komputer = Komputer::whereKey($validated['computer_id'])->lockForUpdate()->firstOrFail();

            if ($komputer->status_komputer !== 'kosong') {
                throw ValidationException::withMessages([
                    'computer_id' => 'Komputer tersebut tidak tersedia.',
                ]);
            }

            $bentrokan = Pemesanan::where('computer_id', $komputer->id_komputer)
                ->where('tanggal_pemesanan', $validated['tanggal_pemesanan'])
                ->whereIn('status', ['pending', 'diterima'])
                ->exists();

            if ($bentrokan) {
                throw ValidationException::withMessages([
                    'computer_id' => 'Komputer sudah dipesan pada tanggal tersebut.',
                ]);
            }

            $user->update(['nama' => $validated['nama']]);

            $pemesanan = Pemesanan::create([
                'id_user' => $user->id_user,
                'computer_id' => $komputer->id_komputer,
                'tanggal_pemesanan' => $validated['tanggal_pemesanan'],
                'waktu_mulai' => $mulai->format('H:i:s'),
                'lama_pemesanan' => $lamaPemesanan,
                'waktu_akhir' => $akhir->format('H:i:s'),
                'nominal' => $lamaPemesanan * 7000,
                'status' => 'pending',
            ]);

            $komputer->update(['status_komputer' => 'dipesan']);

            return $pemesanan;
        });

        $token = PaymentController::generateToken();
        Cache::put("payment_pemesanan_{$token}", $pemesanan->id_pemesanan, now()->addMinutes(30));

        return redirect()->route('rent')->with([
            'success' => 'Data pemesanan berhasil disimpan.',
            'payment_token' => $token,
            'pemesanan_id' => $pemesanan->id_pemesanan,
        ]);
    }

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
