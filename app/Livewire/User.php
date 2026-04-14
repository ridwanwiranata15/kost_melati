<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Livewire\Component;
use App\Models\User as UserModel;
use Livewire\WithPagination;

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
        $query = UserModel::where('role', UserRole::CUSTOMER->value);

        // 2. Logic Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        // 3. Logic Filter Status
        if ($this->filterStatus && UserStatus::tryFrom($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        // Ambil data untuk tabel
        $users = $query->latest()->paginate(10);

        $totalActive = UserModel::where('role', UserRole::CUSTOMER->value)
            ->where('status', UserStatus::ACTIVE->value)
            ->count();

        $totalPending = UserModel::where('role', UserRole::CUSTOMER->value)
            ->where('status', UserStatus::PENDING->value)
            ->count();

        $totalRejected = UserModel::where('role', UserRole::CUSTOMER->value)
            ->where('status', UserStatus::REJECTED->value)
            ->count();

        return view('livewire.user', [
            'users' => $users,
            'totalActive' => $totalActive,
            'totalPending' => $totalPending,
            'totalRejected' => $totalRejected,
        ]);
    }
}
