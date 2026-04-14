<?php

namespace App\Livewire;

use App\Enums\TransactionStatus;
use App\Enums\UserStatus;
use App\Models\Booking;
use App\Models\Transaction;
use App\Services\FonnteService;
use App\Support\PhoneNormalizer;
use App\Support\WhatsAppMessageBuilder;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;
// use Illuminate\Support\Facades\Auth; // Tidak perlu Auth jika melihat detail user lain

class DetailUser extends Component
{
    use WithFileUploads;
    public $showEditModal = false;
    public $editStatus;
    public $selectedTransactionId;
    public $editAmount;
    public $editProof;
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $role;
    public $status;
    public $statusPayment;
    public $photo;

    // New profile fields
    public $university;
    public $parentsName;
    public $parentsPhone;
    public $ktpUrl;

    // Booking & transactions
    public $booking;
    public $transactions;

    public function mount($id)
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role?->value;
        $this->status = $user->status?->value;
        $this->photo = $user->photo;

        // New fields
        $this->university = $user->university;
        $this->parentsName = $user->parents_name;
        $this->parentsPhone = $user->parents_phone;

        // Build secure KTP URL (served via auth-protected route)
        if ($user->ktp_photo) {
            $this->ktpUrl = route('ktp.photo', basename($user->ktp_photo));
        }

        $this->booking = Booking::with(['transactions', 'room'])
            ->where('user_id', $this->userId)
            ->latest()
            ->first();

        $this->transactions = $this->booking ? $this->booking->transactions : collect([]);
    }

    public function openEditModal($id)
    {
        $transaction = Transaction::findOrFail($id);

        $this->selectedTransactionId = $transaction->id;
        $this->editAmount = $transaction->nominal;
        $this->editStatus = $transaction->status?->value;

        $this->resetValidation();
        $this->showEditModal = true;
    }

    // Function Tutup Modal
    public function closeEditModal()
    {
        $this->showEditModal = false;

        $this->reset([
            'selectedTransactionId',
            'editAmount',
            'editProof',
            'editStatus'
        ]);

        $this->resetValidation();
    }

    // Function Simpan Data
    public function saveTransaction(FonnteService $wa)
    {
        $this->validate([
            'editAmount' => 'required|numeric|min:0',
            'editStatus' => ['required', new Enum(TransactionStatus::class)],
            'editProof' => 'nullable|image|max:2048',
        ]);

        $transaction = Transaction::with(['user', 'booking.room'])->findOrFail($this->selectedTransactionId);

        $transaction->update([
            'nominal' => (int) $this->editAmount,
            'status' => $this->editStatus,
        ]);

        if ($this->editProof) {
            $path = $this->editProof->store('payment_receipts', 'public');

            $transaction->update([
                'payment_receipt' => $path,
            ]);
        }

        $phone = PhoneNormalizer::normalize($transaction->user?->phone);
        $statusEnum = TransactionStatus::from($this->editStatus);

        if ($phone && in_array($statusEnum, [TransactionStatus::CONFIRMED, TransactionStatus::REJECTED], true)) {
            $message = WhatsAppMessageBuilder::paymentStatus($transaction, $statusEnum);
            $wa->send($phone, $message);
        }

        $this->transactions = $this->booking
            ? $this->booking->transactions()->latest()->get()
            : collect();

        session()->flash('message', 'Data transaksi berhasil diperbarui.');

        $this->closeEditModal();
    }

    public function updateStatus(FonnteService $wa)
    {
        $this->validate([
            'status' => ['required', new Enum(UserStatus::class)],
        ]);

        $user = User::findOrFail($this->userId);

        $user->update([
            'status' => $this->status,
        ]);
        $phone = PhoneNormalizer::normalize($user->phone);

        if ($phone) {
            $statusEnum = UserStatus::from($this->status);
            $message = WhatsAppMessageBuilder::userStatus($user, $statusEnum);
            $wa->send($phone, $message);
        }

        session()->flash('message', 'Status berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.detail-user');
    }
}
