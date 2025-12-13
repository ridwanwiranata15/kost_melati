<div>
    @if (session()->has('message'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; margin-bottom: 15px; border-radius: 6px;">
            {{ session('message') }}
        </div>
    @endif

    <div class="livewire-table">
        <div class="table-header">
            <h3 class="table-title">Daftar Booking Kamar</h3>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nomor booking</th>
                        <th>Nama pelanggan</th>
                        <th>Nama kamar</th>
                        <th>Durasi</th>
                        <th>Dari tanggal</th>
                        <th>Sampai tanggal</th>
                        <th>Total harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->booking_code }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->room->name }}</td>
                            <td>{{ $booking->duration }}</td>
                            <td>{{ $booking->date_in }}</td>
                            <td>{{ $booking->date_out }}</td>
                            <td>{{ $booking->total_amount }}</td>
                            <td>
                                <select wire:change="updateStatus({{ $booking->id }}, $event.target.value)"
                                    style="padding: 5px; border-radius: 4px; border: 1px solid #ccc;">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="checkin" {{ $booking->status == 'checkin' ? 'selected' : '' }}>
                                        Checkin</option>
                                    <option value="checkout" {{ $booking->status == 'checkout' ? 'selected' : '' }}>
                                        Checkout</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                        Canceled</option>
                                </select>

                                {{-- Optional: Loading indicator biar user tau sedang proses --}}
                                <div wire:loading wire:target="updateStatus({{ $booking->id }}, $event.target.value)"
                                    style="font-size: 0.8em; color: blue;">
                                    Updating...
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
