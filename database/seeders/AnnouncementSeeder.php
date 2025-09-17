<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Rapat Koordinasi Desa',
                'content' => 'Rapat koordinasi bulanan untuk membahas program dan kegiatan desa',
                'description' => 'Rapat koordinasi bulanan untuk membahas program dan kegiatan desa',
                'announcement_date' => now()->addDays(5),
                'announcement_time' => '19:00',
                'location' => 'Balai Desa',
                'priority' => 'high',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Pendaftaran Bantuan UMKM',
                'content' => 'Pendaftaran bantuan untuk Usaha Mikro Kecil dan Menengah',
                'description' => 'Pendaftaran bantuan untuk Usaha Mikro Kecil dan Menengah',
                'announcement_date' => now()->addDays(10),
                'announcement_time' => null,
                'location' => 'Kantor Desa',
                'priority' => 'medium',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Jadwal Posyandu',
                'content' => 'Pos Pelayanan Terpadu untuk kesehatan ibu dan anak',
                'description' => 'Pos Pelayanan Terpadu untuk kesehatan ibu dan anak',
                'announcement_date' => now()->addDays(3),
                'announcement_time' => '08:00',
                'location' => 'Posyandu Desa',
                'priority' => 'medium',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'title' => 'Gotong Royong Bersih Desa',
                'content' => 'Kegiatan gotong royong untuk membersihkan lingkungan desa',
                'description' => 'Kegiatan gotong royong untuk membersihkan lingkungan desa',
                'announcement_date' => now()->addDays(7),
                'announcement_time' => '07:00',
                'location' => 'Seluruh Wilayah Desa',
                'priority' => 'high',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'Pembagian Sembako',
                'content' => 'Pembagian sembako untuk keluarga kurang mampu',
                'description' => 'Pembagian sembako untuk keluarga kurang mampu',
                'announcement_date' => now()->addDays(14),
                'announcement_time' => '09:00',
                'location' => 'Balai Desa',
                'priority' => 'low',
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($announcements as $announcement) {
            \App\Models\Announcement::create($announcement);
        }
    }
}
