<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class DetailUser extends Component
{
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $role;
    public $status;
    public $photo;

    public function mount($id)
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->status = $user->status;
        $this->photo = $user->photo;
    }

    public function updateStatus()
    {
        User::find($this->userId)->update([
            'status' => $this->status
        ]);

        session()->flash('message', 'Status berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.detail-user');
    }
}
