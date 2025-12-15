<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kos Melati Indah - Hunian Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            /* Colors */
            --primary: #00a859;
            --primary-dark: #008f4c;
            --primary-light: #e0f2e9;
            --dark: #0f172a;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --white: #ffffff;
            --orange: #f59e0b;

            /* Shadows */
            --shadow-card: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-float: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);

            /* Spacing */
            --header-h: 70px;
            --radius: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* --- TYPOGRAPHY --- */
        h1,
        h2,
        h3 {
            line-height: 1.2;
            font-weight: 700;
            color: var(--dark);
        }

        p {
            color: var(--gray);
        }

        /* --- HEADER & NAV (RESPONSIVE) --- */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: var(--header-h);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .navbar {
            max-width: 1200px;
            margin: 0 auto;
            height: 100%;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo i {
            width: 36px;
            height: 36px;
            background: var(--primary);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .logo div {
            display: flex;
            flex-direction: column;
        }

        .logo h1 {
            font-size: 1.1rem;
            margin: 0;
        }

        .logo span {
            font-size: 0.7rem;
            color: var(--gray);
            font-weight: 500;
        }

        /* Desktop Nav */
        .nav-menu {
            display: flex;
            gap: 30px;
            align-items: center;
            list-style: none;
        }

        .nav-link {
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            font-size: 0.95rem;
            transition: 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary);
        }

        .nav-btns {
            display: flex;
            gap: 10px;
        }

        /* Mobile Hamburger */
        .hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
        }

        /* --- BUTTONS --- */
        .btn {
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(0, 168, 89, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 1px solid var(--gray);
            color: var(--dark);
            background: white;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* --- HERO SECTION --- */
        .hero {
            padding: 120px 20px 60px;
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .hero-text h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            margin-bottom: 20px;
        }

        .hero-text h1 span {
            color: var(--primary);
        }

        .hero-text p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            max-width: 500px;
        }

        .hero-img {
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-float);
            aspect-ratio: 4/3;
        }

        .hero-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .stats {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }

        .stat h3 {
            font-size: 1.8rem;
            color: var(--primary);
            margin: 0;
        }

        .stat p {
            font-size: 0.85rem;
            margin: 0;
        }

        /* --- SECTION GLOBAL --- */
        .section {
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .sec-header {
            text-align: center;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .sec-header h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        /* --- FILTERS (SCROLLABLE ON MOBILE) --- */
        .filters {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
            overflow-x: auto;
            padding-bottom: 10px;
            -ms-overflow-style: none;
            scrollbar-width: none;
            /* Hide scrollbar */
        }

        .filters::-webkit-scrollbar {
            display: none;
        }

        .filter-btn {
            padding: 8px 20px;
            border-radius: 100px;
            background: white;
            border: 1px solid #e2e8f0;
            color: var(--gray);
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            transition: 0.2s;
        }

        .filter-btn.active {
            background: var(--dark);
            color: white;
            border-color: var(--dark);
        }

        /* --- KAMAR CARDS (HORIZONTAL SCROLL SNAP) --- */
        .kamar-scroll-area {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 20px 10px 40px;
            scroll-snap-type: x mandatory;
            /* Kunci scroll horizontal */
            -webkit-overflow-scrolling: touch;
        }

        .kamar-scroll-area::-webkit-scrollbar {
            display: none;
        }

        .kamar-card {
            min-width: 320px;
            max-width: 320px;
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            position: relative;
            scroll-snap-align: center;
            /* Kartu akan berhenti pas di tengah layar HP */
            border: 1px solid #f1f5f9;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }

        .kamar-img-box {
            position: relative;
            height: 200px;
        }

        .kamar-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-badge.available {
            background: rgba(34, 197, 94, 0.9);
        }

        .status-badge.unavailable {
            background: rgba(239, 68, 68, 0.9);
        }

        .kamar-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .kamar-title {
            font-size: 1.2rem;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kamar-price {
            color: var(--primary);
            font-weight: 800;
            font-size: 1.1rem;
        }

        .kamar-desc {
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pricing Tab */
        .price-tabs {
            display: flex;
            background: var(--gray-light);
            padding: 4px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .tab-item {
            flex: 1;
            text-align: center;
            padding: 8px 4px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        .tab-item.active {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .tab-item span {
            display: block;
            line-height: 1.2;
        }

        .tab-dur {
            font-size: 0.7rem;
            color: var(--gray);
            font-weight: 600;
        }

        .tab-val {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--dark);
        }

        .tab-item.active .tab-val {
            color: var(--primary);
        }

        /* Card Actions */
        .card-footer {
            margin-top: auto;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
        }

        .btn-wa-icon {
            width: 44px;
            height: 44px;
            background: #dcfce7;
            color: #16a34a;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            border: none;
        }

        /* --- FACILITIES GRID --- */
        .fac-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
        }

        .fac-card {
            background: white;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid var(--gray-light);
            text-align: center;
        }

        .fac-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin: 0 auto 15px;
        }

        /* --- GALLERY SECTION (RESPONSIVE) --- */
        .gallery-grid {
            display: grid;
            /* Auto Fit: Jika layar kecil 1 kolom, layar besar menyesuaikan */
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .gallery-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            aspect-ratio: 4/3;
            cursor: pointer;
            group;
        }

        .gallery-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s ease;
        }

        .gallery-card:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
            opacity: 0;
            transition: 0.3s;
            transform: translateY(20px);
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile: Selalu tampil overlay text sedikit agar user tau itu apa */
        @media (max-width: 768px) {
            .gallery-overlay {
                opacity: 1;
                transform: translateY(0);
                padding: 15px;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            /* 2 kolom di HP */
        }

        /* --- TESTIMONIALS SECTION (RESPONSIVE) --- */
        .testi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testi-card {
            background: white;
            padding: 30px;
            border-radius: 24px;
            border: 1px solid var(--gray-light);
            position: relative;
        }

        .testi-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .testi-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }

        .testi-stars {
            color: var(--orange);
            font-size: 0.8rem;
        }

        .testi-text {
            font-style: italic;
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* --- LOCATION (STACKED ON MOBILE) --- */
        .loc-box {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-card);
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            margin-top: 20px;
        }

        .loc-info {
            padding: 40px;
            background: var(--dark);
            color: white;
        }

        .loc-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .loc-item i {
            width: 40px;
            color: var(--primary);
            font-size: 1.2rem;
            text-align: center;
        }

        .loc-item h4 {
            color: white;
            margin-bottom: 2px;
            font-size: 1rem;
        }

        .loc-item p {
            color: #94a3b8;
            font-size: 0.9rem;
            margin: 0;
        }

        #map {
            width: 100%;
            min-height: 350px;
        }

        /* --- FOOTER --- */
        footer {
            background: var(--dark);
            color: white;
            padding: 60px 20px 30px;
            margin-top: 80px;
        }

        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
        }

        .foot-col h4 {
            color: white;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .foot-col a {
            display: block;
            color: #94a3b8;
            text-decoration: none;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .foot-col a:hover {
            color: white;
        }

        .socials {
            display: flex;
            gap: 15px;
        }

        .socials a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* --- MODAL --- */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            padding: 20px;
            animation: fadeIn 0.3s;
        }

        .modal-content {
            max-width: 800px;
            width: 100%;
        }

        .modal-img {
            width: 100%;
            border-radius: 12px;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 2rem;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 992px) {
            .hero {
                grid-template-columns: 1fr;
                text-align: center;
                padding-top: 100px;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .hero-text p {
                margin-left: auto;
                margin-right: auto;
            }

            .stats {
                justify-content: center;
            }

            .hero-img {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
            }

            .loc-box {
                grid-template-columns: 1fr;
            }

            /* Map stack below info */
            .loc-info {
                padding: 30px 20px;
            }
        }

        @media (max-width: 768px) {

            /* Navbar Mobile */
            .hamburger {
                display: block;
            }

            .nav-menu {
                position: fixed;
                top: var(--header-h);
                left: 0;
                width: 100%;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                transform: translateY(-150%);
                opacity: 0;
                transition: 0.4s ease;
                align-items: flex-start;
                gap: 20px;
            }

            .nav-menu.active {
                transform: translateY(0);
                opacity: 1;
            }

            .nav-menu li {
                width: 100%;
                border-bottom: 1px solid #f1f5f9;
                padding-bottom: 10px;
            }

            .nav-btns {
                flex-direction: column;
                width: 100%;
                gap: 10px;
                margin-top: 10px;
            }

            .nav-btns .btn {
                width: 100%;
            }

            /* Grid Adjustments */
            .hero-text h1 {
                font-size: 2rem;
            }

            .fac-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .socials {
                justify-content: center;
            }

            .kamar-card {
                min-width: 85vw;
                max-width: 85vw;
            }

            /* Kartu lebih lebar di HP */
            .testi-grid {
                grid-template-columns: 1fr;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="navbar">
            <a href="#" class="logo">
                <i class="fas fa-home"></i>
                <div>
                    <h1>Kos Melati</h1>
                    <span>Indah & Nyaman</span>
                </div>
            </a>

            <button class="hamburger" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>

            <ul class="nav-menu">
                <li><a href="#home" class="nav-link active" onclick="toggleMenu()">Beranda</a></li>
                <li><a href="#kamar" class="nav-link" onclick="toggleMenu()">Kamar</a></li>
                <li><a href="#fasilitas" class="nav-link" onclick="toggleMenu()">Fasilitas</a></li>
                <li><a href="#lokasi" class="nav-link" onclick="toggleMenu()">Lokasi</a></li>
                <li><a href="#testimoni" class="nav-link" onclick="toggleMenu()">Testimoni</a></li>

                <div class="nav-btns">
                    @if (auth()->check())
                        <a href="{{ route('customer.profile') }}" class="btn btn-primary"><i class="fas fa-user"></i>
                            Akun</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    @endif
                </div>
            </ul>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-text">
            <h1>Hunian Nyaman, <br><span>Kuliah Tenang.</span></h1>
            <p>Hanya 5 menit dari IAIN Curup. Fasilitas lengkap, WiFi kencang, dan keamanan 24 jam untuk mahasiswa.</p>
            <div style="display: flex; gap: 10px; justify-content: inherit;">
                <a href="#kamar" class="btn btn-primary">Lihat Kamar</a>
                <a href="https://wa.me/6281234567890" class="btn btn-outline"><i class="fab fa-whatsapp"></i> Chat
                    Admin</a>
            </div>
            <div class="stats">
                <div class="stat">
                    <h3>5</h3>
                    <p>Menit Kampus</p>
                </div>
                <div class="stat">
                    <h3>{{ count($rooms) }}</h3>
                    <p>Kamar</p>
                </div>
                <div class="stat">
                    <h3>24/7</h3>
                    <p>CCTV</p>
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Kos">
        </div>
    </section>

    <section class="section" id="kamar">
        <div class="sec-header">
            <h2>Pilihan Kamar</h2>
            <p>Geser untuk melihat pilihan kamar terbaik kami.</p>
        </div>

        <div class="filters">
            <button class="filter-btn active" onclick="filterKamar('all')">Semua</button>
            <button class="filter-btn" onclick="filterKamar('available')">Tersedia</button>
            <button class="filter-btn" onclick="filterKamar('unavailable')">Penuh</button>
        </div>

        <div class="kamar-scroll-area" id="kamarContainer">
            @forelse($rooms as $item)
                <div class="kamar-card" data-status="{{ $item->status }}">
                    {{-- Bagian Gambar Tetap Sama --}}
                    <div class="kamar-img-box">
                        <div class="status-badge {{ $item->status }}">
                            @if ($item->status == 'available')
                                <i class="fas fa-check"></i> Tersedia
                            @else
                                <i class="fas fa-lock"></i> Penuh
                            @endif
                        </div>
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                            loading="lazy">
                    </div>

                    <div class="kamar-body">
                        <div class="kamar-title">
                            <h3>Kamar {{ $item->room_number }}</h3>
                            <span class="kamar-price">Rp 1.5jt</span>
                        </div>
                        <p class="kamar-desc">{{ $item->description }}</p>

                        {{-- LOGIKA PENGKONDISIAN --}}
                        @guest
                            {{-- KONDISI 1: BELUM LOGIN --}}
                            <div class="alert-box"
                                style="background: #f0f0f0; padding: 10px; border-radius: 8px; text-align: center; margin-top: 10px;">
                                <p style="font-size: 12px; margin-bottom: 5px; color: #666;">Silahkan login untuk memesan
                                </p>
                                <a href="{{ route('login') }}" class="btn btn-primary"
                                    style="width:100%; display:block; text-decoration:none; line-height: 30px;">Login
                                    Sekarang</a>
                            </div>
                        @else
                            {{-- Cek apakah user sudah booking kamar INI --}}
                            {{-- Asumsi relasi user ke bookings bernama 'bookings' --}}
                            @php
                                $alreadyBooked = Auth::user()
                                    ->bookings()
                                    ->where('room_id', $item->id)
                                    ->where('status', '!=', 'cancelled')
                                    ->first(); // Ambil satu hasil, jika ada.
                            @endphp

                            @if (Auth::user()->status == 'pending')
                                {{-- KONDISI 2: USER STATUS PENDING --}}
                                <div class="alert-box"
                                    style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; text-align: center; margin-top: 10px; border: 1px solid #ffeeba;">
                                    <i class="fas fa-clock"></i> Akun Menunggu Verifikasi
                                </div>
                            @elseif($alreadyBooked)
                                {{-- KONDISI 3: SUDAH BOOKING KAMAR INI --}}
                                <div class="alert-box"
                                    style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; text-align: center; margin-top: 10px; border: 1px solid #c3e6cb;">
                                    <i class="fas fa-check-circle"></i> Anda sudah booking kamar ini
                                </div>
                            @else
                                {{-- KONDISI 4: USER AKTIF & BELUM BOOKING (TAMPILKAN FORM) --}}
                                <form action="{{ route('checkout') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="room_id" value="{{ $item->id }}">

                                    <div class="price-tabs">
                                        <div class="tab-item active" onclick="selectPrice(this, '1.500.000')">
                                            <input type="radio" name="choose_month" value="3" checked
                                                style="display:none">
                                            <span class="tab-dur">3 Bln</span>
                                            <span class="tab-val">1.5 Jt</span>
                                        </div>
                                        <div class="tab-item" onclick="selectPrice(this, '3.000.000')">
                                            <input type="radio" name="choose_month" value="6"
                                                style="display:none">
                                            <span class="tab-dur">6 Bln</span>
                                            <span class="tab-val">3 Jt</span>
                                        </div>
                                        <div class="tab-item" onclick="selectPrice(this, '6.000.000')">
                                            <input type="radio" name="choose_month" value="12"
                                                style="display:none">
                                            <span class="tab-dur">1 Thn</span>
                                            <span class="tab-val">6 Jt</span>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        @if ($item->status == 'available')
                                            <button type="submit" class="btn btn-primary"
                                                style="width:100%">Pesan</button>
                                        @else
                                            <button type="button" class="btn btn-outline" disabled
                                                style="width:100%; opacity:0.6">Penuh</button>
                                        @endif
                                        <button type="button" class="btn-wa-icon"
                                            onclick="openWa('{{ $item->room_number }}')">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endguest
                        {{-- AKHIR LOGIKA --}}

                    </div>
                </div>
            @empty
                <div style="text-align:center; width:100%; padding:20px;">Belum ada data kamar.</div>
            @endforelse
        </div>
    </section>

    <section class="section" id="fasilitas">
        <div class="sec-header">
            <h2>Fasilitas</h2>
            <p>Semua yang kamu butuhkan ada di sini.</p>
        </div>
        <div class="fac-grid">
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-wifi"></i></div>
                <h4>WiFi Kencang</h4>
            </div>
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-shield-alt"></i></div>
                <h4>Keamanan 24/7</h4>
            </div>
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-bolt"></i></div>
                <h4>Free Listrik</h4>
            </div>
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-utensils"></i></div>
                <h4>Dapur Bersama</h4>
            </div>
        </div>
    </section>

    <section class="section" id="gallery">
        <div class="sec-header">
            <h2>Galeri</h2>
            <p>Suasana Kos Melati Indah.</p>
        </div>
        <div class="gallery-grid">
            @foreach ($galleries as $gallery)
                <div class="gallery-card" onclick="openModal('{{ url('storage/' . $gallery->image) }}')">
                    <img src="{{ url('storage/' . $gallery->image) }}" alt="{{ $gallery->name }}">
                    <div class="gallery-overlay">
                        <h4 style="margin:0; font-size:1rem">{{ $gallery->name }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section" id="testimoni" style="background:#fff;">
        <div class="sec-header">
            <h2>Kata Penghuni</h2>
            <p>Pengalaman mereka selama tinggal di sini.</p>
        </div>
        <div class="testi-grid">
            @foreach ($testimonials as $testi)
                <div class="testi-card">
                    <div class="testi-header">
                        <img src="{{ $testi->user->photo ? url('storage/' . $testi->user->photo) : 'https://ui-avatars.com/api/?name=' . $testi->user->name }}"
                            class="testi-avatar">
                        <div>
                            <h4 style="margin:0; font-size:1rem">{{ $testi->user->name }}</h4>
                            <div class="testi-stars">
                                @for ($i = 0; $i < $testi->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="testi-text">"{{ $testi->comment }}"</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section" id="lokasi">
        <div class="sec-header">
            <h2>Lokasi</h2>
        </div>
        <div class="loc-box">
            <div class="loc-info">
                <h3 style="margin-bottom:30px; color:white;">Lokasi Strategis</h3>
                <div class="loc-item">
                    <i class="fas fa-university"></i>
                    <div>
                        <h4>IAIN Curup</h4>
                        <p>5 Menit</p>
                    </div>
                </div>
                <div class="loc-item">
                    <i class="fas fa-shopping-cart"></i>
                    <div>
                        <h4>Pasar</h4>
                        <p>3 Menit Jalan Kaki</p>
                    </div>
                </div>
                <div class="loc-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h4>Alamat</h4>
                        <p>Jl. Merpati No. 45, Curup</p>
                    </div>
                </div>
            </div>
            <div id="map"></div>
        </div>
    </section>

    <footer>
        <div class="footer-grid">
            <div class="foot-col">
                <h4 style="color: var(--primary);">Kos Melati Indah</h4>
                <p style="color:#94a3b8; font-size:0.9rem;">Hunian nyaman untuk mahasiswa. Fokus belajar, istirahat
                    tenang.</p>
            </div>
            <div class="foot-col">
                <h4>Navigasi</h4>
                <a href="#home">Beranda</a>
                <a href="#kamar">Kamar</a>
                <a href="#lokasi">Lokasi</a>
            </div>
            <div class="foot-col">
                <h4>Kontak</h4>
                <a href="#">0812-3456-7890</a>
                <a href="#">admin@kos.com</a>
                <div class="socials" style="margin-top:10px;">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
        <div
            style="text-align:center; color:#64748b; font-size:0.8rem; margin-top:50px; border-top:1px solid #1e293b; padding-top:20px;">
            &copy; 2025 Kos Melati Indah. All rights reserved.
        </div>
    </footer>

    <div class="modal" id="imgModal" onclick="closeModal()">
        <button class="modal-close">&times;</button>
        <div class="modal-content" onclick="event.stopPropagation()">
            <img src="" class="modal-img" id="modalImage">
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Toggle Mobile Menu
        function toggleMenu() {
            const menu = document.querySelector('.nav-menu');
            const icon = document.querySelector('.hamburger i');
            menu.classList.toggle('active');

            if (menu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            const menu = document.querySelector('.nav-menu');
            const btn = document.querySelector('.hamburger');
            if (!menu.contains(e.target) && !btn.contains(e.target) && menu.classList.contains('active')) {
                toggleMenu();
            }
        });

        // Price Selection Logic
        function selectPrice(el, price) {
            // Visual Update
            const parent = el.parentElement;
            parent.querySelectorAll('.tab-item').forEach(item => item.classList.remove('active'));
            el.classList.add('active');

            // Radio Check
            el.querySelector('input').checked = true;

            // Update Price Text Display
            const card = el.closest('.kamar-card');
            const displayPrice = parseInt(price.replace(/\./g, '')) / 1000000 + " Jt";
            card.querySelector('.kamar-price').innerText = "Rp " + displayPrice;
        }

        // Filter Kamar
        function filterKamar(status) {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            const cards = document.querySelectorAll('.kamar-card');
            cards.forEach(card => {
                const s = card.getAttribute('data-status');
                if (status === 'all' || s === status) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // WhatsApp Link
        function openWa(room) {
            window.open(`https://wa.me/6281234567890?text=Halo Admin, mau tanya kamar nomor ${room}`, '_blank');
        }

        // Modal Logic
        function openModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imgModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('imgModal').style.display = 'none';
        }

        // Map
        const map = L.map('map').setView([-3.4730, 102.5200], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([-3.4730, 102.5200]).addTo(map).bindPopup('Kos Melati Indah');
    </script>
</body>

</html>
