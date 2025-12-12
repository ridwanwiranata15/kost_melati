<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kos Melati Indah - Hunian Premium Dekat IAIN Curup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #00a859;
            --primary-dark: #008245;
            --primary-light: #e8f7f0;
            --primary-gradient: linear-gradient(135deg, #00a859 0%, #00c985 100%);
            --secondary: #ff7a00;
            --secondary-gradient: linear-gradient(135deg, #ff7a00 0%, #ff9a3d 100%);
            --accent: #7b61ff;
            --accent-gradient: linear-gradient(135deg, #7b61ff 0%, #9d8aff 100%);
            --dark: #1a1d29;
            --dark-light: #2a2f3d;
            --light: #f8fafc;
            --gray: #8a94a6;
            --gray-light: #e2e8f0;
            --white: #ffffff;

            --shadow-xs: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 24px 64px rgba(0, 0, 0, 0.18);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-xl: 32px;
            --radius-full: 50%;

            --transition-fast: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);

            --header-height: 70px;
            --header-height-scrolled: 60px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-size: 16px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            line-height: 1.2;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 4px;
        }

        /* Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Mobile First Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            z-index: 1000;
            transition: all var(--transition-base);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-sm);
        }

        .header-scrolled {
            height: var(--header-height-scrolled);
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-md);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            height: 100%;
            max-width: 1600px;
            margin: 0 auto;
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            z-index: 1001;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: var(--shadow-sm);
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text h1 {
            font-size: 1.3rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .logo-text span {
            font-size: 0.7rem;
            color: var(--gray);
            font-weight: 500;
            letter-spacing: 0.5px;
            display: none;
        }

        /* Mobile Navigation */
        .nav-links {
            display: none;
            position: fixed;
            top: var(--header-height);
            left: 0;
            right: 0;
            background: var(--white);
            padding: 1.5rem 5%;
            box-shadow: var(--shadow-lg);
            flex-direction: column;
            gap: 0;
            z-index: 999;
            max-height: calc(100vh - var(--header-height));
            overflow-y: auto;
            border-top: 1px solid var(--gray-light);
        }

        .nav-links.active {
            display: flex;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-links li {
            width: 100%;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            font-size: 1rem;
            padding: 1rem 0;
            transition: var(--transition-fast);
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--gray-light);
            width: 100%;
        }

        .nav-links a:last-child {
            border-bottom: none;
        }

        .nav-links a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .nav-links a.active {
            color: var(--primary);
            background: var(--primary-light);
            padding-left: 15px;
            border-radius: var(--radius-sm);
            margin: 0.2rem 0;
        }

        .nav-actions {
            display: flex;
            gap: 0.8rem;
            align-items: center;
        }

        .btn {
            padding: 0.7rem 1.2rem;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all var(--transition-base);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .mobile-menu-btn {
            display: block;
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--dark);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius-sm);
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hero Section - Mobile First */
        .hero {
            position: relative;
            padding-top: calc(var(--header-height) + 2rem);
            padding-bottom: 3rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e8f7f0 100%);
            overflow: hidden;
            min-height: auto;
        }

        .hero-bg {
            display: none;
        }

        .hero-content {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            display: block;
            padding: 0 5%;
        }

        .hero-text {
            max-width: 100%;
            margin-bottom: 2rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 168, 89, 0.1);
        }

        .hero h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--dark);
            line-height: 1.3;
        }

        .hero h1 .highlight {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1rem;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .hero-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .hero-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            padding: 1.5rem 0;
            border-top: 1px solid var(--gray-light);
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--gray);
            font-weight: 500;
        }

        .hero-image {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            height: 250px;
            margin-top: 2rem;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 5%;
        }

        /* Section Styling */
        .section {
            margin-bottom: 4rem;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.8rem;
            margin-bottom: 0.8rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 0.95rem;
            color: var(--gray);
            max-width: 100%;
            margin: 0 auto;
            line-height: 1.5;
        }

        /* Kamar Section */
        .kamar-filters {
            display: flex;
            overflow-x: auto;
            gap: 0.8rem;
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .kamar-filters::-webkit-scrollbar {
            display: none;
        }

        .filter-btn {
            padding: 0.6rem 1rem;
            background: var(--white);
            border: 2px solid var(--gray-light);
            border-radius: 30px;
            color: var(--gray);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-base);
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .filter-btn.active {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .kamar-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .kamar-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-base);
            border: 1px solid var(--gray-light);
            position: relative;
            width: 500px;
        }

        .kamar-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .kamar-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 2;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .badge-available {
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .badge-booked {
            background: var(--accent-gradient);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .kamar-img-container {
            height: 200px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .kamar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-slow);
        }

        .kamar-info {
            padding: 1.5rem;

        }

        .kamar-header {
            display: block;
            margin-bottom: 1rem;
        }

        .kamar-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .kamar-type {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .kamar-price {
            margin-bottom: 1rem;
        }

        .price-from {
            display: block;
            font-size: 0.75rem;
            color: var(--gray);
            margin-bottom: 0.3rem;
        }

        .price-amount {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .price-period {
            font-size: 0.8rem;
            color: var(--gray);
            font-weight: 500;
        }

        .kamar-description {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .kamar-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
            margin: 1rem 0;
            padding: 1rem 0;
            border-top: 1px solid var(--gray-light);
            border-bottom: 1px solid var(--gray-light);
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--dark);
        }

        .feature-item i {
            width: 20px;
            height: 20px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .pricing-tabs {
            display: flex;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .price-option {
            flex: 1;
            text-align: center;
            padding: 0.8rem 0.3rem;
            border-radius: var(--radius-md);
            border: 2px solid var(--gray-light);
            cursor: pointer;
            transition: all var(--transition-base);
            background: var(--white);
        }

        .price-option.active {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .price-duration {
            font-size: 0.75rem;
            color: var(--gray);
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .price-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.2rem;
        }

        .price-savings {
            font-size: 0.7rem;
            color: var(--secondary);
            font-weight: 600;
        }

        .kamar-facilities {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .facility-tag {
            background: var(--gray-light);
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            color: var(--gray);
        }

        .kamar-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .btn-action {
            padding: 0.7rem;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-base);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 0.85rem;
        }

        .btn-detail {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-detail:hover {
            background: var(--primary-light);
        }

        .btn-wa {
            background: #25D366;
            color: white;
            border: 2px solid #25D366;
        }

        .btn-wa:hover {
            background: #128C7E;
            border-color: #128C7E;
        }

        /* Features Section */
        .features-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f0f7ff 100%);
            padding: 3rem 5%;
            border-radius: var(--radius-lg);
            margin: 3rem 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .feature-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-base);
            border: 1px solid var(--gray-light);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-gradient);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-light);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: var(--primary);
            font-size: 1.5rem;
            transition: all var(--transition-base);
            box-shadow: var(--shadow-sm);
        }

        .feature-card:hover .feature-icon {
            background: var(--primary-gradient);
            color: white;
            transform: scale(1.05);
        }

        .feature-card h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
            font-size: 0.85rem;
            line-height: 1.4;
        }

        /* Location Section */
        .location-section {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin: 3rem 0;
            box-shadow: var(--shadow-lg);
        }

        .location-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
        }

        .location-content {
            position: relative;
            z-index: 2;
            padding: 2rem;
            display: block;
        }

        .location-text {
            color: white;
            margin-bottom: 2rem;
        }

        .location-text h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .location-text p {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .location-details {
            display: grid;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .location-detail {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .location-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .location-detail-text h4 {
            color: white;
            font-size: 1rem;
            margin-bottom: 0.2rem;
        }

        .location-detail-text p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin: 0;
        }

        .map-container {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            height: 300px;
        }

        #locationMap {
            width: 100%;
            height: 100%;
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .gallery-item {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            height: 200px;
            cursor: pointer;
            transition: all var(--transition-base);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-slow);
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 1rem;
            color: white;
            transform: translateY(0);
        }

        .gallery-overlay h4 {
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .gallery-overlay p {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        /* Testimonials */
        .testimonials-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e8f7f0 100%);
            padding: 3rem 5%;
            border-radius: var(--radius-lg);
            margin: 3rem 0;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .testimonial-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-base);
            position: relative;
            border: 1px solid var(--gray-light);
        }

        .testimonial-quote {
            position: absolute;
            top: -15px;
            left: 1.5rem;
            width: 30px;
            height: 30px;
            background: var(--primary-gradient);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-full);
            overflow: hidden;
            border: 3px solid var(--primary-light);
        }

        .testimonial-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .testimonial-info h4 {
            font-size: 1rem;
            margin-bottom: 0.2rem;
        }

        .testimonial-info span {
            color: var(--gray);
            font-size: 0.8rem;
        }

        .testimonial-rating {
            color: #ffc107;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .testimonial-text {
            color: var(--gray);
            font-style: italic;
            line-height: 1.5;
            font-size: 0.9rem;
            position: relative;
            padding-left: 1rem;
        }

        .testimonial-text::before {
            content: '"';
            position: absolute;
            left: 0;
            top: -5px;
            font-size: 2rem;
            color: var(--primary-light);
            font-family: Georgia, serif;
        }

        /* Contact Section */
        .contact-section {
            padding: 3rem 5%;
            background: linear-gradient(135deg, #f8fafc 0%, #f0f7ff 100%);
            border-radius: var(--radius-lg);
        }

        .contact-content {
            display: block;
        }

        .contact-info {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .contact-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-gradient);
        }

        .contact-info h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .contact-info p {
            color: var(--gray);
            margin-bottom: 1.5rem;
            line-height: 1.5;
            font-size: 0.95rem;
        }

        .contact-details {
            margin-top: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }

        .contact-item i {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .contact-item-text h4 {
            font-size: 1rem;
            margin-bottom: 0.2rem;
            color: var(--dark);
        }

        .contact-item-text p {
            color: var(--gray);
            margin: 0;
            font-size: 0.9rem;
        }

        .contact-form-wrapper {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .contact-form-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent-gradient);
        }

        .contact-form-wrapper h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid var(--gray-light);
            border-radius: var(--radius-md);
            font-size: 0.95rem;
            transition: all var(--transition-base);
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 168, 89, 0.1);
        }

        .form-row {
            display: block;
        }

        /* Floating Action Buttons */
        .floating-actions {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            z-index: 1000;
        }

        .floating-btn {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            transition: all var(--transition-base);
            text-decoration: none;
            position: relative;
        }

        .floating-btn:hover {
            transform: scale(1.1);
        }

        .floating-btn-wa {
            background: #25D366;
        }

        .floating-btn-call {
            background: var(--primary-gradient);
        }

        .floating-btn-top {
            background: var(--dark);
        }

        .btn-tooltip {
            display: none;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-light) 100%);
            color: white;
            padding: 3rem 5% 2rem;
            margin-top: 3rem;
            position: relative;
            overflow: hidden;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-col h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: white;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        .footer-col p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1rem;
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .social-links {
            display: flex;
            gap: 0.8rem;
        }

        .social-links a {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all var(--transition-base);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 0.8rem;
        }

        .footer-col ul li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all var(--transition-base);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: modalFadeIn 0.3s ease;
        }

        .modal-content {
            max-width: 100%;
            width: 100%;
            position: relative;
        }

        .modal-img {
            width: 100%;
            border-radius: var(--radius-lg);
            display: block;
        }

        .modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.7;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-full);
            background: rgba(255, 255, 255, 0.1);
        }

        .booking-modal {
            background: var(--white);
            border-radius: var(--radius-lg);
            max-width: 100%;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .booking-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid var(--gray-light);
        }

        .booking-title {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 0.3rem;
        }

        .booking-subtitle {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .booking-body {
            padding: 1rem 1.5rem 1.5rem;
        }

        /* Tablet Styles */
        @media (min-width: 768px) {
            :root {
                --header-height: 80px;
                --header-height-scrolled: 70px;
            }

            .logo-text h1 {
                font-size: 1.5rem;
            }

            .logo-text span {
                display: block;
                font-size: 0.75rem;
            }

            .hero {
                padding-top: calc(var(--header-height) + 3rem);
                padding-bottom: 4rem;
                min-height: 80vh;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-actions {
                flex-direction: row;
            }

            .hero-actions .btn {
                width: auto;
            }

            .hero-image {
                height: 350px;
            }

            .hero-stats {
                gap: 2rem;
            }

            .stat-number {
                font-size: 1.8rem;
            }

            .stat-label {
                font-size: 0.85rem;
            }

            .section-title {
                font-size: 2.2rem;
            }

            .kamar-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .testimonials-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .gallery-item {
                height: 250px;
            }

            .location-content {
                padding: 3rem;
            }

            .contact-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }

            .contact-info {
                margin-bottom: 0;
            }

            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }

            .nav-links {
                position: static;
                display: flex;
                flex-direction: row;
                background: transparent;
                padding: 0;
                box-shadow: none;
                max-height: none;
                overflow-y: visible;
                border-top: none;
                gap: 1.5rem;
            }

            .nav-links a {
                padding: 0.5rem 0;
                border-bottom: none;
                width: auto;
            }

            .nav-links a:hover {
                padding-left: 0;
            }

            .nav-links a.active {
                background: transparent;
                padding-left: 0;
                border-radius: 0;
                margin: 0;
            }

            .mobile-menu-btn {
                display: none;
            }

            .btn {
                padding: 0.8rem 1.5rem;
                font-size: 0.9rem;
            }
        }

        /* Desktop Styles */
        @media (min-width: 1024px) {
            .hero-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 3rem;
                align-items: center;
            }


            .hero-text {
                max-width: 600px;
                margin-bottom: 0;
            }

            .hero h1 {
                font-size: 3rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-image {
                height: 400px;
                margin-top: 0;
            }

            .hero-bg {
                display: block;
                position: absolute;
                top: 0;
                right: 0;
                width: 50%;
                height: 100%;
                background: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80') no-repeat center center;
                background-size: cover;
                opacity: 0.1;
                z-index: 0;
            }

            .section-title {
                font-size: 2.5rem;
            }

            .kamar-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .features-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 2rem;
            }

            .location-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 3rem;
                padding: 4rem;
            }

            .location-text {
                margin-bottom: 0;
            }

            .gallery-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .gallery-item:nth-child(1) {
                grid-column: span 2;
                grid-row: span 2;
                height: 520px;
            }

            .testimonials-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .footer-content {
                grid-template-columns: repeat(4, 1fr);
            }

            .floating-btn {
                width: 56px;
                height: 56px;
                font-size: 1.3rem;
            }

            .btn-tooltip {
                display: block;
                position: absolute;
                right: 70px;
                background: var(--dark);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: var(--radius-sm);
                font-size: 0.85rem;
                white-space: nowrap;
                opacity: 0;
                pointer-events: none;
                transition: opacity var(--transition-base);
            }

            .floating-btn:hover .btn-tooltip {
                opacity: 1;
            }
        }

        /* Large Desktop */
        @media (min-width: 1440px) {
            .hero h1 {
                font-size: 3.5rem;
            }

            .hero-image {
                height: 500px;
            }

            .kamar-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 2rem;
            }
        }

        /* Loading Animation */
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-message {
            position: fixed;
            top: 100px;
            right: 20px;
            background: var(--primary-gradient);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            transform: translateX(400px);
            transition: transform var(--transition-base);
            z-index: 2001;
        }

        .success-message.show {
            transform: translateX(0);
        }

        /* Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .checkbox-container input {
            display: none;
        }

        .checkmark {
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-light);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-fast);
        }

        .checkbox-container input:checked+.checkmark {
            background: var(--primary);
            border-color: var(--primary);
        }

        .checkbox-container input:checked+.checkmark::after {
            content: '✓';
            color: white;
            font-size: 0.8rem;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Touch-friendly improvements */
        @media (hover: none) and (pointer: coarse) {
            .kamar-card:hover {
                transform: none;
            }

            .feature-card:hover .feature-icon {
                transform: none;
            }

            .btn:hover,
            .filter-btn:hover,
            .floating-btn:hover {
                transform: none;
            }

            /* Increase touch target sizes */
            .btn,
            .filter-btn,
            .btn-action {
                min-height: 44px;
            }

            .form-control,
            select,
            input,
            textarea {
                font-size: 16px;
                /* Prevents iOS zoom on focus */
            }
        }

        .btn-after-verify {
            display: flex;
        }

        .btn-after-verify button {
            margin: 0px 20px;
            width: 200px;
        }

        @media (width:320px) {
            .pricing-tabs {
                display: block;
            }

            .price-option {
                width: 150px;
                margin-bottom: 10px;
                width: 100%;
            }

            .kamar-actions {
                display: block;
            }

            .btn-action {
                width: 100px;
                margin-bottom: 10px;
                width: 100%;
            }

            .kamar-card {
                width: 290px;
            }

            .hero-text h1 {
                font-size: 21px
            }

            .logo-text h1 {
                display: none;
            }

            .features-grid {
                display: block;
            }

            .feature-card {
                margin-bottom: 20px;
            }

        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div id="loadingOverlay">
        <div style="text-align: center;">
            <div
                style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #00a859; border-radius: 50%; animation: spin 1s linear infinite;">
            </div>
            <p style="margin-top: 20px; color: #666; font-weight: 500;">Memuat Kos Melati Indah...</p>
        </div>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="success-message">
        <i class="fas fa-check-circle"></i> <span id="successText">Operasi berhasil!</span>
    </div>

    <!-- Header -->
    <header id="mainHeader">
        <div class="navbar">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="logo-text">
                    <h1>Kos Melati Indah</h1>
                    <span>Hunian Premium Dekat IAIN Curup</span>
                </div>
            </a>

            <ul class="nav-links">
                <li><a href="#home" class="active"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="#kamar"><i class="fas fa-bed"></i> Kamar</a></li>
                <li><a href="#fasilitas"><i class="fas fa-star"></i> Fasilitas</a></li>
                <li><a href="#lokasi"><i class="fas fa-map-marker-alt"></i> Lokasi</a></li>
                <li><a href="#testimoni"><i class="fas fa-comment"></i> Testimoni</a></li>
                <li><a href="#kontak"><i class="fas fa-phone"></i> Kontak</a></li>
                @if (auth()->check())
                    <li><a href="{{ route('customer.profile') }}"><i class="fas fa-user"></i> Profil</a></li>
                @endif
            </ul>
            @if (!auth()->check())
                <div class="nav-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-user"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-user"></i> Register
                    </a>
                </div>
            @endif
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge floating">
                    <i class="fas fa-crown"></i> Kos Terbaik 2025
                </div>
                <h1>
                    Hunian <span class="highlight">Premium</span> untuk Mahasiswa
                    <span class="highlight">IAIN Curup</span>
                </h1>
                <p>
                    Kos Melati Indah menghadirkan pengalaman tinggal yang berbeda.
                    Dengan fasilitas premium, lokasi strategis 5 menit dari kampus,
                    dan lingkungan yang aman dan nyaman.
                </p>

                <div class="hero-actions">
                    <a href="#kamar" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat Kamar
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-secondary">
                        <i class="fab fa-whatsapp"></i> Konsultasi
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">5</div>
                        <div class="stat-label">Menit ke Kampus</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">8+</div>
                        <div class="stat-label">Kamar Tersedia</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Keamanan</div>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                    alt="Kos Melati Indah">
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <!-- Kamar Section -->
        <section class="section" id="kamar">
            <div class="section-header">
                <h2 class="section-title">Pilihan Kamar Premium</h2>
                <p class="section-subtitle">
                    Pilih kamar sesuai kebutuhan dan budget Anda. Semua kamar dilengkapi
                    fasilitas lengkap untuk kenyamanan maksimal.
                </p>
            </div>

            <div class="kamar-filters">
                <button class="filter-btn active" onclick="filterKamar('all')">
                    <i class="fas fa-border-all"></i> Semua
                </button>
                <button class="filter-btn" onclick="filterKamar('standard')">
                    <i class="fas fa-bed"></i> Standard
                </button>
                <button class="filter-btn" onclick="filterKamar('deluxe')">
                    <i class="fas fa-crown"></i> Deluxe
                </button>
                <button class="filter-btn" onclick="filterKamar('vip')">
                    <i class="fas fa-star"></i> VIP
                </button>
                <button class="filter-btn" onclick="filterKamar('available')">
                    <i class="fas fa-check-circle"></i> Tersedia
                </button>
            </div>

            <div class="kamar-grid" id="kamarGrid">
                @forelse($rooms as $item)
                    <div class="kamar-card" data-type="{{ strtolower($item->name) }}"
                        data-status="{{ $item->status }}" data-id="{{ $item->id }}">

                        <div class="kamar-badge {{ $item->status }}">
                            {{-- {{ $item->status_label }} --}}
                        </div>

                        <div class="kamar-img-container">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                                alt="Kamar {{ $item->room_number }}" class="kamar-img">
                        </div>

                        <div class="kamar-info">
                            <div class="kamar-header">
                                <div>
                                    <h3 class="kamar-name">Kamar {{ $item->room_number }}</h3>
                                    <span class="kamar-type">{{ $item->name }}</span>
                                </div>
                                <div class="kamar-price">
                                    <span class="price-from">Mulai dari</span>
                                    <div class="price-amount">10000</div>
                                    <span class="price-period">/bulan</span>

                                </div>
                            </div>

                            <p class="kamar-description">{{ $item->description }}</p>

                            <div class="pricing-tabs">
                                <div class="price-option">
                                    <div class="price-duration">3 Bulan</div>
                                    <div class="price-value">Rp 1.500.000</div>
                                    <input type="checkbox" name="choose_month" id="" value="3">
                                </div>
                                <div class="price-option">
                                    <div class="price-duration">6 Bulan</div>
                                    <div class="price-value">Rp. 3.000.000</div>
                                    <input type="checkbox" name="choose_month" id="" value="6">
                                </div>
                                <div class="price-option">
                                    <div class="price-duration">1 Tahun</div>
                                    <div class="price-value">Rp 6.000.000</div>
                                    <input type="checkbox" name="choose_month" id="" value="12">
                                </div>
                            </div>

                            <div class="kamar-facilities">

                                <span class="facility-tag">{{ $item->facility }}</span>

                            </div>


                            {{-- Cek dulu apakah user sudah login --}}
                            @if (auth()->check())
                                {{-- Jika user login dan statusnya pending --}}
                                @if (auth()->user()->status == 'pending')
                                    <button class="btn-action btn-disabled" disabled>
                                        Menunggu Verifikasi
                                    </button>

                                    {{-- Jika user login dan statusnya TIDAK pending (sudah verified) --}}
                                @else
                                    <div class="btn-after-verify">
                                        <button class="btn-action btn-wa">
                                            Checkout
                                        </button>

                                        @if ($item->status === 'tersedia')
                                            <button class="btn-action btn-wa">
                                                <i class="fab fa-whatsapp"></i> Tanya
                                            </button>
                                        @else
                                            <button class="btn-action btn-disabled" disabled>
                                                <i class="fas fa-lock"></i> Tidak Tersedia
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center">
                        <i class="fas fa-bed text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-600">Tidak ada kamar tersedia</h3>
                        <p class="text-gray-500">Semua kamar sedang terisi atau dalam perawatan</p>
                    </div>
                @endforelse
            </div>

            @push('scripts')
                <script>
                    // Fungsi untuk memilih harga
                    function selectPriceOption(element, kamarId) {
                        // Hapus active class dari semua option di card yang sama
                        const card = element.closest('.kamar-card');
                        card.querySelectorAll('.price-option').forEach(option => {
                            option.classList.remove('active');
                        });

                        // Tambah active class ke option yang dipilih
                        element.classList.add('active');

                        // Update harga yang dipilih (bisa digunakan untuk booking)
                        const harga = element.getAttribute('data-harga');
                        console.log(`Kamar ${kamarId} dipilih dengan harga: ${harga}`);
                    }

                    // Fungsi untuk melihat detail kamar
                    function viewKamarDetail(kamarId) {
                        // Bisa diimplementasikan dengan modal atau halaman detail
                        Livewire.emit('showKamarDetail', kamarId);
                    }

                    // Fungsi untuk kontak WhatsApp
                    function contactWhatsApp(kamarInfo) {
                        const phone = '6281234567890'; // Ganti dengan nomor admin
                        const message = `Halo, saya tertarik dengan ${kamarInfo}. Bisa info lebih lanjut?`;
                        const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
                        window.open(url, '_blank');
                    }

                    // Filter kamar berdasarkan tipe/status
                    function filterKamar(type, status) {
                        const cards = document.querySelectorAll('.kamar-card');
                        cards.forEach(card => {
                            const showByType = type === 'all' || card.dataset.type === type;
                            const showByStatus = status === 'all' || card.dataset.status === status;

                            if (showByType && showByStatus) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    }
                </script>
            @endpush
        </section>

        <!-- Features Section -->
        <section class="features-section" id="fasilitas">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Fasilitas Unggulan</h2>
                    <p class="section-subtitle">
                        Nikmati berbagai fasilitas premium yang membuat hidup di Kos Melati Indah
                        semakin nyaman dan produktif.
                    </p>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h3>WiFi High Speed</h3>
                        <p>Internet super cepat 24 jam untuk belajar, streaming, dan bekerja.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Keamanan 24/7</h3>
                        <p>CCTV, akses kartu, dan penjaga 24 jam untuk keamanan maksimal.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3>Dapur Modern</h3>
                        <p>Dapur lengkap dengan kompor, kulkas, dan perlengkapan memasak.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tint"></i>
                        </div>
                        <h3>Air Panas 24 Jam</h3>
                        <p>Air panas tersedia 24 jam di setiap kamar mandi.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h3>Parkir Luas</h3>
                        <p>Area parkir yang luas dan aman untuk motor dan mobil.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-sun"></i>
                        </div>
                        <h3>Laundry Service</h3>
                        <p>Layanan laundry dengan harga terjangkau dan proses cepat.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Ruang Bersama</h3>
                        <p>Ruang santai untuk berkumpul, belajar bersama, atau bersosialisasi.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tree"></i>
                        </div>
                        <h3>Taman Hijau</h3>
                        <p>Area hijau yang asri untuk relaksasi dan udara segar.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location Section -->
        <section class="location-section" id="lokasi">
            <div class="location-bg"></div>
            <div class="location-content">
                <div class="location-text">
                    <h2>Lokasi Strategis di Pusat Kota Curup</h2>
                    <p>
                        Kos Melati Indah berada di lokasi yang sangat strategis,
                        memberikan kemudahan akses ke berbagai fasilitas penting.
                    </p>

                    <div class="location-details">
                        <div class="location-detail">
                            <div class="location-icon">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="location-detail-text">
                                <h4>IAIN Curup</h4>
                                <p>5 menit berkendara, 15 menit jalan kaki</p>
                            </div>
                        </div>

                        <div class="location-detail">
                            <div class="location-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="location-detail-text">
                                <h4>Pusat Perbelanjaan</h4>
                                <p>Dekat dengan pasar dan minimarket 24 jam</p>
                            </div>
                        </div>

                        <div class="location-detail">
                            <div class="location-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="location-detail-text">
                                <h4>Kuliner</h4>
                                <p>Banyak warung makan dan cafe dalam jarak dekat</p>
                            </div>
                        </div>

                        <div class="location-detail">
                            <div class="location-icon">
                                <i class="fas fa-bus"></i>
                            </div>
                            <div class="location-detail-text">
                                <h4>Transportasi</h4>
                                <p>Akses mudah ke terminal dan angkutan kota</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="map-container">
                    <div id="locationMap"></div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Galeri Kos</h2>
                <p class="section-subtitle">
                    Lihat langsung suasana dan fasilitas Kos Melati Indah melalui galeri foto kami.
                </p>
            </div>
            <div class="gallery-grid" id="galleryGrid">
                <!-- Gallery 1 -->
                <div class="gallery-item" onclick="openGalleryModal(0)">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                        alt="Tampak Depan Kos">
                    <div class="gallery-overlay">
                        <h4>Tampak Depan Kos</h4>
                        <p>Bangunan modern dengan desain minimalis</p>
                    </div>
                </div>

                <!-- Gallery 2 -->
                <div class="gallery-item" onclick="openGalleryModal(1)">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Kamar Standard">
                    <div class="gallery-overlay">
                        <h4>Kamar Standard</h4>
                        <p>Kamar nyaman dengan pencahayaan alami</p>
                    </div>
                </div>

                <!-- Gallery 3 -->
                <div class="gallery-item" onclick="openGalleryModal(2)">
                    <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Kamar Deluxe">
                    <div class="gallery-overlay">
                        <h4>Kamar Deluxe</h4>
                        <p>Kamar premium dengan fasilitas lengkap</p>
                    </div>
                </div>

                <!-- Gallery 4 -->
                <div class="gallery-item" onclick="openGalleryModal(3)">
                    <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Ruang Bersama">
                    <div class="gallery-overlay">
                        <h4>Ruang Bersama</h4>
                        <p>Area santai untuk berkumpul dan bersosialisasi</p>
                    </div>
                </div>

                <!-- Gallery 5 -->
                <div class="gallery-item" onclick="openGalleryModal(4)">
                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Dapur Bersama">
                    <div class="gallery-overlay">
                        <h4>Dapur Bersama</h4>
                        <p>Dapur modern dengan peralatan lengkap</p>
                    </div>
                </div>

                <!-- Gallery 6 -->
                <div class="gallery-item" onclick="openGalleryModal(5)">
                    <img src="https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Taman Depan">
                    <div class="gallery-overlay">
                        <h4>Taman Depan</h4>
                        <p>Area hijau untuk bersantai di depan kos</p>
                    </div>
                </div>

                <!-- Gallery 7 -->
                <div class="gallery-item" onclick="openGalleryModal(6)">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Area Parkir">
                    <div class="gallery-overlay">
                        <h4>Area Parkir</h4>
                        <p>Parkir luas dan aman untuk kendaraan</p>
                    </div>
                </div>

                <!-- Gallery 8 -->
                <div class="gallery-item" onclick="openGalleryModal(7)">
                    <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Lobi Utama">
                    <div class="gallery-overlay">
                        <h4>Lobi Utama</h4>
                        <p>Area penerimaan tamu yang nyaman</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section" id="testimoni">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Kata Penghuni</h2>
                    <p class="section-subtitle">
                        Dengarkan pengalaman langsung dari penghuni Kos Melati Indah.
                    </p>
                </div>

                <div class="testimonials-grid" id="testimonialsGrid">
                    <!-- Testimonial 1 -->
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sari Dewi">
                            </div>
                            <div class="testimonial-info">
                                <h4>Sari Dewi</h4>
                                <span>Mahasiswa IAIN Curup - Semester 5</span>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            ★★★★★
                        </div>
                        <p class="testimonial-text">Tinggal di Kos Melati Indah sangat nyaman. Lokasinya strategis,
                            fasilitas lengkap, dan lingkungannya aman. WiFi-nya cepat banget untuk kuliah online!
                            Pengelola juga ramah dan responsif.</p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="Rudi Hartono">
                            </div>
                            <div class="testimonial-info">
                                <h4>Rudi Hartono</h4>
                                <span>Mahasiswa IAIN Curup - Semester 7</span>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            ★★★★★
                        </div>
                        <p class="testimonial-text">Pengalaman terbaik selama jadi mahasiswa. Kamar bersih, parkir
                            aman, dan pengelola sangat responsif. Recommended untuk mahasiswa yang serius kuliah!</p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Maya Sari">
                            </div>
                            <div class="testimonial-info">
                                <h4>Maya Sari</h4>
                                <span>Mahasiswa IAIN Curup - Semester 3</span>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            ★★★★☆
                        </div>
                        <p class="testimonial-text">Air panas 24 jam sangat membantu di cuaca dingin Curup. Dapur
                            bersama juga lengkap peralatannya. Tinggal bawa bahan masak saja. Lingkungannya juga tenang
                            untuk belajar.</p>
                    </div>

                    <!-- Testimonial 4 -->
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Budi Santoso">
                            </div>
                            <div class="testimonial-info">
                                <h4>Budi Santoso</h4>
                                <span>Mahasiswa IAIN Curup - Semester 6</span>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            ★★★★★
                        </div>
                        <p class="testimonial-text">Sudah 2 tahun tinggal di sini dan sangat puas. Keamanan terjamin 24
                            jam, parkir luas, dan fasilitas selalu terawat. Cocok untuk mahasiswa yang fokus studi.</p>
                    </div>

                    <!-- Testimonial 5 -->
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Dewi Lestari">
                            </div>
                            <div class="testimonial-info">
                                <h4>Dewi Lestari</h4>
                                <span>Mahasiswa IAIN Curup - Semester 4</span>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            ★★★★☆
                        </div>
                        <p class="testimonial-text">Kamar bersih dan rapi setiap hari. Laundry service sangat membantu
                            saat sibuk ujian. Lokasi dekat kampus menghemat waktu dan biaya transportasi.</p>
                    </div>

                    <!-- Testimonial 6 -->
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-header">
                            <div class="testimonial-avatar">
                                <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Ahmad Fauzi">
                            </div>
                            <div class="testimonial-info">
                                <h4>Ahmad Fauzi</h4>
                                <span>Mahasiswa IAIN Curup - Semester 8</span>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            ★★★★★
                        </div>
                        <p class="testimonial-text">Sebagai mahasiswa tingkat akhir, butuh tempat yang kondusif untuk
                            skripsi. Kos ini sempurna! Tenang, WiFi stabil, dan ada ruang belajar bersama yang nyaman.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section" id="kontak">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Hubungi Kami</h2>
                    <p class="section-subtitle">
                        Punya pertanyaan? Tim kami siap membantu Anda.
                    </p>
                </div>

                <div class="contact-content">
                    <div class="contact-info">
                        <h3>Informasi Kontak</h3>
                        <p>
                            Hubungi kami untuk informasi lebih lanjut,
                            peninjauan lokasi, atau konsultasi pemilihan kamar.
                        </p>

                        <div class="contact-details">
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="contact-item-text">
                                    <h4>Alamat</h4>
                                    <p>Jl. Merpati No. 45, Curup<br>Rejang Lebong, Bengkulu 39119</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <div class="contact-item-text">
                                    <h4>Telepon/WhatsApp</h4>
                                    <p>0812-3456-7890 (Bu Ani)<br>0813-9876-5432 (Pak Budi)</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div class="contact-item-text">
                                    <h4>Email</h4>
                                    <p>info@kosmelatiindah.co.id<br>booking@kosmelatiindah.co.id</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <i class="fas fa-clock"></i>
                                <div class="contact-item-text">
                                    <h4>Jam Kunjung</h4>
                                    <p>Senin - Minggu: 08:00 - 20:00 WIB<br>Kunjungan bisa dengan appointment</p>
                                </div>
                            </div>
                        </div>

                        <div class="social-links">
                            <a href="https://wa.me/6281234567890" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="https://instagram.com/kosmelatiindah" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://facebook.com/kosmelatiindah" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="mailto:info@kosmelatiindah.co.id">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>

                    <div class="contact-form-wrapper">
                        <h3>Kirim Pesan</h3>
                        <form id="contactForm">
                            <div class="form-group">
                                <label for="name">Nama Lengkap *</label>
                                <input type="text" id="name" class="form-control"
                                    placeholder="Masukkan nama Anda" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Nomor WhatsApp *</label>
                                <input type="tel" id="phone" class="form-control" placeholder="08xxxxxxxxxx"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control"
                                    placeholder="nama@email.com">
                            </div>

                            <div class="form-group">
                                <label for="subject">Subjek *</label>
                                <select id="subject" class="form-control" required>
                                    <option value="">Pilih subjek</option>
                                    <option value="kamar">Informasi Kamar</option>
                                    <option value="booking">Booking Kamar</option>
                                    <option value="fasilitas">Informasi Fasilitas</option>
                                    <option value="kunjungan">Peninjauan Lokasi</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">Pesan *</label>
                                <textarea id="message" class="form-control" rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>
                            </div>

                            <div class="checkbox-container">
                                <input type="checkbox" id="terms" required>
                                <span class="checkmark"></span>
                                <label for="terms">Saya setuju dengan syarat dan ketentuan</label>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Floating Action Buttons -->
    <div class="floating-actions">
        <a href="https://wa.me/6281234567890" target="_blank" class="floating-btn floating-btn-wa">
            <i class="fab fa-whatsapp"></i>
            <span class="btn-tooltip">Chat via WhatsApp</span>
        </a>
        <a href="tel:081234567890" class="floating-btn floating-btn-call">
            <i class="fas fa-phone"></i>
            <span class="btn-tooltip">Telepon Sekarang</span>
        </a>
        <a href="#home" class="floating-btn floating-btn-top">
            <i class="fas fa-arrow-up"></i>
            <span class="btn-tooltip">Ke Atas</span>
        </a>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h3>Kos Melati Indah</h3>
                <p>
                    Kos premium dengan fasilitas lengkap dan lokasi strategis
                    di jantung kota Curup. Tempat tinggal ideal untuk mahasiswa
                    IAIN Curup yang mengutamakan kenyamanan dan produktivitas.
                </p>
                <div class="social-links">
                    <a href="https://wa.me/6281234567890" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://instagram.com/kosmelatiindah" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://facebook.com/kosmelatiindah" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                </div>
            </div>

            <div class="footer-col">
                <h3>Link Cepat</h3>
                <ul>
                    <li><a href="#home"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                    <li><a href="#kamar"><i class="fas fa-chevron-right"></i> Kamar Tersedia</a></li>
                    <li><a href="#fasilitas"><i class="fas fa-chevron-right"></i> Fasilitas</a></li>
                    <li><a href="#lokasi"><i class="fas fa-chevron-right"></i> Lokasi</a></li>
                    <li><a href="#testimoni"><i class="fas fa-chevron-right"></i> Testimoni</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Fasilitas</h3>
                <ul>
                    <li><a href="#fasilitas"><i class="fas fa-check"></i> WiFi High Speed</a></li>
                    <li><a href="#fasilitas"><i class="fas fa-check"></i> Keamanan 24/7</a></li>
                    <li><a href="#fasilitas"><i class="fas fa-check"></i> Dapur Modern</a></li>
                    <li><a href="#fasilitas"><i class="fas fa-check"></i> Air Panas 24 Jam</a></li>
                    <li><a href="#fasilitas"><i class="fas fa-check"></i> Parkir Luas</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Kontak Kami</h3>
                <p><i class="fas fa-map-marker-alt"></i> Jl. Merpati No. 45, Curup</p>
                <p><i class="fas fa-phone"></i> 0812-3456-7890 (Bu Ani)</p>
                <p><i class="fas fa-envelope"></i> info@kosmelatiindah.co.id</p>
                <p><i class="fas fa-clock"></i> 08:00 - 20:00 WIB (Setiap Hari)</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Kos Melati Indah Curup. All rights reserved. | Developed with <i class="fas fa-heart"
                    style="color: #ff4757;"></i> for IAIN Curup Students</p>
        </div>
    </footer>

    <!-- Modals -->
    <div class="modal" id="galleryModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('galleryModal')">&times;</button>
            <img id="modalImg" class="modal-img" src="" alt="">
        </div>
    </div>



    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Gallery data array
        const galleryData = [{
                img: "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                title: "Tampak Depan Kos",
                desc: "Bangunan modern dengan desain minimalis"
            },
            {
                img: "https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                title: "Kamar Standard",
                desc: "Kamar nyaman dengan pencahayaan alami"
            },
            {
                img: "https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                title: "Kamar Deluxe",
                desc: "Kamar premium dengan fasilitas lengkap"
            },
            {
                img: "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                title: "Ruang Bersama",
                desc: "Area santai untuk berkumpul dan bersosialisasi"
            },
            {
                img: "https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                title: "Dapur Bersama",
                desc: "Dapur modern dengan peralatan lengkap"
            },
            {
                img: "https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                title: "Taman Depan",
                desc: "Area hijau untuk bersantai di depan kos"
            },
            {
                img: "https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                title: "Area Parkir",
                desc: "Parkir luas dan aman untuk kendaraan"
            },
            {
                img: "https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                title: "Lobi Utama",
                desc: "Area penerimaan tamu yang nyaman"
            }
        ];

        // Kamar data array
        const kamarData = [{
                id: 1,
                nomor_kamar: "101",
                nama_kamar: "Kamar 101 - Standard",
                tipe: "standard",
                status: "available",
                deskripsi: "Kamar standar dengan fasilitas lengkap, cocok untuk mahasiswa yang mencari tempat tinggal nyaman dengan harga terjangkau. Kamar luas 3x3 meter dengan jendela besar.",
                fasilitas: ["WiFi", "Kamar Mandi Dalam", "Lemari", "Meja Belajar", "Kursi", "AC", "Kasur Single"],
                harga_3bulan: 1200000,
                harga_6bulan: 2200000,
                harga_1tahun: 4200000,
                foto: "https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
            },
            {
                id: 2,
                nomor_kamar: "102",
                nama_kamar: "Kamar 102 - Deluxe",
                tipe: "deluxe",
                status: "available",
                deskripsi: "Kamar deluxe dengan AC, lemari lebih besar, dan view yang lebih bagus. Dilengkapi dengan meja belajar khusus dan kamar mandi dalam yang luas.",
                fasilitas: ["WiFi", "Kamar Mandi Dalam", "Lemari Besar", "Meja Belajar", "Kursi", "AC", "TV 32\"",
                    "Kulkas Mini", "Air Panas"
                ],
                harga_3bulan: 1800000,
                harga_6bulan: 3300000,
                harga_1tahun: 6200000,
                foto: "https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
            },
            {
                id: 3,
                nomor_kamar: "103",
                nama_kamar: "Kamar 103 - VIP",
                tipe: "vip",
                status: "available",
                deskripsi: "Kamar VIP dengan fasilitas terbaik. Ruang lebih luas, balkon pribadi, dan perlengkapan lengkap. Cocok untuk mahasiswa yang mengutamakan kenyamanan maksimal.",
                fasilitas: ["WiFi", "Kamar Mandi Dalam", "Lemari Besar", "Meja Belajar", "Kursi", "AC Inverter",
                    "Smart TV 43\"", "Kulkas Mini", "Air Panas", "Balkon Pribadi"
                ],
                harga_3bulan: 2550000,
                harga_6bulan: 4800000,
                harga_1tahun: 9200000,
                foto: "https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
            }
        ];

        // Initialize App
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading overlay
            setTimeout(() => {
                document.getElementById('loadingOverlay').style.display = 'none';
            }, 1000);

            // Initialize components
            initMap();
            setupEventListeners();

            // Header scroll effect
            setupHeaderScroll();

            // Setup mobile menu close on click outside
            setupMobileMenu();

            // Set min date for booking
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            document.getElementById('bookingDate').min = tomorrow.toISOString().split('T')[0];
        });

        // Format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Initialize Map
        function initMap() {
            const kosLocation = [-3.4730, 102.5200];
            const map = L.map('locationMap').setView(kosLocation, 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            const customIcon = L.divIcon({
                html: '<div style="width: 40px; height: 40px; background: var(--primary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; box-shadow: var(--shadow-lg);"><i class="fas fa-home"></i></div>',
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            const kosMarker = L.marker(kosLocation, {
                icon: customIcon
            }).addTo(map);
            kosMarker.bindPopup(`
                <div style="padding: 10px;">
                    <h3 style="margin: 0 0 5px 0; color: var(--primary);">Kos Melati Indah</h3>
                    <p style="margin: 0 0 5px 0; color: #666;">Jl. Merpati No. 45, Curup</p>
                    <p style="margin: 0; color: #999;">5 menit ke IAIN Curup</p>
                    <a href="https://maps.google.com/?q=-3.4730,102.5200" target="_blank" style="display: inline-block; margin-top: 5px; padding: 5px 10px; background: var(--primary); color: white; text-decoration: none; border-radius: 5px; font-size: 12px;">Buka di Google Maps</a>
                </div>
            `).openPopup();

            // Add IAIN Curup marker
            const iainLocation = [-3.4680, 102.5250];
            const iainMarker = L.marker(iainLocation).addTo(map);
            iainMarker.bindPopup(`
                <div style="padding: 10px;">
                    <h3 style="margin: 0 0 5px 0; color: var(--primary);">IAIN Curup</h3>
                    <p style="margin: 0 0 5px 0; color: #666;">Kampus Utama</p>
                    <p style="margin: 0; color: #999;">5 menit dari kos</p>
                </div>
            `);
        }

        // Setup Event Listeners
        function setupEventListeners() {
            // Contact Form
            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = {
                    name: document.getElementById('name').value,
                    phone: document.getElementById('phone').value,
                    email: document.getElementById('email').value,
                    subject: document.getElementById('subject').value,
                    message: document.getElementById('message').value
                };

                const whatsappMessage = `
Halo, saya ${formData.name}.

Saya ingin bertanya tentang: ${formData.subject}

Detail pesan:
${formData.message}

Email: ${formData.email || 'Tidak diisi'}
Kontak saya: ${formData.phone}

Mohon info lebih lanjut. Terima kasih!
                `.trim();

                const encodedMessage = encodeURIComponent(whatsappMessage);
                window.open(`https://wa.me/6281234567890?text=${encodedMessage}`, '_blank');

                this.reset();
                showSuccessMessage('Pesan berhasil dikirim! Anda akan diarahkan ke WhatsApp.');
            });

            // Booking Form
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const bookingData = {
                    name: document.getElementById('bookingName').value,
                    phone: document.getElementById('bookingPhone').value,
                    email: document.getElementById('bookingEmail').value,
                    room: document.getElementById('bookingRoom').value,
                    duration: document.getElementById('bookingDuration').value,
                    date: document.getElementById('bookingDate').value
                };

                const bookingCode = 'KMI-' + Date.now().toString().slice(-6);
                const roomPrice = {
                    '101': 400000,
                    '102': 600000,
                    '103': 850000,
                    '105': 550000,
                    '106': 420000
                };

                const durationText = {
                    '3bulan': '3 Bulan',
                    '6bulan': '6 Bulan',
                    '1tahun': '1 Tahun'
                };

                const selectedRoom = bookingData.room.split(' - ')[0];
                const monthlyPrice = roomPrice[selectedRoom] || 0;

                const bookingMessage = `
📋 BOOKING KOS MELATI INDAH

🆔 Kode Booking: ${bookingCode}
👤 Nama: ${bookingData.name}
📞 WhatsApp: ${bookingData.phone}
📧 Email: ${bookingData.email || 'Tidak diisi'}

🏠 Kamar: ${bookingData.room}
💰 Harga: Rp ${monthlyPrice.toLocaleString()}/bulan
⏱️ Durasi: ${durationText[bookingData.duration]}
📅 Tanggal Masuk: ${bookingData.date}

Mohon konfirmasi ketersediaan kamar dan informasi pembayaran. Terima kasih!
                `.trim();

                const encodedMessage = encodeURIComponent(bookingMessage);
                window.open(`https://wa.me/6281234567890?text=${encodedMessage}`, '_blank');

                this.reset();
                closeModal('bookingModal');
                showSuccessMessage(
                    `Booking berhasil! Kode booking: ${bookingCode}. Silakan lanjutkan ke WhatsApp untuk konfirmasi.`
                    );
            });
        }

        // Filter Kamar
        function filterKamar(filter) {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            const kamarCards = document.querySelectorAll('.kamar-card');

            kamarCards.forEach(card => {
                const type = card.getAttribute('data-type');
                const status = card.getAttribute('data-status');
                let show = false;

                switch (filter) {
                    case 'all':
                        show = true;
                        break;
                    case 'standard':
                        show = type === 'standard';
                        break;
                    case 'deluxe':
                        show = type === 'deluxe';
                        break;
                    case 'vip':
                        show = type === 'vip';
                        break;
                    case 'available':
                        show = status === 'available';
                        break;
                }

                card.style.display = show ? 'block' : 'none';
            });
        }

        // Select Price Option
        function selectPriceOption(element, kamarId) {
            const parent = element.parentElement;
            parent.querySelectorAll('.price-option').forEach(option => {
                option.classList.remove('active');
            });
            element.classList.add('active');
        }

        // View Kamar Detail
        function viewKamarDetail(kamarId) {
            const kamar = kamarData.find(k => k.id === kamarId);
            if (!kamar) {
                showSuccessMessage(`Melihat detail Kamar ${kamarId}`);
                document.getElementById('kamar').scrollIntoView({
                    behavior: 'smooth'
                });
                return;
            }

            // Show detailed information
            const detailMessage = `
Detail Kamar ${kamar.nomor_kamar} - ${kamar.tipe.toUpperCase()}

${kamar.deskripsi}

📋 Fasilitas:
${kamar.fasilitas.map(f => `• ${f}`).join('\n')}

💰 Harga:
• 3 Bulan: ${formatRupiah(kamar.harga_3bulan)}
• 6 Bulan: ${formatRupiah(kamar.harga_6bulan)} (Hemat ${formatRupiah((kamar.harga_3bulan * 2) - kamar.harga_6bulan)})
• 1 Tahun: ${formatRupiah(kamar.harga_1tahun)} (Hemat ${formatRupiah((kamar.harga_3bulan * 4) - kamar.harga_1tahun)})

Status: ${kamar.status === 'available' ? 'TERSEDIA' : 'TERISI'}
            `.trim();

            showSuccessMessage(`Melihat detail ${kamar.nama_kamar}`);

            // Scroll to kamar section
            document.getElementById('kamar').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Contact via WhatsApp
        function contactWhatsApp(kamarNama) {
            const message = `Halo, saya tertarik dengan ${kamarNama} di Kos Melati Indah. Bisa minta info lebih lanjut?`;
            const encodedMessage = encodeURIComponent(message);
            window.open(`https://wa.me/6281234567890?text=${encodedMessage}`, '_blank');
        }

        // Open Gallery Modal
        function openGalleryModal(index) {
            const item = galleryData[index];
            document.getElementById('modalImg').src = item.img;
            document.getElementById('galleryModal').style.display = 'flex';
        }

        // Close Modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Show Booking Modal
        function showBookingModal() {
            document.getElementById('bookingModal').style.display = 'flex';
        }

        // Show Success Message
        function showSuccessMessage(message) {
            const successMessage = document.getElementById('successMessage');
            const successText = document.getElementById('successText');

            successText.textContent = message;
            successMessage.classList.add('show');

            setTimeout(() => {
                successMessage.classList.remove('show');
            }, 3000);
        }

        // Setup Header Scroll Effect
        function setupHeaderScroll() {
            const header = document.getElementById('mainHeader');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
            });
        }

        // Toggle Mobile Menu
        function toggleMobileMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');

            // Update button icon
            const menuBtn = document.querySelector('.mobile-menu-btn i');
            if (navLinks.classList.contains('active')) {
                menuBtn.className = 'fas fa-times';
            } else {
                menuBtn.className = 'fas fa-bars';
            }
        }

        // Setup Mobile Menu
        function setupMobileMenu() {
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                const navLinks = document.querySelector('.nav-links');
                const mobileMenuBtn = document.querySelector('.mobile-menu-btn');

                if (navLinks.classList.contains('active') &&
                    !navLinks.contains(e.target) &&
                    !mobileMenuBtn.contains(e.target)) {
                    toggleMobileMenu();
                }
            });

            // Close menu when clicking on a link
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        toggleMobileMenu();
                    }
                });
            });
        }

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });

        // Handle keyboard events
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('galleryModal');
                closeModal('bookingModal');

                // Close mobile menu if open
                const navLinks = document.querySelector('.nav-links');
                if (navLinks.classList.contains('active')) {
                    toggleMobileMenu();
                }
            }
        });

        // Prevent zoom on mobile for inputs
        document.addEventListener('touchstart', function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') {
                document.body.style.fontSize = '16px';
            }
        });

        document.addEventListener('touchend', function() {
            setTimeout(() => {
                document.body.style.fontSize = '';
            }, 1000);
        });

        // Animation for loading
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

        // Gunakan querySelectorAll untuk mengambil SEMUA elemen
        const priceOptions = document.querySelectorAll('.price-option');

        priceOptions.forEach((price) => {
            // Cari checkbox di dalam elemen parent tersebut
            price.addEventListener("click", () => {
                const checkboxPrice = price.querySelector("input[type='checkbox']");

                // Cek dulu apakah checkbox-nya ketemu untuk menghindari error null
                if (checkboxPrice) {
                    checkboxPrice.checked = !checkboxPrice.checked;
                }

            })
        });
    </script>
</body>

</html>
