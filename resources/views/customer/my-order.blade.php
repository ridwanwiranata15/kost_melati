<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/60f3c978d3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tedjia | Detail Order</title>

    <style>
        /* =========================================
                BASE STYLE & SIDEBAR
           (Saya pertahankan logic Sidebar Anda)
        ========================================= */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F3F4F6;
            /* Abu-abu muda yang lebih soft */
            color: #1F2937;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 280px;
            background-color: #02051E;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-content {
            padding: 40px 30px;
        }

        .logo-container {
            margin-bottom: 40px;
        }

        .nav-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .nav-item .nav-link {
            display: block;
            padding: 12px 16px;
            border-radius: 12px;
            color: #9CA3AF;
            transition: 0.3s;
        }

        .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item.active .nav-link {
            background-color: #D4F247;
            color: #02051E;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(212, 242, 71, 0.3);
        }

        .nav-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* --- MAIN WRAPPER --- */
        .main-wrapper {
            flex-grow: 1;
            padding: 40px 50px;
            background-color: #F8F9FD;
            overflow-y: auto;
        }

        /* --- RESPONSIVE SIDEBAR --- */
        @media screen and (max-width: 768px) {
            .layout-wrapper {
                display: block;
            }

            .sidebar {
                position: fixed;
                bottom: 0;
                top: auto;
                left: 0;
                right: 0;
                width: 100%;
                height: auto;
                padding: 0;
                border-top-left-radius: 20px;
                border-top-right-radius: 20px;
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
                z-index: 50;
            }

            .logo-container {
                display: none;
            }

            .sidebar-content {
                padding: 15px 10px;
            }

            .nav-list {
                flex-direction: row;
                justify-content: space-around;
            }

            .nav-content {
                flex-direction: column;
                gap: 4px;
                align-items: center;
            }

            .nav-text {
                font-size: 10px;
            }

            .main-wrapper {
                padding: 20px 20px 100px 20px;
            }

            /* Hide Text on mobile active button specific fix */
            .nav-item.active .nav-link {
                padding: 8px 12px;
            }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">
        <aside class="sidebar">
            <div class="sidebar-content">
                <div class="logo-container">
                    <a href="/" class="text-2xl font-bold tracking-wider text-white">
                        TEDJIA<span style="color:#D4F247">.</span>
                    </a>
                </div>

                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('customer.profile') }}" class="nav-link">
                            <div class="nav-content">
                                <i class="fa-regular fa-user text-lg"></i>
                                <p class="nav-text">Profile</p>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item active">
                        <a href="{{ route('customer.order') }}" class="nav-link">
                            <div class="nav-content">
                                <i class="fa-solid fa-basket-shopping text-lg"></i>
                                <p class="nav-text">My Order</p>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="#">
                            <button type="submit" class="nav-link w-full text-left">
                                <div class="nav-content">
                                    <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                                    <p class="nav-text">Log out</p>
                                </div>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="main-wrapper">
            <main class="content-area max-w-5xl mx-auto">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Detail Order</h1>
                        <p class="text-gray-500 text-sm mt-1">Kelola status pembayaran kost Anda</p>
                    </div>
                    <div class="hidden md:block">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Active Tenant
                        </span>
                    </div>
                </div>

                <section
                    class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8 hover:shadow-md transition-shadow duration-300">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-1/3 shrink-0">
                            <div class="relative h-48 md:h-full w-full overflow-hidden rounded-2xl group">
                                <img src="{{ url('storage/' . $booking->room->image) }}"
                                    alt="Kost Image"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                            </div>
                        </div>

                        <div class="">
                            <div>
                                <div class="items-start mb-2">
                                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">{{ $booking->room->name }}
                                    </h2>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-emerald-600">Rp {{ $booking->total_amount }} / {{ $booking->duration }}
                                            bulan
                                        </p>
                                    </div>
                                </div>
                                <hr class="border-gray-100 mb-4">


                            </div>
                        </div>
                    </div>
                </section>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-800">Riwayat Pembayaran</h3>
                        <span class="text-xs text-gray-400">Tahun 2025</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-semibold">Bulan</th>
                                    <th class="px-6 py-4 font-semibold">Jatuh Tempo</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 font-semibold">Tanggal Bayar</th>
                                    <th class="px-6 py-4 font-semibold">Bukti pembayaran</th>
                                    <th class="px-6 py-4 font-semibold text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $item)
                                    {{-- LOGIC HITUNG BULAN --}}
                                    @php
                                        // 1. Ambil tanggal mulai dari booking (jika ada kolom start_date)
                                        // Jika tidak ada, pakai created_at milik booking
                                        $tanggalMulai = \Carbon\Carbon::parse(
                                            $booking->start_date ?? $booking->created_at,
                                        );
                                        $bulanTagihan = $tanggalMulai->copy()->addMonths($loop->index);
                                    @endphp

                                    <tr class="hover:bg-gray-50 transition">

                                        <td class="px-6 py-4 font-medium text-gray-900 capitalize">
                                            {{-- Menampilkan Nama Bulan & Tahun (Cth: Desember 2024) --}}
                                            {{ $bulanTagihan->translatedFormat('F Y') }}
                                        </td>

                                        <td class="px-6 py-4 text-gray-500">
                                            {{-- Set tanggal ke tgl 10 di bulan tersebut --}}
                                            {{ $bulanTagihan->copy()->day(10)->translatedFormat('d F Y') }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($item->status == 'pending')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                    <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                                    Belum Bayar
                                                </span>
                                            @elseif($item->status == 'confirmed')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                                    Lunas
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $item->date_pay ? \Carbon\Carbon::parse($item->date_pay)->translatedFormat('d F Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($item->payment_receipt)
                                                <img src="{{ url('storage/' . $item->payment_receipt) }}" alt="" width="100px" height="100px">
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                    <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                                    Belum ada pembayaran
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($item->status == 'pending')
                                                {{-- Tombol Bayar --}}
                                                <a href="{{ route('booking.upload', $item->id) }}">
                                                <button
                                                    class="bg-gray-900 hover:bg-black text-white px-3 py-1.5 rounded-lg text-xs font-medium transition shadow-lg">
                                                    Bayar Sekarang
                                                </button>
                                                </a>
                                            @else
                                                {{-- Tombol Invoice --}}
                                                <button
                                                    class="text-blue-600 border border-blue-200 px-3 py-1 rounded text-xs">
                                                    Invoice
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-500">
                                            Belum ada data tagihan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>

</html>
