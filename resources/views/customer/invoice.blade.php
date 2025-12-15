<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi #{{ $transaksi->id }}</title>
    <style>
        /* CSS Reset */
        body {
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            padding: 20px;
        }

        /* Helper Classes */
        .w-100 { width: 100%; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .text-center { text-align: center; }
        .valign-top { vertical-align: top; }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .hotel-name {
            font-size: 24px;
            color: blue;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        /* Layout Utama 2 Kolom */
        .main-layout {
            width: 100%;
            border-collapse: collapse;
        }

        /* Kolom Kiri (Info) */
        .col-left {
            width: 55%;
            padding-right: 20px;
            border-right: 1px solid #ccc;
        }

        /* Kolom Kanan (Uang) */
        .col-right {
            width: 45%;
            padding-left: 20px;
        }

        /* Tabel Data di dalam Kolom */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .label { width: 100px; color: #555; }

        /* Tabel Keuangan */
        .money-table {
            width: 100%;
            border-collapse: collapse;
        }
        .money-table td {
            padding: 5px 0;
        }
        .m-lbl { width: 50%; }
        .m-sep { width: 5%; text-align: right; }
        .m-val { width: 45%; text-align: right; font-weight: bold; }

        /* Highlight Row */
        .highlight-row td {
            background-color: #f0f0f0;
            font-size: 16px;
            padding-top: 10px;
            padding-bottom: 10px;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            background: #eee;
            border: 1px solid #ddd;
            font-size: 11px;
            font-weight: bold;
        }
        .badge-success { background: #d4edda; color: #155724; border-color: #c3e6cb; }
        .badge-warning { background: #fff3cd; color: #856404; border-color: #ffeeba; }

        .footer {
            margin-top: 50px;
            width: 100%;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tbody>
            <tr>
                <td width="60" class="valign-top">
                    <h1 style="font-size:40px; margin:0;">👑</h1>
                </td>
                <td>
                    <h1 class="hotel-name">{{ $providerName }}</h1>
                    <div>Kwitansi Pembayaran Kost & Penginapan</div>
                </td>
                <td class="text-right valign-top">
                    <span style="font-size:11px; color:#555;">No. Kwitansi</span><br>
                    <span style="font-size:16px; font-weight:bold;">#{{ $transaksi->id }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="main-layout">
        <tbody>
            <tr>
                <td class="col-left valign-top">
                    <div class="text-bold" style="margin-bottom: 5px; text-decoration: underline;">Data Tamu & Kamar</div>

                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td class="label">Nama Tamu</td>
                                <td>: {{ $booking->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="label">Email</td>
                                <td>: {{ $booking->user->email }}</td>
                            </tr>
                            <tr>
                                <td class="label">No. HP</td>
                                <td>: {{ $booking->user->phone ?? '-' }}</td>
                            </tr>
                            <tr><td colspan="2" style="height: 10px;"></td></tr>
                            <tr>
                                <td class="label">Nomor Kamar</td>
                                <td>: <span style="font-size: 14px; font-weight:bold;">{{ $kamar->room_number }}</span></td>
                            </tr>
                            <tr>
                                <td class="label">Tanggal Bayar</td>
                                <td>: {{ \Carbon\Carbon::parse($transaksi->date_pay)->format('d F Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <td class="col-right valign-top">
                    <div class="text-bold" style="margin-bottom: 5px; text-decoration: underline;">Rincian Pembayaran</div>

                    <table class="money-table">
                        <tbody>
                            <tr>
                                <td class="m-lbl">Harga Sewa</td>
                                <td class="m-sep">: Rp</td>
                                <td class="m-val">{{ number_format($hargaKamar, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="m-lbl">Lama Inap</td>
                                <td class="m-sep">: </td>
                                <td class="m-val">{{ $lamaInap }} Bulan</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height: 15px;"></td>
                            </tr>

                            <tr class="highlight-row">
                                <td class="m-lbl">Tagihan Bulan Ini</td>
                                <td class="m-sep">: Rp</td>
                                <td class="m-val">{{ number_format($tagihanBulanIni, 0, ',', '.') }}</td>
                            </tr>

                            <tr>
                                <td colspan="3" style="height: 15px;"></td>
                            </tr>

                            <tr>
                                <td class="m-lbl">Status</td>
                                <td class="m-sep">: </td>
                                <td class="m-val">
                                    @if($transaksi->status == 'confirmed')
                                        <span class="badge badge-success">Sudah bayar</span>
                                    @elseif($transaksi->status == 'pending')
                                        <span class="badge badge-warning">PENDING</span>
                                    @else
                                        <span class="badge">{{ strtoupper($transaksi->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <table width="100%">
            <tbody>
                <tr>
                    <td width="50%"></td>
                    <td width="50%" class="text-center">
                        <p>Bandar Lampung, {{ now()->format('d F Y') }}</p>
                        <p>Admin,</p>
                        <br><br><br>
                        <p>( ................................. )</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
