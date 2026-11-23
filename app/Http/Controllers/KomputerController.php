<?php

namespace App\Http\Controllers;

use App\Models\Komputer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KomputerController extends Controller
{
    /**
     * Tampilkan semua data komputer dari tb_komputer.
     */
    public function index(): View
    {
        $komputers = Komputer::orderBy('nomor_komputer')->get();

        return view('komputer', compact('komputers'));
    }

    /**
     * Tambahkan komputer baru ke tb_komputer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_komputer' => ['required', 'string', 'regex:/^(?:Komputer\s*)?\d+$/i'],
            'deskripsi' => ['required', 'string', 'max:255'],
        ], [
            'nomor_komputer.required' => 'Nomor komputer wajib diisi.',
            'nomor_komputer.regex' => 'Masukkan nomor komputer, contoh: 6 atau Komputer 6.',
            'deskripsi.required' => 'Spesifikasi komputer wajib diisi.',
            'deskripsi.max' => 'Spesifikasi komputer maksimal 255 karakter.',
        ]);

        preg_match('/\d+$/', $validated['nomor_komputer'], $matches);
        $nomorKomputer = (int) $matches[0];

        if (Komputer::where('nomor_komputer', $nomorKomputer)->exists()) {
            return redirect()->route('komputer')
                ->withErrors(['nomor_komputer' => "Komputer {$nomorKomputer} sudah ada."])
                ->withInput();
        }

        Komputer::create([
            'nomor_komputer' => $nomorKomputer,
            'spek_komputer' => $validated['deskripsi'],
            'status_komputer' => 'kosong',
        ]);

        return redirect()->route('komputer')
            ->with('success', "Komputer {$nomorKomputer} berhasil ditambahkan.");
    }

    /**
     * Update status komputer di database.
     */
    public function updateStatus(Request $request, Komputer $komputer): RedirectResponse
    {
        $request->validate([
            'status_komputer' => ['required', 'in:dipakai,kosong,dipesan,maintenance'],
        ]);

        $komputer->update([
            'status_komputer' => $request->status_komputer,
        ]);

        return redirect()->route('komputer')->with('success', 'Status komputer berhasil diperbarui.');
    }
}
