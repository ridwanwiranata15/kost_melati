<div>
    {{-- Success Message --}}
    @if (session()->has('message'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; margin-bottom: 15px; border-radius: 6px;">
            {{ session('message') }}
        </div>
    @endif

    <div class="livewire-table">
        <div class="table-header">
            <h3 class="table-title">Daftar Kamar</h3>
            <button class="status-badge status-paid" onclick="toggleModal('modalCreateKamar', true)">
                + Tambah Kamar
            </button>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Kamar</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th>Foto</th> <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through rooms passed from Component --}}
                    @forelse($rooms as $room)
                        <tr>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->facility }}</td>
                            <td>
                                @if($room->status == 'available')
                                    <span style="color:green; font-weight:bold">Tersedia</span>
                                @elseif($room->status == 'unavailable')
                                    <span style="color:red; font-weight:bold">Terisi</span>
                                @else
                                    <span style="color:orange; font-weight:bold">Perbaikan</span>
                                @endif
                            </td>
                            <td>
                                @if($room->image)
                                    <img src="{{ asset('storage/'.$room->image) }}" alt="Foto" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span style="font-size: 10px; color: #888;">No Image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.room.edit', $room->id) }}">
                                    <button>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </a>
                                <button wire:click="delete({{ $room->id }})"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">Belum ada data kamar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="modalCreateKamar" class="modal-overlay" wire:ignore.self>
            <div class="modal-container">
                <div class="form-header">
                    <h2 style="margin:0; font-size:1.25rem;">
                         Tambah Kost
                    </h2>
                    <button class="btn-close" onclick="toggleModal('modalCreateKamar', false)">&times;</button>
                </div>

                {{-- Trigger "save" method on submit --}}
                <form wire:submit.prevent="save">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nomor Kamar</label>
                            <input type="text" wire:model="number" class="form-input" placeholder="Cth: A-01">
                            @error('number') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama / Tipe</label>
                            <input type="text" wire:model="name" class="form-input" placeholder="Cth: Standard">
                            @error('name') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select wire:model="status" class="form-select">
                                <option value="">Pilih Status</option>
                                <option value="available">Tersedia</option>
                                <option value="unavailable">Tidak tersedia</option>
                                <option value="repair">Dalam Perbaikan</option>
                            </select>
                            @error('status') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Fasilitas</label>
                            <input wire:model="facility" type="text" class="form-input" placeholder="WiFi, AC...">
                            @error('facility') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Foto Kamar</label>
                            <input type="file" wire:model="image" class="form-input" style="padding: 8px;">

                            {{-- Image Preview --}}
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" style="width: 100px; margin-top: 10px; border-radius: 5px;">
                            @endif

                            <div wire:loading wire:target="image" style="color: var(--primary); font-size: 12px; margin-top:4px;">
                                Sedang mengupload...
                            </div>
                            @error('image') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Deskripsi</label>
                            <textarea wire:model="description" rows="3" class="form-textarea" placeholder="Detail deskripsi..."></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn" style="margin-right: 10px; background:#f1f5f9;" onclick="toggleModal('modalCreateKamar', false)">Batal</button>

                        {{-- REMOVED wire:click="handleClick" --}}
                        <button type="submit" class="status-badge status-paid">
                            <span wire:loading.remove wire:target="save">Simpan Data</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script to handle auto-closing modal on success --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('room-saved', (event) => {
                toggleModal('modalCreateKamar', false);
            });
        });
    </script>
</div>
