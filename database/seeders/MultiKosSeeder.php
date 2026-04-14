<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MultiKosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Properties (Dari Data SQL)
        $curup = Property::updateOrCreate(['slug' => 'kos-di-curup'], [
            'name' => 'Kos di Curup',
            'location' => 'Bengkulu',
            'address' => 'Jalan Hegel Blok A No.03, Dusun Curup, Kec. Curup Utara, Kabupaten Rejang Lebong, Bengkulu 39119',
            'description' => 'Kost nyaman dan dekat dari IAIN CURUP',
            'image' => 'properties/ibJcQx2eAKVBhgiXpfemDBavCySn0KSNcknu9fEt.jpg',
        ]);

        // 2. Create Caretakers (Disesuaikan dengan properti baru)
        $penjagaCurup = User::updateOrCreate(['email' => 'penjaga.curup@gmail.com'], [
            'name' => 'Penjaga Kos Curup',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'caretaker',
            'status' => 'active',
        ]);
        $penjagaCurup->properties()->sync([$curup->id]);

        // 3. Create Galleries (Dari Data SQL)
        $galleries = [
            [
                'name' => 'Lorong El Sholeha kos',
                'image' => 'gallery-images/ILgfzf39xNLCl9DGVuXMD6Bvw8oqWl8iYHo9EzYm.jpg',
                'description' => 'Lorong El Sholeha Kos',
            ],
            [
                'name' => 'View depan El Sholeha kos',
                'image' => 'gallery-images/iRfPlnLu9koKzfJ4DChBGKhSAJglByiRoUHBeUZF.jpg',
                'description' => 'View depan El Sholeha kos',
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::updateOrCreate(
                ['name' => $gallery['name']], // Menggunakan nama sebagai identifier unik
                $gallery
            );
        }

        // 4. Create Rooms (Dari Data SQL)
        $rooms = [
            [
                'room_number' => '001',
                'name' => 'Kamar 001',
                'status' => 'unavailable',
                'facility' => 'WI-FI,Kasur,Ranjang',
                'image' => 'rooms/hj8vFKNR1FBlIGLldW8S9IZk2ipe8jNh2ehtSpk0.jpg',
                'description' => 'Kamar nyaman di lantai 1.',
            ],
            [
                'room_number' => '002',
                'name' => 'Kamar 002',
                'status' => 'available',
                'facility' => 'Kasur, WiFi 20Mbps, Kamar Mandi Dalam,Ranjang ,Tempat Masak',
                'image' => 'rooms/mHKfE5SAo8yK2uTPQZ4YOKAiU00yfjPHQovydPAf.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '003',
                'name' => 'Kamar 003',
                'status' => 'unavailable',
                'facility' => 'Kasur,Ranjang, WiFi, Kamar Mandi Dalam',
                'image' => 'rooms/UMSMiqpJcJyIL5JwuXPV1R4McLruwzp6GfqUKNI7.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '004',
                'name' => 'Kamar 004',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang, WiFi, Kamar Mandi Luar',
                'image' => 'rooms/Fd00RdBDpdem2Kr0mWndomR0MSHv9iOGxSwldFa2.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '005',
                'name' => 'Kamar 005',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang, WiFi, Kamar Mandi Dalam, Balkon',
                'image' => 'rooms/zdqvCKPXt9kHTpD2oQ8rXbYCZ65Ji3rstKQE1lJk.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '006',
                'name' => 'Kamar 006',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang, WiFi,Kamar Mandi dalam,Tempat masak di dalam',
                'image' => 'rooms/0AgcbeeKfkQFrhviRdAsR9hz2djyUTxLSjIFJqpS.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '007',
                'name' => 'Kamar 007',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang,Kamar Mandi dalam,WI-FI',
                'image' => 'rooms/XSGRfuYfAdZ9Zi4uriSagMnQYAd8t8am4p3Ozjgw.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '008',
                'name' => 'Standar',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang,Wi-fi,Kamar mandi dalam',
                'image' => 'room-images/5cvTHymPfo07Xw7vI27Ufhzs2CN7GlauC8iNT5ll.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '009',
                'name' => 'standar',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang,Wi-fi,Kamar mandi dalam',
                'image' => 'room-images/RXBDR9IfdNkpWwGTlmlRwJJqjuHkgVJHdvqFBR9E.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '010',
                'name' => 'Kamar 010',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang,Wi-fi,Kamar mandi dalam,tempat masak',
                'image' => 'room-images/x1JbNOYnWwGQzkqtv42VnR8X1raXN69072yrrMuc.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '012',
                'name' => 'Kamar 012',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang,Kamar mandi dalam,tempat masak,Wi-fi',
                'image' => 'room-images/Nr3rPhkVyn1tG3QYwlyxgr7EJwV5ezIc8swOVDDm.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '013',
                'name' => 'Kamar 013',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang,Kamar mandi dalam,tempat masak,Wi-fi',
                'image' => 'room-images/QGcK5KaqAjPQaI8wHaFTITjJodzlxoLltAuFwzIM.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '014',
                'name' => 'Kamar 014',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang,Kamar mandi dalam,tempat masak,Wi-fi',
                'image' => 'room-images/8SiiezRSR44RGCV8BQcINBZ54uwWAd9VqxRMvihe.jpg',
                'description' => 'Kos 1 kamar di lengkapi kamar mandi di dalam, tempat masak dengan luas 3 x 4.',
            ],
            [
                'room_number' => '015',
                'name' => 'Kamar 015',
                'status' => 'available',
                'facility' => 'Kasur,Ranjang,Kamar mandi dalam,tempat masak,Wi-fi',
                'image' => 'room-images/qOvj42otmK5Hx2YONwzuBpPkasQRBJMGn3Kb4UhA.jpg',
                'description' => 'Kasur,Ranjang,Kamar mandi dalam,tempat masak,Wi-fi',
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                [
                    'room_number' => $room['room_number'],
                    'property_id' => $curup->id,
                ],
                $room
            );
        }

        $this->command->info('Data Kos El Sholeha (Curup) berhasil di-seed!');
    }
}
