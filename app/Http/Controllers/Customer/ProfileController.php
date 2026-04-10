<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;

class ProfileController extends Controller
{
    // Show profile page
    public function index()
    {
        $user    = auth()->user();
        $booking = Booking::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        return view('customer.profile', compact('user', 'booking'));
    }

    // Process profile update (name, email, phone, photo, new fields)
    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        // Handle profile photo (public disk)
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('profile-photos', 'public');
        } else {
            unset($data['photo']); // Don't overwrite with null if no new upload
        }

        // Handle KTP photo (PRIVATE disk)
        if ($request->hasFile('ktp_photo')) {
            // Delete old KTP from private disk if it exists
            if ($user->ktp_photo && Storage::disk('private')->exists($user->ktp_photo)) {
                Storage::disk('private')->delete($user->ktp_photo);
            }
            $data['ktp_photo'] = $request->file('ktp_photo')->store('ktp_photos', 'private');
        } else {
            unset($data['ktp_photo']); // Don't overwrite with null if no new upload
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Process password update
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => ['required', 'current_password'],
            'password'              => ['required', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
