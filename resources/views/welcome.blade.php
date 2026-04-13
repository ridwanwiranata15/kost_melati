<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.theme-script')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Primary Meta Tags -->
    <meta name="title" content="Kost El Sholeha - Kost terdekat dari IAIN CURUP">
    <meta name="description" content="Kost yang terdekat dari IAIN Curup">
    <meta name="keywords" content="kost dekat IAIN curup, kost IAIN curup">
    <meta name="author" content="risky037">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Kost El Sholeha - Kost terdekat dari IAIN CURUP">
    <meta property="og:description" content="kost dekat IAIN curup, kost IAIN curup.">
    <meta property="og:image" content="{{ url('storage/default.jpg') }}">
    <meta property="og:site_name" content="Kost dekat IAIN Curup">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Kost dekat IAIN Curup - Wisata Edukasi Kalimantan">
    <meta name="twitter:description" content="Kost El Sholeha - Kost terdekat dari IAIN CURUP.">
    <meta name="twitter:image" content="{{ url('storage/default.jpg') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>Kost El Sholeha - Kost terdekat dari IAIN CURUP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        .fac-card {
            background: white;
            padding: 28px 20px;
            border-radius: 20px;
            border: 1px solid rgba(241, 245, 249, 0.8);
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .fac-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-light);
        }

        .fac-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 16px;
            /* Squircle look yang lebih modern */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 20px;
            transition: transform 0.3s ease;
        }

        .fac-card:hover .fac-icon {
            transform: scale(1.1) rotate(5deg);
            /* Interaksi halus saat di-hover */
        }

        .fac-card h4 {
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 12px;
            font-weight: 700;
        }

        .fac-desc {
            font-size: 0.9rem;
            color: var(--gray);
            line-height: 1.6;
            margin: 0;
            flex-grow: 1;
            /* Memastikan tinggi teks rapi */
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
            /* ... kode navbar mobile dll biarkan saja ... */

            /* Grid Adjustments */
            .hero-text h1 {
                font-size: 2rem;
            }

            /* --- UPDATE BAGIAN INI --- */
            .fac-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .fac-card {
                padding: 20px 12px;
                border-radius: 16px;
            }

            .fac-icon {
                width: 48px;
                height: 48px;
                font-size: 1.2rem;
                margin-bottom: 16px;
                border-radius: 12px;
            }

            .fac-card h4 {
                font-size: 0.95rem;
                margin-bottom: 8px;
            }

            .fac-desc {
                font-size: 0.8rem;
                line-height: 1.4;
            }

            /* --- AKHIR UPDATE --- */

            /* ... kode footer dll biarkan saja ... */
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

        /* =============================================
           ROOM CARDS v2 — Premium Redesign
        ============================================= */
        .kamar-section-wrapper {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            padding: 60px 0;
        }

        /* Filter Tabs dengan lokasi */
        .filter-group {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .filter-divider {
            width: 1px;
            background: #e2e8f0;
            margin: 0 4px;
        }

        /* Redesigned Card */
        .kamar-card-v2 {
            min-width: 300px;
            max-width: 300px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            position: relative;
            scroll-snap-align: center;
            border: 1px solid rgba(241, 245, 249, 0.8);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .kamar-card-v2:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
        }

        /* Image area */
        .kc-img {
            position: relative;
            height: 190px;
            overflow: hidden;
        }

        .kc-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .kamar-card-v2:hover .kc-img img {
            transform: scale(1.05);
        }

        .kc-img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(0, 0, 0, 0.5) 100%);
        }

        /* Badges on image */
        .kc-badges {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .kc-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            backdrop-filter: blur(8px);
            letter-spacing: 0.02em;
        }

        .kc-status.available {
            background: rgba(34, 197, 94, 0.9);
            color: white;
        }

        .kc-status.unavailable {
            background: rgba(239, 68, 68, 0.88);
            color: white;
        }

        .kc-status.repair {
            background: rgba(245, 158, 11, 0.9);
            color: white;
        }

        .kc-location-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.92);
            color: var(--dark);
            backdrop-filter: blur(8px);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            max-width: 120px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        /* Bottom property label on image */
        .kc-property-label {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 14px 8px;
            color: white;
        }

        .kc-property-label small {
            font-size: 0.72rem;
            opacity: 0.85;
            font-weight: 500;
        }

        .kc-property-label strong {
            display: block;
            font-size: 0.9rem;
            margin-top: 1px;
        }

        /* Card Body */
        .kc-body {
            padding: 18px 18px 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .kc-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .kc-room-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .kc-room-number {
            font-size: 0.75rem;
            color: var(--gray);
            font-weight: 500;
        }

        .kc-price-tag {
            text-align: right;
            flex-shrink: 0;
        }

        .kc-price-tag .price-amount {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .kc-price-tag .price-unit {
            font-size: 0.68rem;
            color: var(--gray);
        }

        .kc-desc {
            font-size: 0.85rem;
            color: var(--gray);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 12px;
        }

        /* Facilities chips */
        .kc-facilities {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 14px;
        }

        .kc-fac-chip {
            font-size: 0.68rem;
            padding: 3px 8px;
            border-radius: 20px;
            background: var(--gray-light);
            color: var(--gray);
            font-weight: 600;
            white-space: nowrap;
        }

        /* Price tabs */
        .kc-price-tabs {
            display: flex;
            background: #f1f5f9;
            padding: 3px;
            border-radius: 12px;
            margin-bottom: 14px;
            gap: 2px;
        }

        .kc-tab {
            flex: 1;
            text-align: center;
            padding: 7px 4px;
            border-radius: 9px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: transparent;
        }

        .kc-tab.active {
            background: white;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        }

        .kc-tab .t-dur {
            font-size: 0.65rem;
            color: var(--gray);
            font-weight: 600;
            display: block;
            line-height: 1.2;
        }

        .kc-tab .t-val {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--dark);
            display: block;
        }

        .kc-tab.active .t-val {
            color: var(--primary);
        }

        /* Card actions / footer */
        .kc-footer {
            padding: 14px 18px 18px;
            display: flex;
            gap: 8px;
            align-items: center;
            margin-top: auto;
        }

        .kc-btn-book {
            flex: 1;
            padding: 11px 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.88rem;
            border: none;
            cursor: pointer;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }

        .kc-btn-book.available {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 168, 89, 0.25);
        }

        .kc-btn-book.available:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 168, 89, 0.35);
        }

        .kc-btn-book.full {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .kc-btn-book.repair {
            background: #fef3c7;
            color: #d97706;
        }

        .kc-btn-book.guest {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 168, 89, 0.25);
        }

        .kc-btn-book.guest:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .kc-btn-wa {
            width: 42px;
            height: 42px;
            background: #f0fdf4;
            color: #16a34a;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            cursor: pointer;
            border: 1px solid #bbf7d0;
            transition: all 0.2s;
            flex-shrink: 0;
            text-decoration: none;
        }

        .kc-btn-wa:hover {
            background: #16a34a;
            color: white;
            border-color: #16a34a;
        }

        /* Alert states redesigned */
        .kc-alert {
            margin: 0 0 14px;
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .kc-alert.pending {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde68a;
        }

        .kc-alert.booked {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        @media (max-width: 768px) {
            .kamar-card-v2 {
                min-width: 82vw;
                max-width: 82vw;
            }
        }

        /* ============================================= */
    </style>
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
            <a href="#" class="logo">
                <i class="fas fa-home"></i>
                <div>
                    <h1>Kos El Sholeha</h1>
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
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'caretaker')
                            {{-- Staff: tombol ke Dashboard --}}
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-layout"></i>
                                Dashboard
                            </a>
                        @else
                            {{-- Customer: tombol ke Profil --}}
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
            <h1>Hunian Nyaman, <br><span>Kuliah Tenang.</span></h1>
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
                    <button class="filter-btn active" onclick="filterLocation('all', this)"><i
                            class="fas fa-globe-asia" style="font-size:0.75rem"></i> Semua Lokasi</button>
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
                                        <span class="t-val">6 Jt</span>
                                    </button>
                                </div>
                            @else
                                @php
                                    $alreadyBooked = Auth::user()
                                        ->bookings()
                                        ->where('room_id', $item->id)
                                        ->whereNotIn('status', ['cancelled'])
                                        ->exists();
                                @endphp
                                @if (!$alreadyBooked && Auth::user()->status != 'pending')
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
                                                <span class="t-val">6 Jt</span>
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
                                @if (Auth::user()->status == 'pending')
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
    </script>
</body>

</html>
