<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentController extends Controller
{
    /**
     * Tampilkan halaman konfirmasi pembayaran di HP (dari scan QR).
     */
    public function confirmPage(string $token): View
    {
        $pemesananId = Cache::get("payment_pemesanan_{$token}");
        $pemesanan = $pemesananId ? Pemesanan::with(['komputer', 'user'])->find($pemesananId) : null;

        return view('payment.confirm', compact('token', 'pemesanan'));
    }

    /**
     * Proses konfirmasi pembayaran dari HP — tandai token sebagai paid.
     */
    public function confirm(Request $request, string $token): JsonResponse|RedirectResponse
    {
        Cache::put("payment_status_{$token}", 'paid', now()->addMinutes(30));
        $pemesananId = Cache::get("payment_pemesanan_{$token}");
        $pemesanan = $pemesananId ? Pemesanan::with('komputer')->find($pemesananId) : null;

        if ($pemesanan) {
            $pemesanan->update(['status' => 'diterima']);
            $pemesanan->komputer()->update(['status_komputer' => 'dipesan']);

            Pembayaran::updateOrCreate(
                ['id_pemesanan' => $pemesanan->id_pemesanan],
                [
                    'nominal' => $pemesanan->nominal,
                    'status_pembayaran' => 'diterima',
                    'dibayar_pada' => now(),
                    'kode_qris' => $token,
                ],
            );
        }

        if (! $request->expectsJson()) {
            return redirect()->route('payment.struk', ['token' => $token]);
        }

        return response()->json(['status' => 'paid']);
    }

    /**
     * Polling endpoint: cek status pembayaran dari halaman layar utama.
     */
    public function status(string $token): JsonResponse
    {
        $status = Cache::get("payment_status_{$token}", 'pending');

        return response()->json(['status' => $status]);
    }

    /**
     * Server-Sent Events (SSE): stream status pembayaran secara real-time.
     */
    public function stream(string $token): StreamedResponse
    {
        return response()->stream(function () use ($token) {
            $maxWait = 300; // maksimal 5 menit
            $elapsed = 0;
            $interval = 2;

            while ($elapsed < $maxWait) {
                $status = Cache::get("payment_status_{$token}", 'pending');

                echo 'data: '.json_encode(['status' => $status])."\n\n";

                ob_flush();
                flush();

                if ($status === 'paid') {
                    break;
                }

                sleep($interval);
                $elapsed += $interval;
            }

            // Tutup stream
            echo 'data: '.json_encode(['status' => 'timeout'])."\n\n";
            ob_flush();
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Connection' => 'keep-alive',
        ]);
    }

    /**
     * Halaman struk setelah pembayaran berhasil dikonfirmasi.
     */
    public function struk(Request $request, ?string $token = null): View
    {
        if ($token !== null) {
            if (Cache::get("payment_status_{$token}") !== 'paid') {
                abort(404);
            }

            $pemesananId = Cache::get("payment_pemesanan_{$token}")
                ?? Pembayaran::where('kode_qris', $token)->value('id_pemesanan');
            $pemesanan = $pemesananId
                ? Pemesanan::with(['komputer', 'user'])->findOrFail($pemesananId)
                : abort(404);
        } else {
            $pemesanan = Pemesanan::with(['komputer', 'user'])
                ->where('id_user', $request->user()->id_user)
                ->latest('id_pemesanan')
                ->first();
        }

        return view('struk', compact('token', 'pemesanan'));
    }

    /**
     * Generate token pembayaran baru dan simpan ke session.
     */
    public static function generateToken(): string
    {
        return Str::random(32);
    }
}
