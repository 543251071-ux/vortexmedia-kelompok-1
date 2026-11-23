<?php

namespace App\Http\Controllers;

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
        return view('payment.confirm', compact('token'));
    }

    /**
     * Proses konfirmasi pembayaran dari HP — tandai token sebagai paid.
     */
    public function confirm(Request $request, string $token): JsonResponse|RedirectResponse
    {
        Cache::put("payment_status_{$token}", 'paid', now()->addMinutes(30));

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
    public function struk(?string $token = null): View
    {
        if ($token !== null && Cache::get("payment_status_{$token}") !== 'paid') {
            abort(404);
        }

        return view('struk', compact('token'));
    }

    /**
     * Generate token pembayaran baru dan simpan ke session.
     */
    public static function generateToken(): string
    {
        return Str::random(32);
    }
}
