<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Corenas',
            'abbreviation' => 'COR',
        ]);
        Category::create([
            'name' => 'Japonesas',
            'abbreviation' => 'JAP',
        ]);
        Category::create([
            'name' => 'Chinas',
            'abbreviation' => 'CHI',
        ]);
        Category::create([
            'name' => 'Varios',
            'abbreviation' => 'VAR',
        ]);
    }
}
