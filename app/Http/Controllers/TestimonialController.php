<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index(){
        return view('customer.testimonials');
    }
    public function store(Request $request)
    {
        // 1. Validasi Input


        // 2. Simpan ke Database
        Testimonial::create([

            'rating' => $request->rating,           // Masukkan data rating
            'comment' => $request->testimonial,     // Masukkan isi ulasan
            'user_id' => auth()->id(),               // Aktifkan jika user wajib login
        ]);

        // 3. Redirect kembali
        return redirect()->route('home')->with('success', 'Terima kasih! Ulasan dan rating Anda berhasil dikirim.');
    }
}
