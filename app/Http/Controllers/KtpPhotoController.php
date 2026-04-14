<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Enums\UserRole; 

class KtpPhotoController extends Controller
{
    /**
     * Serve a KTP photo securely from private storage.
     * Only the photo owner or admins may access it.
     */
    public function show(Request $request, string $filename): StreamedResponse
    {
        $user = $request->user();

        // Build the storage path (ktp_photos/{filename})
        $path = 'ktp_photos/' . $filename;

        // 1. Cek Kepemilikan (Lebih aman jika string path berbeda sedikit)
        $isOwner = $user->ktp_photo === $path || (is_string($user->ktp_photo) && str_ends_with($user->ktp_photo, $filename));

        // 2. Cek Hak Akses menggunakan Enum (Anti-Gagal)
        $isPrivileged = false;

        // Pengecekan jika role sudah di-cast menjadi instance Enum di Model User
        if ($user->role instanceof UserRole) {
            $isPrivileged = in_array($user->role, [UserRole::ADMIN, UserRole::CARETAKER]);
        }
        // Pengecekan fallback jika role masih dibaca sebagai raw string dari database
        else {
            $isPrivileged = in_array($user->role, [UserRole::ADMIN->value, UserRole::CARETAKER->value]);
        }

        // Tembakkan 403 jika bukan pemilik DAN bukan admin/caretaker
        abort_unless($isOwner || $isPrivileged, 403, 'Akses ditolak. Anda tidak memiliki izin.');

        // Tembakkan 404 jika file fisik benar-benar tidak ada di disk private
        abort_unless(Storage::disk('private')->exists($path), 404, 'File KTP tidak ditemukan.');

        $mimeType = Storage::disk('private')->mimeType($path);

        return response()->stream(function () use ($path) {
            echo Storage::disk('private')->get($path);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            'Cache-Control' => 'private, max-age=86400' // Tambahan cache agar load gambar lebih cepat
        ]);
    }
}
