<div>
    <div class="livewire-table">
        <div class="table-header">
            <h3 class="table-title">Daftar tamu kostan</h3>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->status }}</td>
                            <td><img src="{{ url('storage/' . $user->photo) }}" alt="foto_profil" width="100px" height="100px"></td>
                            <td>
                                <a href="{{ route('admin.user.detail', $user->id) }}">
                                    <button>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    {{-- Loop through rooms passed from Component --}}

                </tbody>
            </table>
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
