<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\FonnteService;
use App\Support\PhoneNormalizer;
use App\Support\WhatsAppMessageBuilder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPaymentReminderH7 extends Command
{
    protected $signature = 'notifications:payment-h7 {--date=} {--days=7}';
    protected $description = 'Kirim reminder pembayaran via WhatsApp berdasarkan due date';

    public function handle(FonnteService $wa): int
    {
        $targetDate = $this->option('date')
            ? Carbon::parse($this->option('date'), 'Asia/Jakarta')->toDateString()
            : Carbon::today('Asia/Jakarta')->addDays((int) $this->option('days'))->toDateString();

        $this->info("Target date: {$targetDate}");

        $this->info('Count pending: ' . Transaction::where('status', \App\Enums\TransactionStatus::PENDING->value)->count());
        $this->info('Count due_date match: ' . Transaction::where('due_date', $targetDate)->count());
        $this->info('Count h7 null: ' . Transaction::whereNull('h7_reminded_at')->count());
        $this->info('Count final match: ' . Transaction::where('status', \App\Enums\TransactionStatus::PENDING->value)
            ->where('due_date', $targetDate)
            ->whereNull('h7_reminded_at')
            ->count());

        $transactions = Transaction::with(['user', 'booking.room'])
            ->where('status', \App\Enums\TransactionStatus::PENDING->value)
            ->where('due_date', $targetDate)
            ->whereNull('h7_reminded_at')
            ->get();

        if ($transactions->isEmpty()) {
            $this->info("Tidak ada tagihan pending untuk target tanggal {$targetDate}.");
            return self::SUCCESS;
        }

        foreach ($transactions as $trx) {
            $customerPhone = PhoneNormalizer::normalize($trx->user?->phone);
            $parentPhone = PhoneNormalizer::normalize($trx->user?->parents_phone);
            $internalTargets = config('services.fonnte.admin_targets', []);

            if ($customerPhone) {
                $wa->send(
                    $customerPhone,
                    WhatsAppMessageBuilder::reminderCustomer($trx)
                );
            }

            if ($parentPhone) {
                $wa->send(
                    $parentPhone,
                    WhatsAppMessageBuilder::reminderParent($trx)
                );
            }

            if (!empty($internalTargets)) {
                $wa->send(
                    $internalTargets,
                    WhatsAppMessageBuilder::reminderOwner($trx)
                );
            }

            $trx->update([
                'h7_reminded_at' => now(),
            ]);

            $this->info("Reminder terkirim untuk transaksi ID {$trx->id}.");
        }

        return self::SUCCESS;
    }
}
