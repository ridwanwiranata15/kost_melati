<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Testimoni</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* --- Reset & Base Styles --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
        }

        /* --- Card Container --- */
        .testimonial-card {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* --- Header --- */
        .card-header h2 {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }

        .card-header p {
            color: #666;
            font-size: 14px;
            text-align: center;
            margin-bottom: 30px;
        }

        /* --- Form Elements --- */
        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
            font-size: 14px;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background-color: #f8fafc;
            font-size: 16px;
            color: #2d3748;
            resize: vertical;
            /* User hanya bisa resize ke bawah */
            outline: none;
            transition: all 0.3s ease;
        }

        textarea:focus {
            border-color: #667eea;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        textarea::placeholder {
            color: #a0aec0;
        }

        /* --- Button --- */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(118, 75, 162, 0.2);
        }

        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(118, 75, 162, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Hilangkan tampilan default radio button */
        .star-rating input[type="radio"] {
            display: none;
        }

        /* Container agar bintang berjejer */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            /* Penting: Dibalik agar hover effect bekerja benar */
            justify-content: flex-end;
            /* Ratakan kiri setelah di-reverse */
            gap: 5px;
        }

        /* Style dasar bintang (warna abu-abu) */
        .star-rating label {
            font-size: 30px;
            color: #e2e8f0;
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
        }

        /* Ubah warna jadi kuning saat di-hover */
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #f6ad55;
            /* Warna orange muda saat hover */
        }

        /* Ubah warna jadi emas saat dipilih (checked) */
        .star-rating input[type="radio"]:checked~label {
            color: #ecc94b;
            /* Warna emas */
        }
    </style>
</head>

<body>

    <div class="testimonial-card">
        <div class="card-header">
            <h2>Bagikan Pengalaman Anda</h2>
            <p>Masukan Anda sangat berarti bagi perkembangan kami.</p>
        </div>

        <form action="{{ route('customer.testimonial.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Beri Rating</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required />
                    <label for="star5" title="Sempurna">★</label>

                    <input type="radio" id="star4" name="rating" value="4" />
                    <label for="star4" title="Sangat Bagus">★</label>

                    <input type="radio" id="star3" name="rating" value="3" />
                    <label for="star3" title="Bagus">★</label>

                    <input type="radio" id="star2" name="rating" value="2" />
                    <label for="star2" title="Cukup">★</label>

                    <input type="radio" id="star1" name="rating" value="1" />
                    <label for="star1" title="Buruk">★</label>
                </div>
                @error('rating')
                    <div style="color: red; font-size: 12px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="testimonial">Pesan Testimoni</label>
                <textarea id="testimonial" name="testimonial" placeholder="Ceritakan pengalaman Anda..."
                    style="{{ $errors->has('testimonial') ? 'border-color: red;' : '' }}" required></textarea>
                @error('testimonial')
                    <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Kirim Testimoni</button>
        </form>
    </div>

</body>

</html>
