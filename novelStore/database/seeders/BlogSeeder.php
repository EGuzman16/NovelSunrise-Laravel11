<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blogs')->insert([
            [
                'blog_id' => 1,
                'theme_fk' => 1, 
                'title' => 'Título del primer blog',
                'content' => 'Contenido del primer blog.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_id' => 2,
                'theme_fk' => 3,
                'title' => 'Título del segundo blog',
                'content' => 'Contenido del segundo blog.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_id' => 3,
                'theme_fk' => 4,
                'title' => 'Título del tercer blog',
                'content' => 'Contenido del tercer blog.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
