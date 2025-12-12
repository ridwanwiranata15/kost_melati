<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
        <script src="https://kit.fontawesome.com/60f3c978d3.js" crossorigin="anonymous"></script>
    <title>Tedjia | Profile</title>

    <style>
        /* =========================================
                BASE STYLE
        ========================================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8F9FD;
            color: #030620;
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

        /* =========================================
                SIDEBAR
        ========================================= */
        .sidebar {
            width: 280px;
            background-color: #02051E;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
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
            gap: 20px;
        }

        .nav-item .nav-link {
            color: #8C8F9E;
            transition: 0.3s;
        }

        .nav-item.active .nav-link {
            color: #D4F247;
        }

        .nav-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* =========================================
                MAIN WRAPPER
        ========================================= */
        .main-wrapper {
            flex-grow: 1;
            padding: 40px 50px;
            background-color: #FBFCFE;
        }

        .content-header {
            margin-bottom: 30px;
        }

        .content-header h1 {
            font-size: 28px;
            font-weight: 700;
        }

        /* =========================================
                PROFILE SECTION
        ========================================= */
        .profile-card {
            background: #fff;
            padding: 24px;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #F1F1F1;
            max-width: 500px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 100%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .profile-name {
            font-size: 20px;
            font-weight: 700;
        }

        .profile-info {
            margin-top: 20px;
        }

        .info-item {
            margin-bottom: 12px;
        }

        .info-label {
            font-size: 14px;
            color: #787A8C;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #02051E;
        }

        /* =========================================
                RESPONSIVE
        ========================================= */
        @media screen and (max-width: 768px) {
            .layout-wrapper {
                display: block;
            }

            .sidebar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                height: auto;
                padding: 0;
                border-top-left-radius: 20px;
                border-top-right-radius: 20px;
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
                z-index: 999;
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
                gap: 6px;
            }

            .nav-text {
                font-size: 11px;
            }

            .nav-icon {
                width: 20px;
                height: 20px;
            }

            .main-wrapper {
                padding: 20px 20px 100px 20px;
            }

            .profile-card {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar">
    <div class="sidebar-content">
        <div class="logo-container">
            <a href="/">
                <img src="logo-white.svg" height="40" alt="Tedjia Logo" />
            </a>
        </div>

        <ul class="nav-list">
            <li class="nav-item active">
                <a href="profile.html" class="nav-link">
                    <div class="nav-content">
                        <i class="fa-solid fa-user"></i>
                        <p class="nav-text">Profile</p>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a href="my-order.html" class="nav-link">
                    <div class="nav-content">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <p class="nav-text">My order</p>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf <button type="submit" class="nav-link" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; padding: 0;">
                        <div class="nav-content">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <p class="nav-text">Log out</p>
                        </div>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>

        <!-- MAIN CONTENT -->
        <div class="main-wrapper">
            <header class="content-header">
                <h1>My Profile</h1>
            </header>

            <section class="profile-section">
                <div class="profile-card">
                    <div class="profile-header">
                        <img src="{{ url('storage/' . auth()->user()->photo) }}" class="profile-img" alt="Profile" />
                        <h2 class="profile-name">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</h2>
                    </div>

                    <div class="profile-info">
                        <div class="info-item">
                            <p class="info-label">Email</p>
                            <p class="info-value">{{ auth()->check() ? auth()->user()->email : 'Guest' }}</p>
                        </div>
                        <div class="info-item">
                            <p class="info-label">Phone</p>
                            <p class="info-value">{{ auth()->check() ? auth()->user()->phone : 'Guest' }}</p>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</body>

</html>
