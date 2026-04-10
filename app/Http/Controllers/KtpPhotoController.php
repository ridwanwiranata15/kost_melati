<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        // Security: ensure the authenticated user owns this KTP or is admin/owner
        $isOwner = $user->ktp_photo === $path;
        $isPrivileged = in_array($user->role, ['admin', 'owner']);

        abort_unless($isOwner || $isPrivileged, 403, 'Akses ditolak.');
        abort_unless(Storage::disk('private')->exists($path), 404, 'File tidak ditemukan.');

        $mimeType = Storage::disk('private')->mimeType($path);

        return response()->stream(function () use ($path) {
            echo Storage::disk('private')->get($path);
        }, 200, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
}
