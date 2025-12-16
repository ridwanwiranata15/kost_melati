<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest; // Panggil Request yang tadi dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking; // Pastikan model Booking dipanggil

class ProfileController extends Controller
{
    // Menampilkan Halaman Profil
    public function index()
{
    // 1. Ambil User yang sedang login
    $user = auth()->user();

    // 2. AMBIL DATA BOOKING (Ini yang sering ketinggalan!)
    // Cari booking milik user ini, urutkan dari yang terbaru, ambil satu saja.
    $booking = \App\Models\Booking::with('room') // Load relasi kamar biar gak error
                ->where('user_id', $user->id)
                ->latest() // Ambil yang paling baru
                ->first(); // Gunakan first() agar hasilnya Obyek, bukan Array


    // 4. KIRIM KE VIEW (Compact)
    // Pastikan 'booking' ada di dalam kurung compact
    return view('customer.profile', compact('user', 'booking'));
}

    // Proses Update Data Diri (Nama, Email, Foto, HP)
    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated(); // Ambil data yang sudah lolos validasi

        // Cek jika ada upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika bukan avatar default/ui-avatars
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }

            // Simpan foto baru ke folder 'profile-photos' di storage public
            $path = $request->file('photo')->store('profile-photos', 'public');
            $data['photo'] = $path;
        }

        // Update data user ke database
        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Proses Update Password
    public function updatePassword(Request $request)
    {
        // Validasi password


        // Update password
        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
