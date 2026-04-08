<?php

namespace App\Livewire;

use App\Models\Property as ModelsProperty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Property extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name;
    public $location;
    public $address;
    public $description;
    public $image;
    public $oldImage;
    public $property_id;
    public $search = '';
    public $isCreateModalOpen = false;
    public $isEditModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'address' => 'required|string',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'location', 'address', 'description', 'image']);
        $this->isCreateModalOpen = true;
    }

    public function closeCreateModal()
    {
        $this->isCreateModalOpen = false;
        $this->reset(['image']);
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('properties', 'public');
        }

        ModelsProperty::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'location' => $this->location,
            'address' => $this->address,
            'description' => $this->description,
            'image' => $imagePath,
        ]);

        $this->closeCreateModal();
        session()->flash('message', 'Properti berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $property = ModelsProperty::findOrFail($id);
        $this->property_id = $property->id;
        $this->name = $property->name;
        $this->location = $property->location;
        $this->address = $property->address;
        $this->description = $property->description;
        $this->oldImage = $property->image;
        $this->image = null;

        $this->isEditModalOpen = true;
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->reset(['image', 'oldImage']);
    }

    public function update()
    {
        $this->validate();

        $property = ModelsProperty::findOrFail($this->property_id);

        $imagePath = $property->image;
        if ($this->image) {
            if ($property->image && Storage::disk('public')->exists($property->image)) {
                Storage::disk('public')->delete($property->image);
            }
            $imagePath = $this->image->store('properties', 'public');
        }

        $property->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'location' => $this->location,
            'address' => $this->address,
            'description' => $this->description,
            'image' => $imagePath,
        ]);

        $this->closeEditModal();
        session()->flash('message', 'Properti berhasil diperbarui.');
    }

    public function delete($id)
    {
        $property = ModelsProperty::findOrFail($id);
        if ($property->image && Storage::disk('public')->exists($property->image)) {
            Storage::disk('public')->delete($property->image);
        }
        $property->delete();
        session()->flash('message', 'Properti berhasil dihapus.');
    }

    public function render()
    {
        $properties = ModelsProperty::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('location', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.property', [
            'properties' => $properties,
        ]);
    }
}
