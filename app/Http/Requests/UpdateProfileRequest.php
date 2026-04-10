<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['string', 'max:255'],
            'email'         => ['string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'phone'         => ['nullable', 'string', 'max:20'],
            'photo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            // New fields
            'university'    => ['nullable', 'string', 'max:255'],
            'parents_name'  => ['nullable', 'string', 'max:255'],
            'parents_phone' => ['nullable', 'string', 'max:20'],
            'ktp_photo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ];
    }
}
