<?php

namespace App\Http\Controllers;

use App\Services\BackgroundRemovalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class BackgroundRemovalController extends Controller
{
    public function store(Request $request, BackgroundRemovalService $service): JsonResponse
    {
        $validated = $request->validate([
            'image' => [
                'required',
                File::image()
                    ->types(config('bgify.allowed_mimes'))
                    ->max(config('bgify.max_upload_kb')),
            ],
        ], [
            'image.required' => 'Silakan pilih gambar terlebih dahulu.',
            'image.max' => 'Ukuran gambar maksimal 10 MB.',
        ]);

        try {
            return response()->json([
                'message' => 'Background berhasil dihapus.',
                'data' => $service->remove($validated['image']),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Gagal menghapus background. Coba lagi dengan gambar lain.',
            ], 500);
        }
    }

    public function download(string $jobId, string $quality = 'standard'): StreamedResponse
    {
        abort_unless(preg_match('/^[a-f0-9-]{36}$/', $jobId) === 1, 404);

        $path = "bgify/{$jobId}/bgify-transparent.png";
        abort_unless(Storage::disk('public')->exists($path), 404);

        $filename = $quality === 'hd' ? 'bgify-hd-transparent.png' : 'bgify-transparent.png';

        return Storage::disk('public')->download($path, $filename, [
            'Content-Type' => 'image/png',
        ]);
    }

    public function show(string $jobId): BinaryFileResponse
    {
        abort_unless(preg_match('/^[a-f0-9-]{36}$/', $jobId) === 1, 404);

        $path = "bgify/{$jobId}/bgify-transparent.png";
        abort_unless(Storage::disk('public')->exists($path), 404);

        return response()->file(Storage::disk('public')->path($path), [
            'Cache-Control' => 'no-store, max-age=0',
            'Content-Type' => 'image/png',
        ]);
    }
}
