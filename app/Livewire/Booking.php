<?php

namespace App\Livewire;

use App\Enums\BookingStatus;
use App\Enums\TransactionStatus;
use App\Models\Booking as BookingModel;
use App\Models\Transaction;
use App\Services\FonnteService;
use App\Support\PhoneNormalizer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Booking extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $filterStatus = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updateStatus(int $id, string $status, FonnteService $wa): void
    {
        $newStatus = BookingStatus::tryFrom($status);

        if (!$newStatus) {
            session()->flash('message', 'Status booking tidak valid.');
            return;
        }

        try {
            $result = DB::transaction(function () use ($id, $newStatus) {
                $booking = BookingModel::with(['room', 'user'])->lockForUpdate()->findOrFail($id);

                $currentStatus = $booking->status instanceof BookingStatus
                    ? $booking->status
                    : BookingStatus::from($booking->status);

                if ($currentStatus === $newStatus) {
                    return [
                        'message' => "Status booking #{$booking->booking_code} sudah {$newStatus->label()}.",
                        'phone' => null,
                        'wa_text' => null,
                    ];
                }

                $booking->status = $newStatus;
                $booking->save();

                $message = "Status booking #{$booking->booking_code} berhasil diubah menjadi {$newStatus->label()}.";

                if (in_array($newStatus, [BookingStatus::CONFIRMED, BookingStatus::CHECKIN], true)) {
                    $isTransactionExists = Transaction::where('booking_id', $booking->id)->exists();

                    if (!$isTransactionExists) {
                        $duration = max((int) $booking->duration, 0);
                        $baseDate = Carbon::parse($booking->date_in)->startOfDay();

                        for ($i = 0; $i < $duration; $i++) {
                            $dueDate = $baseDate->copy()->addMonths($i);

                            Transaction::create([
                                'booking_id' => $booking->id,
                                'user_id' => $booking->user_id,
                                'room_id' => $booking->room_id,
                                'payment_method' => 'transfer',
                                'payment_receipt' => null,
                                'date_pay' => null,
                                'due_date' => $dueDate->toDateString(),
                                'nominal' => (int) ($booking->price ?? 0),
                                'amount' => (int) ($booking->price ?? 0),
                                'status' => TransactionStatus::PENDING,
                            ]);
                        }

                        $message .= " Tagihan untuk {$duration} bulan berhasil di-generate.";
                    }

                    if ($booking->room) {
                        $booking->room->update(['status' => 'unavailable']);
                    }
                }

                if (in_array($newStatus, [BookingStatus::CANCELLED, BookingStatus::CHECKOUT], true)) {
                    if ($booking->room) {
                        $booking->room->update(['status' => 'available']);
                        $message .= " Kamar sekarang kembali tersedia.";
                    }

                    if ($newStatus === BookingStatus::CANCELLED) {
                        $deletedBills = Transaction::where('booking_id', $booking->id)
                            ->where('status', TransactionStatus::PENDING->value)
                            ->delete();

                        if ($deletedBills > 0) {
                            $message .= " Dan {$deletedBills} tagihan yang belum dibayar telah dihapus otomatis.";
                        }
                    }
                }

                return [
                    'message' => $message,
                    'phone' => PhoneNormalizer::normalize($booking->user?->phone),
                    'wa_text' => "Status booking {$booking->booking_code} sekarang {$newStatus->label()}.",
                ];
            });

            if ($result['phone'] && $result['wa_text']) {
                $wa->send($result['phone'], $result['wa_text']);
            }

            session()->flash('message', $result['message']);
        } catch (\Throwable $e) {
            report($e);
            session()->flash('message', 'Terjadi kesalahan saat memperbarui status booking.');
        }
    }

    public function render()
    {
        $user = auth()->user();
        $managedPropertyIds = $user->isCaretaker()
            ? $user->properties()->pluck('properties.id')->toArray()
            : null;

        $query = BookingModel::with(['user', 'room.property']);

        if ($managedPropertyIds) {
            $query->whereHas('room', function ($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('booking_code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($u) {
                        $u->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->filterStatus && BookingStatus::tryFrom($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        $bookings = $query->latest()->paginate(10);

        $statsQuery = BookingModel::query();

        if ($managedPropertyIds) {
            $statsQuery->whereHas('room', function ($q) use ($managedPropertyIds) {
                $q->whereIn('property_id', $managedPropertyIds);
            });
        }

        $stats = [
            BookingStatus::PENDING->value => (clone $statsQuery)->where('status', BookingStatus::PENDING->value)->count(),
            BookingStatus::CONFIRMED->value => (clone $statsQuery)->where('status', BookingStatus::CONFIRMED->value)->count(),
            BookingStatus::CHECKIN->value => (clone $statsQuery)->where('status', BookingStatus::CHECKIN->value)->count(),
            BookingStatus::CHECKOUT->value => (clone $statsQuery)->where('status', BookingStatus::CHECKOUT->value)->count(),
            BookingStatus::CANCELLED->value => (clone $statsQuery)->where('status', BookingStatus::CANCELLED->value)->count(),
        ];

        return view('livewire.booking', compact('bookings', 'stats'));
    }
}
