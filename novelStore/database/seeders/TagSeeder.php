<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag; 

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create ([
            'name' => 'M18'
        ]);
        Tag::create ([
            'name' => 'Novelas de Romance'
        ]);
        Tag::create ([
            'name' => 'Fantasía Romántica'
        ]);
        Tag::create ([
            'name' => 'Amor y Magia'
        ]);
        Tag::create ([
            'name' => 'Príncipes y Princesas'
        ]);
        Tag::create ([
            'name' => 'Amor Prohibido'
        ]);
        Tag::create ([
            'name' => 'Mundos Fantásticos'
        ]);
        Tag::create ([
            'name' => 'Reinos y Reinas'
        ]);
        Tag::create ([
            'name' => 'Reencarnación'
        ]);
        Tag::create ([
            'name' => 'Venganza'
        ]);
        Tag::create ([
            'name' => 'Cultivación'
        ]);
        Tag::create ([
            'name' => 'Héroes y Heroínas'
        ]);
        Tag::create ([
            'name' => 'Guerra y Estrategia'
        ]);
        Tag::create ([
            'name' => 'Poderes Sobrenaturales'
        ]);
        Tag::create ([
            'name' => 'Cuentos de Hadas Modernos'
        ]);
        Tag::create ([
            'name' => 'Comedia Romántica'
        ]);
        Tag::create ([
            'name' => 'Novelas Escolares'
        ]);
        Tag::create ([
            'name' => 'Triángulos Amoroso'
        ]);
        Tag::create ([
            'name' => 'Amor Inmortal'
        ]);
        Tag::create ([
            'name' => 'Isekai'
        ]);
        Tag::create ([
            'name' => 'Drama'
        ]);
        Tag::create ([
            'name' => 'Romance Fantástico'
        ]);
        
    }
}
