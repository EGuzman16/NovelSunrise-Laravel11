<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NovelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('novels')->insert([
            [
                'novel_id' => 1,
                'category_fk' => 1,
                'title' => 'Novela1',
                //'cover' => '../../public/storage/app/imgs/1.jpg',
                'price' => 2000,
                'release_date' => '2000-01-01',
                'synopsis' => 'sinopsis1.',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'novel_id' => 2,
                'category_fk' => 1,
                'title' => 'Novela2',
                //'cover' => '../../public/storage/app/imgs/1.jpg',
                'price' => 2000,
                'release_date' => '2000-01-02',
                'synopsis' => 'sinopsis2.',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'novel_id' => 3,
                'category_fk' => 1,
                'title' => 'Novela3',
                //'cover' => '../../public/storage/app/imgs/1.jpg',
                'price' => 2000,
                'release_date' => '2000-01-03',
                'synopsis' => 'sinopsis3.',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
        ]);

        \DB::table('novels_have_tags')->insert([
            [
                'novel_fk' => 1,
                'tag_fk' => 1,

            ],
            [
                'novel_fk' => 1,
                'tag_fk' => 2,

            ],
            [
                'novel_fk' => 1,
                'tag_fk' => 3,

            ],
            [
                'novel_fk' => 2,
                'tag_fk' => 4,

            ],
            [
                'novel_fk' => 2,
                'tag_fk' => 5,

            ],
            [
                'novel_fk' => 2,
                'tag_fk' => 6,

            ],
            [
                'novel_fk' => 3,
                'tag_fk' => 7,

            ],
            [
                'novel_fk' => 3,
                'tag_fk' => 8,

            ],
            [
                'novel_fk' => 3,
                'tag_fk' => 9,

            ],
        ]);
    }
}
