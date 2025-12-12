<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],

            'password' => $this->passwordRules(),

            'phone' => ['nullable', 'string', 'max:20'],

            // VALIDASI FILE PHOTO
            'photo' => ['nullable', 'image', 'max:2048'], // max 2MB
        ])->validate();

        // SIMPAN PHOTO KE STORAGE (JIKA ADA)
        $photoPath = null;
        if (isset($input['photo'])) {
            $photoPath = $input['photo']->store('profile', 'public');
        }

        return User::create([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => Hash::make($input['password']),
            'phone'    => $input['phone'] ?? null,
            'photo'    => $photoPath, // simpan path file
        ]);
    }
}
