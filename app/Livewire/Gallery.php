<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Gallery as GalleryModel;
use Livewire\WithFileUploads;

class Gallery extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $image;
    public $selected_id;
    public $old_image;

    public function edit($id)
    {
        // 1. Cari data berdasarkan ID
        $gallery = GalleryModel::find($id); // Sesuaikan Model Anda

        if ($gallery) {
            $this->selected_id = $id;
            $this->name = $gallery->name;
            $this->description = $gallery->description;
            $this->old_image = $gallery->image; // Simpan path gambar lama

            // Reset input file gambar baru agar kosong
            $this->reset('image');

            // 2. Kirim event ke JS untuk buka modal
            $this->dispatch('open-edit-modal');
        }
    }
    public function delete($id){
         $gallery = GalleryModel::find($id); // Sesuaikan Model Anda
         $gallery->delete();
         

    }

    public function update()
    {
        // 1. Validasi
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|max:2048', // Image jadi nullable saat update
        ]);

        $gallery = GalleryModel::find($this->selected_id);

        // 2. Cek apakah user upload gambar baru?
        $imagePath = $gallery->image; // Default pakai gambar lama

        if ($this->image) {
            // Jika ada upload baru, simpan & ganti path
            $imagePath = $this->image->store('gallery', 'public');
        }

        // 3. Update Data
        $gallery->update([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Data berhasil diperbarui.');

        // 4. Tutup modal & Reset
        $this->dispatch('room-saved');
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->name = '';
        $this->description = '';
        $this->image = null;
        $this->old_image = null;
        $this->selected_id = null;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
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
            $imagePath = $this->image->store('gallery-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // 3. Create Record
        GalleryModel::create([
            "name"  => $this->name,
            "image"  => $validatedData['image'] ?? null,
            "description"  => $this->description
        ]);

        // 4. Reset Form and Close Modal
        $this->reset(['name', 'image', 'description']);

        // Dispatch event to close modal (requires simple JS listener)
        $this->dispatch('room-saved');

        session()->flash('message', 'Kamar berhasil ditambahkan!');
    }
    public function render()
    {
        $galleries = GalleryModel::latest()->get();
        return view('livewire.gallery', compact('galleries'));
    }
}
