<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name'           => ['required', 'string', 'max:255'],
            'email'          => [
                'required', 'string', 'email', 'max:255',
                Rule::unique(User::class),
            ],
            'password'       => $this->passwordRules(),
            'phone'          => ['nullable', 'string', 'max:20'],

            // Step 2 fields
            'university'     => ['nullable', 'string', 'max:255'],
            'parents_name'   => ['nullable', 'string', 'max:255'],
            'parents_phone'  => ['nullable', 'string', 'max:20'],

            // KTP Photo – stored on private disk
            'ktp_photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'], // max 4MB

            // Profile photo (public)
            'photo'          => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ])->validate();

        // Store profile photo (public disk)
        $photoPath = null;
        if (isset($input['photo']) && $input['photo'] instanceof \Illuminate\Http\UploadedFile) {
            $photoPath = $input['photo']->store('profile', 'public');
        }

        // Store KTP photo (PRIVATE disk – not accessible via public URL)
        $ktpPath = null;
        if (isset($input['ktp_photo']) && $input['ktp_photo'] instanceof \Illuminate\Http\UploadedFile) {
            $ktpPath = $input['ktp_photo']->store('ktp_photos', 'private');
        }

        return User::create([
            'name'          => $input['name'],
            'email'         => $input['email'],
            'password'      => Hash::make($input['password']),
            'phone'         => $input['phone']    ?? null,
            'photo'         => $photoPath,
            'ktp_photo'     => $ktpPath,
            'university'    => $input['university']    ?? null,
            'parents_name'  => $input['parents_name']  ?? null,
            'parents_phone' => $input['parents_phone'] ?? null,
        ]);
    }
}
