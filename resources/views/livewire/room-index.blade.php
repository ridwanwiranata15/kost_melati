<div>

            <div class="modal-container">
                <div class="form-header">
                    <h2 style="margin:0; font-size:1.25rem;">
                         Tambah Kost
                    </h2>
                    <button class="btn-close" onclick="toggleModal('modalCreateKamar', false)">&times;</button>
                </div>
                <form wire:submit.prevent="update">
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
                                <option value="tersedia">Tersedia</option>
                                <option value="terisi">Tidak tersedia</option>
                                <option value="perbaikan">Dalam Perbaikan</option>
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

                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Deskripsi</label>
                            <textarea wire:model="description" rows="3" class="form-textarea" placeholder="Detail deskripsi..."></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        {{-- REMOVED wire:click="handleClick" --}}
                        <button type="submit" class="status-badge status-paid">
                            <span wire:loading.remove wire:target="update">Simpan Data</span>
                            <span wire:loading wire:target="update">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>

</div>
