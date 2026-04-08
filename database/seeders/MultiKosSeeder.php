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
            'name' => 'Kost Melati Jawa',
            'location' => 'Jawa Tengah',
            'address' => 'Jl. Merdeka No. 123, Semarang',
            'description' => 'Kost nyaman di pusat kota Semarang.',
        ]);

        $sumatera = Property::updateOrCreate(['slug' => 'kost-melati-sumatera'], [
            'name' => 'Kost Melati Sumatera',
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

        // 3. Create Rooms
        Room::updateOrCreate(['room_number' => 'J-01'], [
            'property_id' => $jawa->id,
            'name' => 'VIP Jawa',
            'status' => 'available',
            'facility' => 'AC, WiFi, Kamar Mandi Dalam',
            'description' => 'Kamar VIP di lokasi Jawa.',
        ]);

        Room::updateOrCreate(['room_number' => 'S-01'], [
            'property_id' => $sumatera->id,
            'name' => 'Standard Sumatera',
            'status' => 'available',
            'facility' => 'Kipas Angin, WiFi',
            'description' => 'Kamar standard di lokasi Sumatera.',
        ]);
        
        $this->command->info('Multi-Kos test data seeded successfully!');
    }
}
