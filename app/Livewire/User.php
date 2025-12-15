<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as UserModel;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class User extends Component
{
    use WithPagination;
    public $search = '';
    public $filterStatus = '';

    // Reset pagination saat search/filter berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }
public function render()
    {
        // 1. Base Query: Hanya ambil user dengan role 'customer'
        // Jika Anda menggunakan Spatie Permission, ganti dengan: User::role('customer')
        $query = UserModel::where('role', 'customer');

        // 2. Logic Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        // 3. Logic Filter Status
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Ambil data untuk tabel
        $users = $query->latest()->paginate(10);

        // 4. Hitung Statistik untuk Cards (Hanya hitung yang rolenya customer)
        $totalActive = UserModel::where('role', 'customer')
                            ->where(function($q) {
                                $q->where('status', 'active')
                                  ->orWhere('status', 'aktif');
                            })->count();

        $totalPending = UserModel::where('role', 'customer')
                            ->where('status', 'pending')
                            ->count();

        $totalRejected = UserModel::where('role', 'customer')
                             ->whereIn('status', ['rejected', 'inactive', 'ditolak'])
                             ->count();

        return view('livewire.user', [
            'users' => $users,
            'totalActive' => $totalActive,
            'totalPending' => $totalPending,
            'totalRejected' => $totalRejected,
        ]);
    }
}
