<?php

namespace App\Support;

use App\Enums\BookingStatus;
use App\Enums\TransactionStatus;
use App\Enums\UserStatus;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\User;

class WhatsAppMessageBuilder
{
    protected static function appUrl(): string
    {
        return rtrim(config('app.url'), '/');
    }

    protected static function profileUrl(): string
    {
        return self::appUrl() . '/profile';
    }

    protected static function orderUrl(): string
    {
        return self::appUrl() . '/my-order';
    }

    protected static function invoiceUrl(Transaction $trx): string
    {
        return self::appUrl() . '/invoice/' . $trx->id;
    }

    public static function bookingStatus(Booking $booking, BookingStatus $status): string
    {
        $name = $booking->user?->name ?? 'Pelanggan';
        $room = $booking->room?->room_number ?? '-';
        $bookingCode = $booking->booking_code ?? '-';
        $dateIn = $booking->date_in ? \Carbon\Carbon::parse($booking->date_in)->format('d-m-Y') : '-';
        $duration = (int) ($booking->duration ?? 0);

        return match ($status) {
            BookingStatus::CONFIRMED => "✅ Booking Berhasil Dikonfirmasi\n\n"
                . "Halo, {$name}.\n\n"
                . "Booking Anda telah berhasil dikonfirmasi oleh admin.\n\n"
                . "Ringkasan booking:\n"
                . "• Kode booking: {$bookingCode}\n"
                . "• Nomor kamar: {$room}\n"
                . "• Tanggal mulai: {$dateIn}\n"
                . "• Durasi sewa: {$duration} bulan\n\n"
                . "Silakan cek detail sewa dan tagihan Anda melalui:\n"
                . self::orderUrl() . "\n\n"
                . "Terima kasih telah menggunakan layanan Kost El Sholeha.\n"
                . "Admin Kost El Sholeha",

            BookingStatus::CHECKIN => "🏠 Status Hunian Aktif\n\n"
                . "Halo, {$name}.\n\n"
                . "Status booking Anda telah diperbarui menjadi check-in.\n\n"
                . "Ringkasan booking:\n"
                . "• Kode booking: {$bookingCode}\n"
                . "• Nomor kamar: {$room}\n"
                . "• Tanggal mulai: {$dateIn}\n\n"
                . "Silakan akses informasi sewa Anda melalui:\n"
                . self::orderUrl() . "\n\n"
                . "Semoga nyaman selama tinggal di Kost El Sholeha.\n"
                . "Admin Kost El Sholeha",

            BookingStatus::CANCELLED => "⚠️ Informasi Status Booking\n\n"
                . "Halo, {$name}.\n\n"
                . "Mohon maaf, booking Anda saat ini berstatus dibatalkan.\n\n"
                . "Ringkasan booking:\n"
                . "• Kode booking: {$bookingCode}\n"
                . "• Nomor kamar: {$room}\n\n"
                . "Apabila Anda memerlukan bantuan lebih lanjut, silakan cek akun Anda atau hubungi admin melalui website:\n"
                . self::profileUrl() . "\n\n"
                . "Terima kasih.\n"
                . "Admin Kost El Sholeha",

            BookingStatus::CHECKOUT => "ℹ️ Status Booking Diperbarui\n\n"
                . "Halo, {$name}.\n\n"
                . "Status booking Anda telah diperbarui menjadi checkout.\n\n"
                . "Ringkasan booking:\n"
                . "• Kode booking: {$bookingCode}\n"
                . "• Nomor kamar: {$room}\n\n"
                . "Terima kasih telah mempercayakan hunian Anda kepada Kost El Sholeha.\n"
                . self::profileUrl() . "\n\n"
                . "Admin Kost El Sholeha",

            default => "ℹ️ Informasi Booking\n\n"
                . "Halo, {$name}.\n\n"
                . "Status booking Anda saat ini: {$status->label()}.\n\n"
                . "• Kode booking: {$bookingCode}\n"
                . "• Nomor kamar: {$room}\n\n"
                . "Detail selengkapnya dapat dilihat melalui:\n"
                . self::orderUrl() . "\n\n"
                . "Admin Kost El Sholeha",
        };
    }

    public static function userStatus(User $user, UserStatus $status): string
    {
        $name = $user->name ?? 'Pelanggan';

        return match ($status) {
            UserStatus::ACTIVE => "✅ Akun Berhasil Diaktifkan\n\n"
                . "Halo, {$name}.\n\n"
                . "Akun Anda telah berhasil diaktifkan dan kini dapat digunakan untuk mengakses layanan Kost El Sholeha.\n\n"
                . "Silakan login dan cek profil Anda melalui:\n"
                . self::profileUrl() . "\n\n"
                . "Terima kasih.\n"
                . "Admin Kost El Sholeha",

            UserStatus::REJECTED => "⚠️ Informasi Status Akun\n\n"
                . "Halo, {$name}.\n\n"
                . "Mohon maaf, pengajuan akun Anda saat ini belum dapat disetujui.\n\n"
                . "Silakan periksa kembali data Anda melalui website berikut:\n"
                . self::profileUrl() . "\n\n"
                . "Apabila memerlukan bantuan, silakan hubungi admin.\n\n"
                . "Terima kasih.\n"
                . "Admin Kost El Sholeha",

            default => "ℹ️ Informasi Status Akun\n\n"
                . "Halo, {$name}.\n\n"
                . "Status akun Anda saat ini: {$status->label()}.\n\n"
                . "Silakan cek detail akun Anda melalui:\n"
                . self::profileUrl() . "\n\n"
                . "Admin Kost El Sholeha",
        };
    }

