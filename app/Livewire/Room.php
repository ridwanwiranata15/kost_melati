<?php

namespace App\Livewire;

use App\Models\Room as ModelsRoom;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Room extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $number;
    public $name;
    public $status = ''; // Default empty string for select
    public $facility;
    public $image;
    public $description;
    public $room_id;
    public $property_id;
    public $search = '';
    public $filterStatus = '';
    public $filterProperty = '';
    public $isCreateModalOpen = false;
    public $isEditModalOpen = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    // Define validation rules
    protected $rules = [
        'property_id' => 'required|exists:properties,id',
        'number' => 'required|unique:rooms,room_number',
        'name' => 'required|string|max:255',
        'status' => 'required|in:available,unavailable,repair',
        'facility' => 'required|string',
        'image' => 'nullable|image|max:2048', // 2MB Max
        'description' => 'nullable|string',
    ];
    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['number', 'name', 'status', 'facility', 'image', 'description', 'property_id']);
        $this->isCreateModalOpen = true; // Buka modal via PHP
    }

    public function closeCreateModal()
    {
        $this->isCreateModalOpen = false;
        $this->reset(['image']); // Reset image agar tidak nyangkut saat buka lagi
    }
        public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->reset(['image', 'oldImage']);
    }
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
            "property_id" => $this->property_id,
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
        $this->closeCreateModal(); // Tutup modal setelah simpan
        session()->flash('message', 'Data berhasil disimpan.');
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
        $this->isEditModalOpen = true;
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
            'property_id' => 'required|exists:properties,id',
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
            'property_id' => $this->property_id,
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
        $this->closeEditModal();

    }

    public function render()
    {
        $user = auth()->user();
        
        // 1. Query Data Kamar dengan Filter
        $query = ModelsRoom::query()->with('property');

        // Role-based filtering
        if ($user->isCaretaker()) {
            $managedPropertyIds = $user->properties()->pluck('properties.id')->toArray();
            $query->whereIn('property_id', $managedPropertyIds);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('room_number', 'like', '%' . $this->search . '%')
                    ->orWhere('facility', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterProperty) {
            $query->where('property_id', $this->filterProperty);
        }

        $rooms = $query->latest()->paginate(10);

        // 2. Hitung Statistik untuk Cards
        $statsQuery = ModelsRoom::query();
        if ($user->isCaretaker()) {
            $managedPropertyIds = $user->properties()->pluck('properties.id')->toArray();
            $statsQuery->whereIn('property_id', $managedPropertyIds);
        }

        $totalAvailable = (clone $statsQuery)->where('status', 'available')->count();
        $totalRepair = (clone $statsQuery)->where('status', 'repair')->count();
        $totalUnavailable = (clone $statsQuery)->where('status', 'unavailable')->count();

        // 3. Ambil list property untuk dropdown (jika admin semua, jika caretaker yang dia kelola)
        if ($user->isAdmin()) {
            $properties = \App\Models\Property::all();
        } else {
            $properties = $user->properties;
        }

        return view('livewire.room', [
            'rooms' => $rooms,
            'properties' => $properties,
            'totalAvailable' => $totalAvailable,
            'totalRepair' => $totalRepair,
            'totalUnavailable' => $totalUnavailable,
        ]);
    }
}
