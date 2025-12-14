<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $transaction->id }} - {{ $providerName }}</title>

    {{-- Menggunakan Tailwind CSS (Sesuaikan dengan setup project Anda, misal vite) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Font Google (Inter) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* CSS Khusus Print: Sembunyikan tombol saat dicetak */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; }
            .receipt-card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10 px-4">

    <div class="w-full max-w-md">

        {{-- KARTU STRUK / INVOICE --}}
        <div class="receipt-card bg-white rounded-3xl shadow-2xl overflow-hidden relative">

            {{-- Hiasan Lingkaran Atas (Kesan kertas sobek/punch hole) --}}
            <div class="absolute -left-3 top-24 w-6 h-6 bg-gray-100 rounded-full"></div>
            <div class="absolute -right-3 top-24 w-6 h-6 bg-gray-100 rounded-full"></div>

            {{-- HEADER --}}
            <div class="bg-slate-900 text-white p-8 text-center relative overflow-hidden">
                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-white/10 rounded-xl mb-4 text-emerald-400 backdrop-blur-sm">
                        <i class="fa-solid fa-check text-2xl"></i>
                    </div>
                    <h1 class="text-xl font-bold tracking-wide uppercase">Bukti Pembayaran</h1>
                    <p class="text-slate-400 text-sm mt-1">ID Transaksi: #TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>

                {{-- Pattern Background --}}
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <i class="fa-solid fa-building text-9xl absolute -right-4 -bottom-4 transform rotate-12"></i>
                </div>
            </div>

            {{-- BODY CONTENT --}}
            <div class="p-8 pt-10">

                {{-- Detail Utama --}}
                {{-- Detail Utama --}}
                <div class="space-y-4">
                    {{-- Penyedia --}}
                    <div class="flex justify-between items-start">
                        <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Penyedia</span>
                        <span class="text-gray-800 font-bold text-right">{{ $providerName }}</span>
                    </div>

                    {{-- Customer --}}
                    <div class="flex justify-between items-start">
                        <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Penyewa</span>
                        {{-- FIX: Gunakan tanda tanya (?) sebelum panah --}}
                        <span class="text-gray-800 font-semibold text-right">
                            {{ $transaction->booking?->user?->name}}
                        </span>
                    </div>

                    {{-- Garis Putus --}}
                    <div class="border-b border-dashed border-gray-200 my-4"></div>

                    {{-- Kamar --}}
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Tipe Kamar</span>
                        {{-- FIX: Null check untuk room --}}
                        <span class="text-gray-900 font-bold">
                            {{ $transaction->booking?->room?->name }}
                        </span>
                    </div>

                    {{-- Durasi --}}
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Durasi Sewa</span>
                        <span class="text-gray-900 font-medium">
                            {{ $transaction->booking?->duration }} Bulan
                        </span>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Mulai Kost</span>
                        <span class="text-gray-900 font-medium">
                            @if($transaction->booking && $transaction->booking->start_date)
                                {{ \Carbon\Carbon::parse($transaction->booking->start_date)->translatedFormat('d F Y') }}
                            @else
                                -
                            @endif
                        </span>
                    </div>

                    {{-- Metode Bayar (Ini aman karena ada di tabel transaction langsung) --}}
                     <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Metode Bayar</span>
                        <span class="capitalize px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-600">
                            {{ $transaction->payment_method}}
                        </span>
                    </div>
                </div>

                {{-- TOTAL SECTION --}}
                <div class="mt-8 bg-emerald-50 rounded-2xl p-6 border border-emerald-100 text-center">
                    <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider mb-1">Total Dibayarkan</p>
                    <h2 class="text-3xl font-black text-emerald-700">
                        Rp {{ number_format($transaction->nominal, 0, ',', '.') }}
                    </h2>
                    <p class="text-[10px] text-emerald-500 mt-2">
                        <i class="fa-solid fa-clock mr-1"></i> Dibayar pada: {{ \Carbon\Carbon::parse($transaction->date_pay)->translatedFormat('d M Y, H:i') }}
                    </p>
                </div>

                {{-- Footer Note --}}
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-400">Terima kasih telah mempercayai layanan kami.</p>
                    <p class="text-[10px] text-gray-300 mt-1">{{ $providerName }} System</p>
                </div>
            </div>
        </div>

        {{-- BUTTONS ACTION (Hilang saat Print) --}}
        <div class="no-print mt-6 flex flex-col gap-3">
            <button onclick="window.print()" class="w-full bg-slate-900 hover:bg-black text-white py-3 rounded-xl font-bold shadow-lg transform active:scale-95 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
            </button>

            <a href="{{ url()->previous() }}" class="w-full bg-white hover:bg-gray-50 text-gray-700 py-3 rounded-xl font-bold shadow border border-gray-200 text-center block transition-colors">
                Kembali
            </a>
        </div>

    </div>

</body>
</html>
