<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MultiKosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Properties
        $jawa = Property::updateOrCreate(['slug' => 'kost-melati-jawa'], [
            'name' => 'Kost di Jawa',
            'location' => 'Jawa Tengah',
            'address' => 'Jl. Merdeka No. 123, Semarang',
            'description' => 'Kost nyaman di pusat kota Semarang.',
        ]);

        $sumatera = Property::updateOrCreate(['slug' => 'kost-melati-sumatera'], [
            'name' => 'Kost di Sumatera',
            'location' => 'Sumatera Utara',
            'address' => 'Jl. Thamrin No. 45, Medan',
            'description' => 'Kost strategis dekat kampus di Medan.',
        ]);

        // 2. Create Caretakers
        $penjagaJawa = User::updateOrCreate(['email' => 'penjaga.jawa@gmail.com'], [
            'name' => 'Penjaga Jawa',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'caretaker',
            'status' => 'active',
        ]);
        $penjagaJawa->properties()->sync([$jawa->id]);

        $penjagaSumatera = User::updateOrCreate(['email' => 'penjaga.sumatera@gmail.com'], [
            'name' => 'Penjaga Sumatera',
            'phone' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'caretaker',
            'status' => 'active',
        ]);
        $penjagaSumatera->properties()->sync([$sumatera->id]);

        $penjagaMulti = User::updateOrCreate(['email' => 'penjaga.multi@gmail.com'], [
            'name' => 'Penjaga Multi Lokasi',
            'phone' => '081234567892',
            'password' => Hash::make('password'),
            'role' => 'caretaker',
            'status' => 'active',
        ]);
        $penjagaMulti->properties()->sync([$jawa->id, $sumatera->id]);

        $roomsJawa = [
            [
                'room_number' => 'J-101',
                'name' => 'VIP Executive',
                'status' => 'available',
                'facility' => 'AC, WiFi 100Mbps, Kamar Mandi Dalam, Water Heater, Lemari Besar',
                'description' => 'Kamar premium dengan fasilitas lengkap di lantai 1.',
            ],
            [
                'room_number' => 'J-102',
                'name' => 'VIP Executive',
                'status' => 'unavailable',
                'facility' => 'AC, WiFi 100Mbps, Kamar Mandi Dalam, Water Heater',
                'description' => 'Sudah ditempati penyewa aktif.',
            ],
            [
                'room_number' => 'J-103',
                'name' => 'Deluxe Room',
                'status' => 'available',
                'facility' => 'AC, WiFi, Kamar Mandi Dalam',
                'description' => 'Kamar nyaman untuk mahasiswa atau pekerja.',
            ],
            [
                'room_number' => 'J-104',
                'name' => 'Standard Plus',
                'status' => 'repair',
                'facility' => 'Kipas Angin, WiFi, Kamar Mandi Luar',
                'description' => 'Sedang renovasi ringan.',
            ],
        ];

        foreach ($roomsJawa as $room) {
            Room::updateOrCreate(
                ['room_number' => $room['room_number']],
                array_merge($room, [
                    'property_id' => $jawa->id,
                ])
            );
        }

        foreach ($roomsJawa as $room) {
            Room::updateOrCreate(
                ['room_number' => $room['room_number']],
                array_merge($room, [
                    'property_id' => $jawa->id,
                ])
            );
        }

        // 3. Create Rooms (SUMATERA)
        $roomsSumatera = [
            [
                'room_number' => 'S-101',
                'name' => 'Deluxe View',
                'status' => 'available',
                'facility' => 'AC, WiFi, Kamar Mandi Dalam, Balkon',
                'description' => 'Kamar dengan view kota Medan.',
            ],
            [
                'room_number' => 'S-102',
                'name' => 'Standard Plus',
                'status' => 'unavailable',
                'facility' => 'Kipas Angin, WiFi',
                'description' => 'Kamar ekonomis tapi nyaman.',
            ],
            [
                'room_number' => 'S-103',
                'name' => 'Standard',
                'status' => 'available',
                'facility' => 'Kipas Angin',
                'description' => 'Cocok untuk mahasiswa baru.',
            ],
        ];

        foreach ($roomsSumatera as $room) {
            Room::updateOrCreate(
                ['room_number' => $room['room_number']],
                array_merge($room, [
                    'property_id' => $sumatera->id,
                ])
            );
        }

        foreach ($roomsSumatera as $room) {
            Room::updateOrCreate(
                ['room_number' => $room['room_number']],
                array_merge($room, [
                    'property_id' => $sumatera->id,
                ])
            );
        }

        $this->command->info('Multi-Kos test data seeded successfully!');
    }
}
