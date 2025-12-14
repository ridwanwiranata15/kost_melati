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

        <form action="{{ route('booking.pay', $transaction->id) }}" method="post" enctype="multipart/form-data"
            class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
            @csrf
            @method('put')

            <h2 class="text-xl font-semibold mb-4 text-gray-800">Unggah Bukti Pembayaran</h2>

            <div class="mb-4">
                <label for="payment_receipt_image" class="block text-sm font-medium text-gray-700 mb-2">Pilih Foto Bukti
                    Transfer:</label>

                <input type="file" name="image" id="payment_receipt_image" accept="image/*" required
                    class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100" />

                @error('image')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Unggah Bukti Bayar
            </button>
        </form>>
    </div>
</body>

</html>
