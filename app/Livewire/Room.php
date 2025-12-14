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
    public $room_id;


    // Define validation rules
    protected $rules = [
        'number' => 'required|unique:rooms,room_number',
        'name' => 'required|string|max:255',
        'status' => 'required|in:available,unavailable,repair',
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
    public $oldImage; // Properti baru untuk nyimpan path foto lama

    public function edit($id)
    {
        $room = ModelsRoom::find($id);

        // Isi data ke form
        $this->room_id = $room->id;
        $this->number = $room->room_number;
        $this->name = $room->name;
        $this->status = $room->status;
        $this->facility = $room->facility;
        $this->description = $room->description;

        // Simpan gambar lama untuk preview
        $this->oldImage = $room->image;
        $this->image = null; // Reset input file baru

        // Buka Modal Edit via JS Dispatch
        $this->dispatch('open-modal-edit');
    }
    public function update()
    {
        // Validasi Input
        $validatedData = $this->validate([
            // unique:rooms,room_number,ID -> Cek unik tapi abaikan ID yang sedang diedit
            'number' => 'required|unique:rooms,room_number,' . $this->room_id,
            'name' => 'required',
            'status' => 'required|in:available,unavailable,repair',
            'facility' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ], [
            'number.required' => 'Nomor kamar wajib diisi.',
            'number.unique' => 'Nomor kamar sudah digunakan.',
            'image.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // Ambil data kamar yang mau diupdate
        $room = ModelsRoom::findOrFail($this->room_id);

        // Logic Upload Gambar Baru
        if ($this->image) {
            // 1. Hapus gambar lama jika ada dan file-nya beneran ada di storage
            if ($room->image && Storage::exists('public/' . $room->image)) {
                Storage::delete('public/' . $room->image);
            }

            // 2. Upload gambar baru & ambil path-nya
            $imagePath = $this->image->store('rooms', 'public');
        } else {
            // Jika tidak upload gambar baru, pakai path gambar lama
            $imagePath = $room->image;
        }

        // Update Database
        $room->update([
            'room_number' => $this->number,
            'name' => $this->name,
            'status' => $this->status,
            'facility' => $this->facility,
            'description' => $this->description,
            'image' => $imagePath,
        ]);

        // Kirim notifikasi sukses
        session()->flash('message', 'Data kamar berhasil diperbarui!');

        // Kirim event ke JS untuk menutup modal
        $this->dispatch('room-updated');

        // Bersihkan form
       
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