    public static function paymentStatus(Transaction $trx, TransactionStatus $status): string
    {
        $name = $trx->user?->name ?? 'Pelanggan';
        $nominal = number_format((int) $trx->nominal, 0, ',', '.');
        $bookingCode = $trx->booking?->booking_code ?? '-';
        $room = $trx->booking?->room?->room_number ?? '-';
        $datePay = $trx->date_pay ? \Carbon\Carbon::parse($trx->date_pay)->format('d-m-Y') : '-';

        return match ($status) {
            TransactionStatus::CONFIRMED => "✅ Pembayaran Berhasil Diverifikasi\n\n"
                . "Halo, {$name}.\n\n"
                . "Pembayaran Anda telah berhasil diverifikasi oleh admin.\n\n"
                . "Ringkasan pembayaran:\n"
                . "• Kode booking: {$bookingCode}\n"
                . "• Nomor kamar: {$room}\n"
                . "• Nominal: Rp {$nominal}\n"
                . "• Tanggal bayar: {$datePay}\n\n"
                . "Invoice dapat diakses melalui:\n"
                . self::invoiceUrl($trx) . "\n\n"
                . "Terima kasih.\n"
                . "Admin Kost El Sholeha",

            TransactionStatus::REJECTED => "⚠️ Pembayaran Belum Dapat Diverifikasi\n\n"
                . "Halo, {$name}.\n\n"
                . "Mohon maaf, pembayaran Anda belum dapat kami verifikasi.\n\n"
                . "Ringkasan pembayaran:\n"
                . "• Kode booking: {$bookingCode}\n"
                . "• Nomor kamar: {$room}\n"
                . "• Nominal: Rp {$nominal}\n\n"
                . "Silakan unggah ulang bukti pembayaran yang lebih jelas melalui:\n"
                . self::orderUrl() . "\n\n"
                . "Terima kasih.\n"
                . "Admin Kost El Sholeha",

            default => "ℹ️ Informasi Pembayaran\n\n"
                . "Halo, {$name}.\n\n"
                . "Status pembayaran Anda saat ini: {$status->label()}.\n\n"
                . "Silakan cek detail tagihan Anda melalui:\n"
                . self::orderUrl() . "\n\n"
                . "Admin Kost El Sholeha",
        };
    }

    public static function reminderCustomer(Transaction $trx): string
    {
        $name = $trx->user?->name ?? 'Pelanggan';
        $room = $trx->booking?->room?->room_number ?? '-';
        $nominal = number_format((int) $trx->nominal, 0, ',', '.');
        $bookingCode = $trx->booking?->booking_code ?? '-';
        $dueDate = $trx->due_date ? \Carbon\Carbon::parse($trx->due_date)->format('d-m-Y') : '-';

        return "⏰ Pengingat Pembayaran Sewa Kost\n\n"
            . "Halo, {$name}.\n\n"
            . "Kami mengingatkan bahwa tagihan sewa kost Anda akan jatuh tempo dalam 7 hari.\n\n"
            . "Ringkasan tagihan:\n"
            . "• Kode booking: {$bookingCode}\n"
            . "• Nomor kamar: {$room}\n"
            . "• Jatuh tempo: {$dueDate}\n"
            . "• Nominal: Rp {$nominal}\n\n"
            . "Silakan cek detail tagihan dan lakukan pembayaran melalui:\n"
            . self::orderUrl() . "\n\n"
            . "Jika Anda sudah membayar, abaikan pesan ini dan tunggu verifikasi admin.\n\n"
            . "Terima kasih.\n"
            . "Admin Kost El Sholeha";
    }

    public static function reminderParent(Transaction $trx): string
    {
        $customer = $trx->user?->name ?? 'Penyewa';
        $room = $trx->booking?->room?->room_number ?? '-';
        $nominal = number_format((int) $trx->nominal, 0, ',', '.');
        $bookingCode = $trx->booking?->booking_code ?? '-';
        $dueDate = $trx->due_date ? \Carbon\Carbon::parse($trx->due_date)->format('d-m-Y') : '-';

        return "📌 Informasi Pengingat Pembayaran Kost\n\n"
            . "Halo Bapak/Ibu.\n\n"
            . "Kami menginformasikan bahwa pembayaran sewa kost untuk:\n"
            . "• Nama penghuni: {$customer}\n"
            . "• Nomor kamar: {$room}\n\n"
            . "akan jatuh tempo dalam 7 hari dengan rincian:\n"
            . "• Kode booking: {$bookingCode}\n"
            . "• Jatuh tempo: {$dueDate}\n"
            . "• Nominal: Rp {$nominal}\n\n"
            . "Informasi lebih lanjut dapat diakses melalui website resmi:\n"
            . self::appUrl() . "\n\n"
            . "Terima kasih.\n"
            . "Admin Kost El Sholeha";
    }

    public static function reminderOwner(Transaction $trx): string
    {
        $customer = $trx->user?->name ?? 'Penyewa';
        $room = $trx->booking?->room?->room_number ?? '-';
        $nominal = number_format((int) $trx->nominal, 0, ',', '.');
        $bookingCode = $trx->booking?->booking_code ?? '-';
        $dueDate = $trx->due_date ? \Carbon\Carbon::parse($trx->due_date)->format('d-m-Y') : '-';

        return "📌 Reminder H-7 Pembayaran\n\n"
            . "Detail tagihan yang perlu dimonitor:\n"
            . "• Penyewa: {$customer}\n"
            . "• Nomor kamar: {$room}\n"
            . "• Kode booking: {$bookingCode}\n"
            . "• Jatuh tempo: {$dueDate}\n"
            . "• Nominal: Rp {$nominal}\n\n"
            . "Monitoring data dapat dilakukan melalui:\n"
            . self::appUrl() . "\n\n"
            . "Admin Kost El Sholeha";
    }
}
