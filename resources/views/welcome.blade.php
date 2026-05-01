<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.seo', [
        'seoTitle' => 'Kos Terdekat IAIN Curup | Kos El Sholeha Indah Curup',
        'seoDescription' =>
            'Kos terdekat IAIN Curup hanya sekitar 5 menit dari kampus. Fasilitas lengkap, WiFi, CCTV 24 jam, harga mulai Rp 500.000 per bulan, dan paket 1 tahun Rp 5.000.000.',
        'canonicalUrl' => request()->is('kos-terdekat-iain-curup')
            ? \App\Support\SeoMeta::canonicalUrl('/kos-terdekat-iain-curup')
            : \App\Support\SeoMeta::canonicalUrl('/'),
    ])


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    @php
        // Ambil data admin (bisa pakai find(1) atau cari berdasarkan role)
        $admin = \App\Models\User::where('role', 'admin')->first();

        // Sesuaikan 'phone' dengan nama kolom nomor HP di tabel users Anda (misal: 'no_hp' atau 'phone')
        $adminPhone = $admin->phone ?? '6281234567890';

        // Bersihkan karakter selain angka (opsional tapi disarankan)
        $adminPhone = preg_replace('/[^0-9]/', '', $adminPhone);

        // Ubah awalan '0' menjadi '62' agar valid untuk link WhatsApp
        if (str_starts_with($adminPhone, '0')) {
            $adminPhone = '62' . substr($adminPhone, 1);
        }
    @endphp
    <header>
        <div class="navbar">
            <a href="#" class="logo" style="text-decoration: none; color: inherit;">
                <i class="fas fa-home"></i>
                <div>
                    <strong class="logo-title">Kos El Sholeha</strong>
                    <span>Indah & Nyaman</span>
                </div>
            </a>

            <button class="hamburger" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>

            <ul class="nav-menu">
                <li><a href="#home" class="nav-link active" onclick="toggleMenu()">Beranda</a></li>
                <li><a href="#kamar" class="nav-link" onclick="toggleMenu()">Kamar</a></li>
                <li><a href="#fasilitas" class="nav-link" onclick="toggleMenu()">Fasilitas</a></li>
                <li><a href="#testimoni" class="nav-link" onclick="toggleMenu()">Testimoni</a></li>
                <li><a href="#lokasi" class="nav-link" onclick="toggleMenu()">Lokasi</a></li>

                <div class="nav-btns">
                    @auth
                        @if (auth()->user()->isAdmin() || auth()->user()->isCaretaker())
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-layout"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('customer.profile') }}" class="btn btn-primary">
                                <i class="fas fa-user"></i>
                                Profil
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    @endauth
                </div>
            </ul>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-text">
            <h1>Kos Terdekat IAIN Curup, <br><span>Kuliah Tenang.</span></h1>
            <p>Hanya 5 menit dari IAIN Curup. Fasilitas lengkap, WiFi kencang, dan keamanan 24 jam untuk mahasiswa.</p>
            <div style="display: flex; gap: 10px; justify-content: inherit;">
                <a href="#kamar" class="btn btn-primary">Lihat Kamar</a>
                <a href="https://wa.me/{{ $adminPhone }}" class="btn btn-outline"><i class="fab fa-whatsapp"></i> Chat
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
            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                alt="Kost El Sholeha">
        </div>
    </section>

    <section class="section" id="kamar" style="padding-top: 60px; padding-bottom: 20px;">
        <div class="sec-header">
            <h2>Pilihan Kamar</h2>
            <p>Temukan kamar terbaik di lokasi pilihan Anda. Geser untuk melihat semua pilihan.</p>
        </div>

        {{-- Filter Status + Lokasi --}}
        <div style="display: flex; flex-direction: column; align-items: center; gap: 10px; margin-bottom: 28px;">

            {{-- Filter Status --}}
            {{-- Filter Status --}}
            <div class="filter-group">
                {{-- Hapus class 'active' dari tombol Semua --}}
                <button class="filter-btn" onclick="filterKamar('all', this)">Semua</button>
                <button class="filter-btn active" onclick="filterKamar('available', this)"><i
                        class="fas fa-check-circle" style="color:#22c55e; font-size:0.75rem"></i> Tersedia</button>
                <button class="filter-btn" onclick="filterKamar('unavailable', this)"><i class="fas fa-lock"
                        style="color:#ef4444; font-size:0.75rem"></i> Penuh</button>
                <button class="filter-btn" onclick="filterKamar('repair', this)"><i class="fas fa-tools"
                        style="color:#f59e0b; font-size:0.75rem"></i> Perbaikan</button>
            </div>

            {{-- Filter Lokasi / Properti --}}
            @php
                $uniqueLocations = $rooms->map(fn($r) => $r->property)->filter()->unique('id');
            @endphp
            @if ($uniqueLocations->count() > 1)
                <div class="filter-group" id="locationFilters">
                    <button class="filter-btn active" onclick="filterLocation('all', this)"><i class="fas fa-globe-asia"
                            style="font-size:0.75rem"></i> Semua Lokasi</button>
                    @foreach ($uniqueLocations as $loc)
                        <button class="filter-btn" onclick="filterLocation('{{ $loc->slug }}', this)">
                            <i class="fas fa-map-marker-alt" style="font-size:0.75rem"></i> {{ $loc->name }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="kamar-scroll-area" id="kamarContainer" style="gap: 20px; padding: 16px 16px 40px;">
            @forelse($rooms as $item)
                @php
                    $property = $item->property;
                    $facilityChips = $item->facility ? collect(explode(',', $item->facility))->take(3) : collect([]);
                @endphp
                <div class="kamar-card-v2" data-status="{{ $item->status }}"
                    data-property-slug="{{ $property?->slug ?? 'tanpa-lokasi' }}">

                    {{-- Image --}}
                    <div class="kc-img">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=600&q=80' }}"
                            alt="Kamar {{ $item->room_number }}" loading="lazy">
                        <div class="kc-img-overlay"></div>

                        {{-- Top badges --}}
                        <div class="kc-badges">
                            <span class="kc-status {{ $item->status }}">
                                @if ($item->status == 'available')
                                    <i class="fas fa-check"></i> Tersedia
                                @elseif($item->status == 'repair')
                                    <i class="fas fa-tools"></i> Perbaikan
                                @else
                                    <i class="fas fa-lock"></i> Penuh
                                @endif
                            </span>
                            @if ($property)
                                <span class="kc-location-badge">
                                    <i class="fas fa-map-marker-alt"
                                        style="color: var(--primary); font-size: 0.6rem;"></i>
                                    {{ $property->location ?? $property->name }}
                                </span>
                            @endif
                        </div>

                        {{-- Bottom property label --}}
                        @if ($property)
                            <div class="kc-property-label">
                                <small>Properti</small>
                                <strong>{{ $property->name }}</strong>
                            </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="kc-body">
                        <div class="kc-header">
                            <div>
                                <p class="kc-room-name">{{ $item->name ?: 'Kamar Kost' }}</p>
                                <p class="kc-room-number">No. {{ $item->room_number }}</p>
                            </div>
                            <div class="kc-price-tag">
                                <span class="price-amount">500Rb</span>
                                <span class="price-unit">/bulan</span>
                            </div>
                        </div>

                        @if ($item->description)
                            <p class="kc-desc">{{ $item->description }}</p>
                        @endif

                        @if ($facilityChips->count())
                            <div class="kc-facilities">
                                @foreach ($facilityChips as $fac)
                                    <span class="kc-fac-chip"><i class="fas fa-check"
                                            style="color:var(--primary);font-size:0.6rem"></i>
                                        {{ trim($fac) }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Status khusus: Perbaikan --}}
                        @if ($item->status == 'repair')
                            <div class="kc-alert"
                                style="background:#fef3c7; color:#92400e; border:1px solid #fde68a; margin-bottom:0;">
                                <i class="fas fa-tools"></i> Kamar sedang dalam perbaikan
                            </div>
                        @elseif($item->status == 'unavailable')
                            <div class="kc-alert"
                                style="background:#fee2e2; color:#991b1b; border:1px solid #fecaca; margin-bottom:0;">
                                <i class="fas fa-lock"></i> Kamar sudah terisi penuh
                            </div>
                        @else
                            {{-- Price Tabs (hanya tampil jika tersedia) --}}
                            @guest
                                {{-- Guest: hanya tampilkan durasi tanpa form --}}
                                <div class="kc-price-tabs">
                                    <button type="button" class="kc-tab active" onclick="kcSelectTab(this)">
                                        <span class="t-dur">3 Bln</span>
                                        <span class="t-val">1.5 Jt</span>
                                    </button>
                                    <button type="button" class="kc-tab" onclick="kcSelectTab(this)">
                                        <span class="t-dur">6 Bln</span>
                                        <span class="t-val">3 Jt</span>
                                    </button>
                                    <button type="button" class="kc-tab" onclick="kcSelectTab(this)">
                                        <span class="t-dur">1 Thn</span>
                                        <span
                                            class="t-val">{{ \App\Support\BookingPrice::formatCompactRupiah(\App\Support\BookingPrice::totalAmountForDuration(12)) }}</span>
                                    </button>
                                </div>
                            @else
                                @php
                                    // 1. CEK ROLE USER
                                    $userRole = Auth::user()?->role?->value ?? 'member';
                                    $isStaff = in_array($userRole, ['admin', 'caretaker'], true);

                                    $hasActiveBooking = false;

                                    // 2. CEK BOOKING AKTIF (Hanya dijalankan jika dia BUKAN staff)
                                    if (!$isStaff) {
                                        $cekBookings = Auth::user()
                                            ->bookings()
                                            ->whereNotIn('status', ['cancelled', 'canceled', 'checkout', 'rejected'])
                                            ->get();

                                        foreach ($cekBookings as $b) {
                                            $statusBook = $b->status?->value;

                                            // Cek Pending (Expire 24 Jam)
                                            if ($statusBook === 'pending') {
                                                $tglBooking = \Carbon\Carbon::parse($b->created_at);
                                                if (\Carbon\Carbon::now()->diffInHours($tglBooking) < 24) {
                                                    $hasActiveBooking = true;
                                                    break;
                                                }
                                            }

                                            // Cek Confirmed/Checkin (Batas Waktu Sewa)
                                            if (in_array($statusBook, ['confirmed', 'checkin'], true)) {
                                                $tglMasuk = \Carbon\Carbon::parse($b->date_in)->startOfDay();
                                                $durasiBooking = (int) $b->duration;
                                                $tglKeluar = $tglMasuk->copy()->addMonths($durasiBooking)->startOfDay();
                                                $hariIni = \Carbon\Carbon::now('Asia/Jakarta')->startOfDay();

                                                if ($hariIni->lte($tglKeluar)) {
                                                    $hasActiveBooking = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                @endphp

                                {{-- LOGIKA TAMPILAN BERDASARKAN HASIL CEK DI ATAS --}}
                                @if ($isStaff)
                                    {{-- Jika user adalah Admin atau Penjaga Kos --}}
                                    <div class="kc-alert"
                                        style="background-color: #f3f4f6; color: #4b5563; border-color: #e5e7eb;">
                                        <i class="fa-solid fa-user-shield"></i>
                                        <span>Akun Staff tidak dapat memesan kamar.</span>
                                    </div>
                                @elseif($hasActiveBooking)
                                    {{-- Jika member punya kamar aktif --}}
                                    <div class="kc-alert kc-alert-info">
                                        <i class="fa-solid fa-bed"></i>
                                        <span>Anda sudah memiliki sewa aktif.</span>
                                        <a href="{{ route('customer.order') }}">Lihat Detail Sewa</a>
                                    </div>
                                @elseif(Auth::user()?->status?->value === 'pending')
                                    {{-- Jika akun member masih diverifikasi --}}
                                    <div class="kc-alert kc-alert-warning">
                                        <i class="fa-solid fa-user-clock"></i>
                                        <span>Akun sedang diverifikasi Admin.</span>
                                    </div>
                                @else
                                    {{-- Jika member lolos semua syarat, tampilkan Form Harga --}}
                                    <form id="form-room-{{ $item->id }}" action="{{ route('checkout') }}"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="room_id" value="{{ $item->id }}">
                                        <div class="kc-price-tabs">
                                            <button type="button" class="kc-tab active"
                                                onclick="kcSelectTab(this, 'form-room-{{ $item->id }}', 3)">
                                                <span class="t-dur">3 Bln</span>
                                                <span class="t-val">1.5 Jt</span>
                                            </button>
                                            <button type="button" class="kc-tab"
                                                onclick="kcSelectTab(this, 'form-room-{{ $item->id }}', 6)">
                                                <span class="t-dur">6 Bln</span>
                                                <span class="t-val">3 Jt</span>
                                            </button>
                                            <button type="button" class="kc-tab"
                                                onclick="kcSelectTab(this, 'form-room-{{ $item->id }}', 12)">
                                                <span class="t-dur">1 Thn</span>
                                                <span
                                                    class="t-val">{{ \App\Support\BookingPrice::formatCompactRupiah(\App\Support\BookingPrice::totalAmountForDuration(12)) }}</span>
                                            </button>
                                        </div>
                                        <input type="hidden" name="choose_month" id="month-{{ $item->id }}"
                                            value="3">
                                    </form>
                                @endif
                            @endguest
                        @endif
                    </div>

                    {{-- Footer / Actions --}}
                    <div class="kc-footer">
                        @if ($item->status == 'repair')
                            <button class="kc-btn-book repair" style="flex:1" disabled>
                                <i class="fas fa-tools"></i> Dalam Perbaikan
                            </button>
                        @elseif($item->status == 'unavailable')
                            <button class="kc-btn-book full" style="flex:1" disabled>
                                <i class="fas fa-lock"></i> Tidak Tersedia
                            </button>
                        @else
                            @guest
                                <a href="{{ route('login') }}" class="kc-btn-book guest" style="text-decoration:none">
                                    <i class="fas fa-calendar-check"></i> Pesan Sekarang
                                </a>
                            @else
                                @if (Auth::user()?->status?->value === 'pending')
                                    <div class="kc-alert pending" style="flex:1; margin:0; justify-content: center;">
                                        <i class="fas fa-clock"></i> Akun belum diverifikasi
                                    </div>
                                @elseif($alreadyBooked ?? false)
                                    <div class="kc-alert booked" style="flex:1; margin:0; justify-content: center;">
                                        <i class="fas fa-check-circle"></i> Sudah Dipesan
                                    </div>
                                @else
                                    <button type="submit" form="form-room-{{ $item->id }}"
                                        class="kc-btn-book available">
                                        <i class="fas fa-calendar-check"></i> Pesan
                                    </button>
                                @endif
                            @endguest
                        @endif

                        <a href="https://wa.me/{{ $adminPhone }}?text=Halo,%20saya%20tertarik%20dengan%20Kamar%20{{ $item->room_number }}"
                            target="_blank" class="kc-btn-wa">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div style="text-align:center; width:100%; padding: 40px 20px;">
                    <i class="fas fa-door-open"
                        style="font-size: 3rem; color: #cbd5e1; display:block; margin-bottom: 16px;"></i>
                    <p style="color: var(--gray); font-weight: 600;">Belum ada kamar tersedia.</p>
                </div>
            @endforelse
        </div>

        {{-- Empty state saat filter --}}
        <div id="emptyFilter" style="display:none; text-align:center; padding: 40px 20px;">
            <i class="fas fa-search"
                style="font-size: 2.5rem; color: #cbd5e1; display:block; margin-bottom: 12px;"></i>
            <p style="color: var(--gray); font-weight: 600;">Tidak ada kamar yang cocok dengan filter ini.</p>
            <button onclick="filterKamar('all', document.querySelector('.filter-btn'))"
                style="margin-top:12px; background:var(--primary); color:white; border:none; padding: 8px 20px; border-radius: 20px; cursor:pointer; font-weight:600;">Reset
                Filter</button>
        </div>
    </section>

    <section class="section" id="fasilitas">
        <div class="sec-header">
            <h2>Fasilitas</h2>
            <p>Semua yang kamu butuhkan ada di sini.</p>
        </div>
        <div class="fac-grid">
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-kitchen-set"></i></div>
                <h4>Dapur Pribadi Perkamar</h4>
                <p class="fac-desc">Fasilitas memasak lengkap di setiap kamar untuk kebebasan berekspresi kuliner</p>
            </div>
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-shower"></i></div>
                <h4>Kamar Mandi Eksklusif</h4>
                <p class="fac-desc">Kenyamanan maksimal dengan kamar mandi pribadi dalam setiap unit</p>
            </div>
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-camera"></i></div>
                <h4>Sistem Keamanan CCTV 24 Jam</h4>
                <p class="fac-desc">Pengawasan terpadu untuk menjamin keamanan dan ketenangan penghuni</p>
            </div>
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-wifi"></i></div>
                <h4>Internet High-Speed</h4>
                <p class="fac-desc">Koneksi WiFi super cepat untuk kerja, belajar, dan hiburan tanpa buffering</p>
            </div>
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-parking"></i></div>
                <h4>Area Parkir Terlindung</h4>
                <p class="fac-desc">Parkiran aman indoor & outdoor dengan sistem pengawasan khusus</p>
            </div>
            <div class="fac-card">
                <div class="fac-icon"><i class="fas fa-bed"></i></div>
                <h4>Furnitur Premium</h4>
                <p class="fac-desc">Ranjang dan perlengkapan tidur berkualitas tinggi dengan kenyamanan terjamin</p>
            </div>
        </div>
    </section>

    <section class="section" id="gallery">
        <div class="sec-header">
            <h2>Galeri</h2>
            <p>Suasana Kost El Sholeha.</p>
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


    <section class="section faq-section" id="faq-kos-iain-curup">
        <div class="sec-header">
            <span class="section-eyebrow">FAQ Kos Dekat Kampus</span>
            <h2>Kos Terdekat IAIN Curup untuk Mahasiswa</h2>
            <p>
                Kos El Sholeha Indah menjadi pilihan hunian strategis bagi mahasiswa yang mencari kos dekat IAIN Curup,
                kos nyaman di Curup Utara, dan tempat tinggal dengan fasilitas lengkap untuk menunjang aktivitas kuliah.
            </p>
        </div>

        <div class="faq-grid">
            <article class="faq-card">
                <div class="faq-icon">
                    <i class="fas fa-location-dot"></i>
                </div>
                <h3>Apakah kos ini dekat dengan IAIN Curup?</h3>
                <p>
                    Ya. Kos El Sholeha berada di area strategis Curup dan dekat dengan IAIN Curup,
                    sehingga cocok untuk mahasiswa yang ingin menghemat waktu perjalanan ke kampus.
                </p>
            </article>

            <article class="faq-card">
                <div class="faq-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3>Berapa harga kos per bulan?</h3>
                <p>
                    Harga kos mulai dari
                    {{ \App\Support\BookingPrice::formatRupiah(\App\Support\BookingPrice::monthlyPrice()) }}
                    per bulan. Tersedia juga paket sewa tahunan
                    {{ \App\Support\BookingPrice::formatRupiah(\App\Support\BookingPrice::totalAmountForDuration(12)) }}.
                </p>
            </article>

            <article class="faq-card">
                <div class="faq-icon">
                    <i class="fas fa-house-chimney"></i>
                </div>
                <h3>Fasilitas apa saja yang tersedia?</h3>
                <p>
                    Fasilitas meliputi WiFi, CCTV 24 jam, kamar mandi pribadi, dapur pribadi per kamar,
                    area parkir, dan lingkungan yang mendukung kenyamanan mahasiswa.
                </p>
            </article>
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
                        <p>5 Menit jalan kaki</p>
                    </div>
                </div>
                <div class="loc-item">
                    <i class="fas fa-shopping-cart"></i>
                    <div>
                        <h4>Pasar</h4>
                        <p>5 Menit naik motor</p>
                    </div>
                </div>
                <div class="loc-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h4>Alamat</h4>
                        <p>Jalan Hegel Blok A No.03, Dusun Curup, Kec. Curup Utara, Kabupaten Rejang Lebong, Bengkulu
                            39119, Indonesia</p>
                        <a class="maps-link" href="https://maps.app.goo.gl/PK14jifsM6aMJ4Mc7" target="_blank"
                            rel="noopener">
                            <i class="fas fa-map-location-dot"></i> Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
            <div id="map"></div>
        </div>
    </section>
    <footer>
        <div class="footer-grid">
            <div class="foot-col">
                <h4 style="color: var(--primary);">Kost El Sholeha</h4>
                <p style="color:#94a3b8; font-size:0.9rem;">Hunian nyaman untuk mahasiswa. Fokus belajar, istirahat
                    tenang.</p>
            </div>
            <div class="foot-col">
                <h4>Navigasi</h4>
                <a href="#home">Beranda</a>
                <a href="#kamar">Kamar</a>
                <a href="#lokasi">Lokasi</a>
                <a href="{{ route('seo.kos-terdekat-iain-curup') }}">Kos Terdekat IAIN Curup</a>
            </div>
            <div class="foot-col">
                <h4>Kontak</h4>
                <a href="#">085273599597</a>
                <a href="#">085267399374</a>
                <a href="#">082176253810</a>
            </div>
        </div>
        <div
            style="text-align:center; color:#64748b; font-size:0.8rem; margin-top:50px; border-top:1px solid #1e293b; padding-top:20px;">
            &copy; 2025 Kost El Sholeha. All rights reserved.
        </div>
    </footer>

    <div class="modal" id="imgModal" onclick="closeModal()">
        <button class="modal-close">&times;</button>
        <div class="modal-content" onclick="event.stopPropagation()">
            <img src="" class="modal-img" id="modalImage">
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('alert'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const alert = @json(session('alert'));

                Swal.fire({
                    icon: alert.type,
                    title: alert.title,
                    html: `<p>${alert.message}</p>`,
                    showCancelButton: true,
                    confirmButtonText: alert.confirmText ?? 'OK',
                    confirmButtonColor: '#00a859',
                    footer: `
                <a href="https://wa.me/{{ session('admin_phone') }}" target="_blank"
                   style="color:#25D366;font-weight:600;text-decoration:none;">
                    💬 Hubungi Admin
                </a>
            `
                }).then((result) => {
                    if (result.isConfirmed && alert.redirect) {
                        window.location.href = alert.redirect;
                    }
                });
            });
        </script>
    @endif
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

        // =============================================
        // Room Cards v2 — JavaScript
        // =============================================

        let activeStatus = 'available';
        let activeLocation = 'all';

        // Tambahkan event listener ini agar filter langsung berjalan saat web pertama kali dibuka
        document.addEventListener('DOMContentLoaded', () => {
            applyFilters();
        });

        function applyFilters() {
            const cards = document.querySelectorAll('.kamar-card-v2');
            let visible = 0;
            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                const propSlug = card.getAttribute('data-property-slug');
                const matchStatus = activeStatus === 'all' || status === activeStatus;
                const matchLocation = activeLocation === 'all' || propSlug === activeLocation;
                if (matchStatus && matchLocation) {
                    card.style.display = 'flex';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });
            const empty = document.getElementById('emptyFilter');
            if (empty) empty.style.display = visible === 0 ? 'block' : 'none';
        }

        function filterKamar(status, btn) {
            activeStatus = status;
            // Update active button — only within first filter-group (status)
            if (btn) {
                const group = btn.closest('.filter-group');
                group.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
            applyFilters();
        }

        function filterLocation(slug, btn) {
            activeLocation = slug;
            if (btn) {
                const group = btn.closest('.filter-group');
                group.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
            applyFilters();
        }

        // Tab selector for price tabs v2
        // formId & months are optional (guest mode doesn't submit form)
        function kcSelectTab(btn, formId, months) {
            const tabs = btn.closest('.kc-price-tabs');
            tabs.querySelectorAll('.kc-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            if (formId && months) {
                const input = document.getElementById('month-' + formId.replace('form-room-', ''));
                if (input) input.value = months;
            }
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
        const map = L.map('map').setView([-3.4650, 102.5210], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([-3.4650, 102.5210]).addTo(map).bindPopup('Kosan El Sholeha<br>Jalan Hegel Blok A No.03, Curup');

        // =============================================
        // SCROLLSPY LOGIC (Otomatis Highlight Menu Navbar)
        // =============================================
        window.addEventListener('scroll', () => {
            let current = '';
            // Ambil semua tag section yang ada di halaman
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.nav-menu .nav-link');
            // Ambil tinggi header untuk offset agar highlight tidak terlambat
            const headerHeight = document.querySelector('header').offsetHeight;

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;

                // Jika posisi scroll melewati bagian atas section (dikurangi tinggi header + sedikit buffer 50px)
                if (pageYOffset >= (sectionTop - headerHeight - 50)) {
                    current = section.getAttribute('id');
                }
            });

            // Loop semua menu di navbar, hapus class active, lalu tambahkan ke menu yang sesuai dengan ID section
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });

            // Opsional: Efek bayangan pada header saat di-scroll
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.08)';
            } else {
                header.style.boxShadow = 'none';
            }
        });
    </script>
</body>

</html>
