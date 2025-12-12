<div>
    <div class="container">
        <h2>Detail User</h2>


        <div class="photo-box">
            <img src="{{url('storage/' . $photo) }}" alt="foto_profil" width="100px" height="100px" wire:model="photo">
        </div>


        <div class="form-group">
            <label>Nama</label>
            <input type="text"  readonly wire:model="name">
        </div>


        <div class="form-group">
            <label>Email</label>
            <input type="text"  readonly wire:model="email">
        </div>


        <div class="form-group">
            <label>No. Telepon</label>
            <input type="text" readonly wire:model="phone">
        </div>


        <div class="form-group">
            <label>Status</label>
            <select wire:model.live="status" wire:change="updateStatus">
                <option value="active">Aktif</option>
                <option value="pending">Pending</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>


        <h3>Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kamar</th>
                    <th>Bulan</th>
                    <th>Status</th>
                    <th>Tanggal Pembayaran</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


    </div>

</div>
