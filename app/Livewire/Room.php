<?php

namespace App\Livewire;

use App\Models\Room as ModelsRoom;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Room extends Component
{
    use WithFileUploads;

    public $number;
    public $name;
    public $status = ''; // Default empty string for select
    public $facility;
    public $image;
    public $description;

    // Define validation rules
    protected $rules = [
        'number' => 'required|unique:rooms,room_number',
        'name' => 'required|string|max:255',
        'status' => 'required|in:tersedia,terisi,perbaikan',
        'facility' => 'required|string',
        'image' => 'nullable|image|max:2048', // 2MB Max
        'description' => 'nullable|string',
    ];

    public function save()
    {
        // 1. Validate Input
        $validatedData = $this->validate();

        // 2. Handle Image Upload
        if ($this->image) {
            // Stores in storage/app/public/room-images
            $imagePath = $this->image->store('room-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // 3. Create Record
        ModelsRoom::create([
            "room_number" => $this->number,
            "name"  => $this->name,
            "status"  => $this->status,
            "facility"  => $this->facility,
            "image"  => $validatedData['image'] ?? null,
            "description"  => $this->description
        ]);

        // 4. Reset Form and Close Modal
        $this->reset(['number', 'name', 'status', 'facility', 'image', 'description']);

        // Dispatch event to close modal (requires simple JS listener)
        $this->dispatch('room-saved');

        session()->flash('message', 'Kamar berhasil ditambahkan!');
    }
    public function delete($id)
{
    $room = ModelsRoom::findOrFail($id);

    // hapus image jika ada
    if ($room->image && Storage::disk('public')->exists($room->image)) {
        Storage::disk('public')->delete($room->image);
    }

    $room->delete();

    session()->flash('success', 'Kamar berhasil dihapus ✅');
}

    public function render()
    {
        // Fetch data ordered by newest
        $rooms = ModelsRoom::latest()->get();

        return view('livewire.room', [
            'rooms' => $rooms
        ]);
    }
}
