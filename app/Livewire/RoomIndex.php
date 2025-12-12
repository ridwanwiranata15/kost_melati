<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Component;
use Livewire\WithFileUploads;

class RoomIndex extends Component
{
    use WithFileUploads;

    public $roomId;
    public $number;
    public $name;
    public $status = '';
    public $facility;
    public $image;
    public $description;
    public $isEdit = false;

    /**
     * ✅ mount untuk EDIT (berdasarkan ID)
     */
    public function mount($id)
    {
        $room = Room::findOrFail($id);

        $this->roomId = $room->id;
        $this->number = $room->room_number;
        $this->name = $room->name;
        $this->status = $room->status;
        $this->facility = $room->facility;
        $this->description = $room->description;
        $this->isEdit = true;
    }

    protected function rules()
    {
        return [
            'number' => 'required|unique:rooms,room_number,' . $this->roomId,
            'name' => 'required|string|max:255',
            'status' => 'required|in:tersedia,terisi,perbaikan',
            'facility' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ];
    }

    /**
     * ✅ UPDATE DATA
     */
    public function update()
    {
        $this->validate();

        $room = Room::findOrFail($this->roomId);

        $data = [
            'room_number' => $this->number,
            'name' => $this->name,
            'status' => $this->status,
            'facility' => $this->facility,
            'description' => $this->description,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('rooms', 'public');
        }

        $room->update($data);

         return redirect()->to('/rooms')
        ->with('success', 'Kamar berhasil diupdate ✅');
    }

    public function render()
    {
        return view('livewire.room-index');
    }
}
