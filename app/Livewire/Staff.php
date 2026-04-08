<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Staff extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $password;
    public $role = 'caretaker';
    public $selectedProperties = [];
    public $staff_id;
    public $search = '';
    public $isCreateModalOpen = false;
    public $isEditModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|in:admin,caretaker',
        'selectedProperties' => 'required_if:role,caretaker|array',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'role', 'selectedProperties']);
        $this->isCreateModalOpen = true;
    }

    public function closeCreateModal()
    {
        $this->isCreateModalOpen = false;
    }

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password ?? 'password123'),
            'role' => $this->role,
            'status' => 'active',
        ]);

        if ($this->role === 'caretaker') {
            $user->properties()->sync($this->selectedProperties);
        }

        $this->closeCreateModal();
        session()->flash('message', 'Staff berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->staff_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->selectedProperties = $user->properties->pluck('id')->toArray();

        $this->isEditModalOpen = true;
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->reset(['password']);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->staff_id,
            'role' => 'required|in:admin,caretaker',
            'selectedProperties' => 'required_if:role,caretaker|array',
        ]);

        $user = User::findOrFail($this->staff_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        if ($this->password) {
            $user->update(['password' => Hash::make($this->password)]);
        }

        if ($this->role === 'caretaker') {
            $user->properties()->sync($this->selectedProperties);
        } else {
            $user->properties()->detach();
        }

        $this->closeEditModal();
        session()->flash('message', 'Staff berhasil diperbarui.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'Staff berhasil dihapus.');
    }

    public function render()
    {
        $staff = User::whereIn('role', ['admin', 'caretaker'])
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->with('properties')
            ->latest()
            ->paginate(10);

        return view('livewire.staff', [
            'staff' => $staff,
            'properties' => Property::all(),
        ]);
    }
}
