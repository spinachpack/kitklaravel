<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Insert default admin and department users
        DB::table('users')->insert([
            [
                'id_number' => 'ADMIN001',
                'email' => 'admin@ucbanilad.edu.ph',
                'password' => Hash::make('password'),
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'role' => 'admin',
                'department' => 'Administration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_number' => 'DEPT001',
                'email' => 'sports@ucbanilad.edu.ph',
                'password' => Hash::make('password'),
                'first_name' => 'Sports',
                'last_name' => 'Office',
                'role' => 'department',
                'department' => 'Sports Department',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert categories
        DB::table('categories')->insert([
            ['name' => 'Laboratory Equipment', 'description' => 'Science and computer lab equipment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sports Equipment', 'description' => 'Athletic and recreational gear', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Audio-Visual Equipment', 'description' => 'Projectors, cameras, sound systems', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Musical Instruments', 'description' => 'Instruments for music classes and events', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Office Equipment', 'description' => 'Printers, scanners, and office tools', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert sample equipment
        DB::table('equipment')->insert([
            ['name' => 'Basketball', 'category_id' => 2, 'description' => 'Official size basketball for indoor and outdoor use', 'quantity' => 15, 'available_quantity' => 15, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Volleyball', 'category_id' => 2, 'description' => 'Standard volleyball for games and training', 'quantity' => 10, 'available_quantity' => 10, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Football/Soccer Ball', 'category_id' => 2, 'description' => 'FIFA standard soccer ball', 'quantity' => 8, 'available_quantity' => 8, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Badminton Racket Set', 'category_id' => 2, 'description' => 'Complete badminton racket set with shuttlecocks', 'quantity' => 12, 'available_quantity' => 12, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Table Tennis Set', 'category_id' => 2, 'description' => 'Table tennis paddles and balls set', 'quantity' => 6, 'available_quantity' => 6, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LCD Projector', 'category_id' => 3, 'description' => 'Full HD projector 3000 lumens with HDMI', 'quantity' => 5, 'available_quantity' => 5, 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}