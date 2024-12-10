<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseHistory;

class PurchaseHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseHistory::create([
            'user_id' => 1,
            'novel_title' => 'Novela 1',
            'price' => 19.99,
            'cover' => 'imgs/DtrtYuzimiOvQGlk0RTSWTEGxrR59INaygjdDr8U.jpg',
            'status' => 'pending',
        ]);

        PurchaseHistory::create([
            'user_id' => 2,
            'novel_title' => 'Novela 2',
            'price' => 29.99,
            'cover' => 'imgs/DtrtYuzimiOvQGlk0RTSWTEGxrR59INaygjdDr8U.jpg',
            'status' => 'pending',
        ]);
    }
}