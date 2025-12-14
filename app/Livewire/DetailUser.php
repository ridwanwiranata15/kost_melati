<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Transaction;
use Livewire\Component;
use App\Models\User;
// use Illuminate\Support\Facades\Auth; // Tidak perlu Auth jika melihat detail user lain

class DetailUser extends Component
{
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
