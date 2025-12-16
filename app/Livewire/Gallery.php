<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Gallery as GalleryModel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Gallery extends Component
{
    use WithFileUploads;

    public $name, $description, $image, $old_image, $selected_id;

    // Listener agar Livewire tahu komponen perlu refresh saat ada event tertentu
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        // Ambil data terbaru
        $galleries = GalleryModel::latest()->get();
        return view('livewire.gallery', compact('galleries'));
    }

    // --- LOGIC CREATE ---
    public function create()
    {
        $this->resetInput();
        // Event ini ditangkap oleh AlpineJS di Modal Create
        $this->dispatch('open-create-modal');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:2048', // Wajib saat create
            'description' => 'required|string',
        ]);

        $imagePath = $this->image->store('gallery-images', 'public');

        GalleryModel::create([
            "name"        => $this->name,
            "image"       => $imagePath,
            "description" => $this->description
        ]);

        $this->dispatch('gallery-saved'); // Tutup modal lewat Alpine
        $this->resetInput();
        session()->flash('message', 'Foto berhasil ditambahkan!');
    }

    // --- LOGIC EDIT ---
    public function edit($id)
    {
        $gallery = GalleryModel::find($id);

        if ($gallery) {
            $this->selected_id = $id;
            $this->name = $gallery->name;
            $this->description = $gallery->description;
            $this->old_image = $gallery->image;

            $this->reset('image'); // Reset input file baru

            // Event ini ditangkap oleh AlpineJS di Modal Edit
            $this->dispatch('open-edit-modal');
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // Nullable saat update
        ]);

        $gallery = GalleryModel::find($this->selected_id);
        $imagePath = $gallery->image;

        if ($this->image) {
            // Hapus gambar lama jika ada
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            $imagePath = $this->image->store('gallery-images', 'public');
        }

        $gallery->update([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imagePath,
        ]);

        $this->dispatch('gallery-saved'); // Tutup modal lewat Alpine
        $this->resetInput();
        session()->flash('message', 'Data berhasil diperbarui.');
    }

    // --- LOGIC DELETE ---
    public function delete($id)
    {
        $gallery = GalleryModel::find($id);
        if ($gallery) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            $gallery->delete();
            session()->flash('message', 'Foto berhasil dihapus.');
        }
    }

    public function resetInput()
    {
        $this->name = '';
        $this->description = '';
        $this->image = null;
        $this->old_image = null;
        $this->selected_id = null;
    }
}
