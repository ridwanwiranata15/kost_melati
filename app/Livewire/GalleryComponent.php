<?php

namespace App\Livewire;

use Livewire\Component;

class GalleryComponent extends Component
{
    public $selected_id;
    public $old_image;
     public $name;
    public $description;
    public $image;
    public function edit($id)
    {
        // 1. Cari data berdasarkan ID
        $gallery = \App\Models\Gallery::find($id); // Sesuaikan Model Anda

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

    public function update()
    {
        // 1. Validasi
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|max:2048', // Image jadi nullable saat update
        ]);

        $gallery = \App\Models\Gallery::find($this->selected_id);

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
    public function render()
    {
        return view('livewire.gallery-component');
    }
}
