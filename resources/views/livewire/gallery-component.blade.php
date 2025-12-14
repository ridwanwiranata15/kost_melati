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
            {{-- Tambahkan wire:click="resetInput" agar saat tambah baru form bersih --}}
            <button class="status-badge status-paid" onclick="toggleModal('modalCreateKamar', true)" wire:click="resetInput">
                + Tambah Kamar
            </button>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($galleries as $Gallery)
                        <tr>
                            <td>{{ $Gallery->name }}</td>
                            <td>{{ $Gallery->description }}</td>
                            <td>
                                @if($Gallery->image)
                                    <img src="{{ asset('storage/' . $Gallery->image) }}" alt="" width="80px" style="border-radius:4px;">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{-- TOMBOL EDIT --}}
                                {{-- Kita panggil function edit($id) --}}
                                <button class="btn-icon" wire:click="edit({{ $Gallery->id }})" wire:loading.attr="disabled">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL CREATE (Tetap seperti kode awal Anda) --}}
    {{-- ========================================== --}}
    <div id="modalCreateKamar" class="modal-overlay" wire:ignore.self>
        <div class="modal-container">
            <div class="form-header">
                <h2 style="margin:0; font-size:1.25rem;">Tambah Kost</h2>
                <button class="btn-close" onclick="toggleModal('modalCreateKamar', false)">&times;</button>
            </div>
            <form wire:submit.prevent="save">
                <div class="form-grid">
                    {{-- Input Name --}}
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" wire:model="name" class="form-input" placeholder="Cth: A-01">
                        @error('name') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                    </div>
                    {{-- Input Description --}}
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <input type="text" wire:model="description" class="form-input" placeholder="Cth: Standard">
                        @error('description') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                    </div>
                    {{-- Input Image --}}
                    <div class="form-group full-width">
                        <label class="form-label">Foto Kamar</label>
                        <input type="file" wire:model="image" class="form-input" style="padding: 8px;">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" style="width: 100px; margin-top: 10px; border-radius: 5px;">
                        @endif
                        <div wire:loading wire:target="image">Sedang mengupload...</div>
                        @error('image') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn" style="margin-right: 10px; background:#f1f5f9;" onclick="toggleModal('modalCreateKamar', false)">Batal</button>
                    <button type="submit" class="status-badge status-paid">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL EDIT (BARU) --}}
    {{-- ========================================== --}}
    <div id="modalEditKamar" class="modal-overlay" wire:ignore.self>
        <div class="modal-container">
            <div class="form-header">
                <h2 style="margin:0; font-size:1.25rem;">Edit Kost</h2>
                <button class="btn-close" onclick="toggleModal('modalEditKamar', false)">&times;</button>
            </div>

            {{-- Gunakan function update saat submit --}}
            <form wire:submit.prevent="update">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" wire:model="name" class="form-input">
                        @error('name') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <input type="text" wire:model="description" class="form-input">
                        @error('description') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Ganti Foto (Opsional)</label>
                        <input type="file" wire:model="image" class="form-input" style="padding: 8px;">

                        {{-- Logika Preview Gambar Edit --}}
                        <div style="margin-top: 10px;">
                            @if ($image)
                                {{-- 1. Jika user upload foto BARU, tampilkan preview sementara --}}
                                <p style="font-size:12px; color:green;">Foto Baru:</p>
                                <img src="{{ $image->temporaryUrl() }}" style="width: 100px; border-radius: 5px;">
                            @elseif ($old_image)
                                {{-- 2. Jika tidak upload, tampilkan foto LAMA dari database --}}
                                <p style="font-size:12px; color:#666;">Foto Saat Ini:</p>
                                <img src="{{ asset('storage/' . $old_image) }}" style="width: 100px; border-radius: 5px;">
                            @endif
                        </div>

                        <div wire:loading wire:target="image">Sedang mengupload...</div>
                        @error('image') <span class="text-error" style="color:red; font-size: 0.8em;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn" style="margin-right: 10px; background:#f1f5f9;" onclick="toggleModal('modalEditKamar', false)">Batal</button>
                    <button type="submit" class="status-badge status-paid">
                        <span wire:loading.remove wire:target="update">Update Data</span>
                        <span wire:loading wire:target="update">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- Script Handling --}}
    <script>
        document.addEventListener('livewire:initialized', () => {

            // Event Listener: Tutup semua modal saat berhasil simpan/update
            @this.on('room-saved', (event) => {
                toggleModal('modalCreateKamar', false);
                toggleModal('modalEditKamar', false);
            });

            // Event Listener: Buka modal Edit setelah data diambil dari server
            @this.on('open-edit-modal', (event) => {
                toggleModal('modalEditKamar', true);
            });
        });
    </script>
</div>
