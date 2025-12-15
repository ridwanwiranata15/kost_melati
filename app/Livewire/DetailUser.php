<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Transaction;
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
    public $editProof; // Untuk file gambar baru
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $role;
    public $status;
    public $statusPayment;
    public $photo;

    // TAMBAHKAN PROPERTY INI AGAR BISA DIBACA DI BLADE
    public $booking;
    public $transactions;

    public function mount($id)
    {
        // 1. Ambil data User berdasarkan ID yang dikirim (bukan Auth::id)
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->status = $user->status;
        $this->photo = $user->photo;

        // 2. Cari Booking milik User Tersebut ($this->userId)
        // JANGAN pakai Auth::id() karena itu ID Admin yang sedang login
        $this->booking = Booking::with(['transactions', 'room'])
            ->where('user_id', $this->userId)
            ->latest()
            ->first();

        // 3. Masukkan ke public property $transactions
        $this->transactions = $this->booking ? $this->booking->transactions : collect([]);
    }

    public function openEditModal($id)
    {
        $transaction = \App\Models\Transaction::find($id); // Sesuaikan nama Model

        if ($transaction) {
            $this->selectedTransactionId = $transaction->id;
            $this->editAmount = $transaction->nominal;
            $this->editStatus = $transaction->status; // Sesuaikan nama kolom harga di DB
            $this->showEditModal = true;
        }
    }

    // Function Tutup Modal
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['selectedTransactionId', 'editAmount', 'editProof']);
    }

    // Function Simpan Data
    public function saveTransaction()
    {
        $this->validate([
            'editAmount' => 'required|numeric',
            'editProof' => 'nullable|image|max:2048', // Validasi gambar (opsional)
        ]);

        $transaction = \App\Models\Transaction::find($this->selectedTransactionId);

        if ($transaction) {
            // Update Harga
            $transaction->nominal = $this->editAmount;
            $transaction->status = $this->editStatus;

            // Update Gambar (Jika ada upload baru)
            if ($this->editProof) {
                // Hapus gambar lama jika perlu (opsional)
                // Storage::delete('public/' . $transaction->payment_receipt);

                // Simpan gambar baru
                $path = $this->editProof->store('payment_receipts', 'public');
                $transaction->payment_receipt = $path;
            }


            $transaction->save();

            // Beri notifikasi sukses (opsional)
            session()->flash('message', 'Data transaksi berhasil diperbarui.');
        }

        $this->closeEditModal();
    }
    public function updateStatus()
    {
        User::find($this->userId)->update([
            'status' => $this->status
        ]);

        session()->flash('message', 'Status berhasil diperbarui!');
    }
    // app/Livewire/DetailUser.php

    public function updateStatusTransaction($id, $status)
    {
        // 1. Cari transaksi
        $transaction = \App\Models\Transaction::findOrFail($id);

        // 2. Update dengan status yang dikirim dari view
        $transaction->update([
            'status' => $status
        ]);

        // 3. (Opsional) Refresh data transaksi agar tampilan tabel terupdate otomatis
        // Karena kita pakai eager loading di mount(), kita perlu refresh manual collectionnya
        // Atau simpelnya: Livewire akan me-render ulang, tapi datanya harus sinkron.
        // Jika tidak refresh otomatis, tambahkan logic refresh di sini atau biarkan render ulang.

        session()->flash('message', 'Status transaksi berhasil diperbarui!');
    }

    public function render()
    {
        // Data $booking dan $transactions otomatis terkirim karena sudah jadi public property
        return view('livewire.detail-user');
    }
}
