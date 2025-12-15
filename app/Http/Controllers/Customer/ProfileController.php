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
        $user = auth()->user();

        // Ambil booking aktif user (untuk ditampilkan di card info hunian)
        $booking = Booking::with('room')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->first();

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
