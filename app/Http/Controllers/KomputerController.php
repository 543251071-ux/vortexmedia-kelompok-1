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
