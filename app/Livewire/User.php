<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as UserModel;

class User extends Component
{
    public function render()
    {
        $users = UserModel::where('role', 'customer')->get();
        return view('livewire.user', compact('users'));
    }
}
