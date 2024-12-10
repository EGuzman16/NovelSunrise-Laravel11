<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Theme::create(['name' => 'Novelas']);
    Theme::create(['name' => 'Adaptaciones a pantalla']);
    Theme::create(['name' => 'Manhwa/Manga']);
    Theme::create(['name' => 'Otros libros']);
    Theme::create(['name' => 'Misceláneos']);
    }
}
