<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articles')->insert([
            'title' => 'Primer Articulo',
            'content' => 'Contenido de prueba',
            'image' => 'default.jpg',
            'category_id' => 1,
            'created_by' => 1
        ]);
    }
}
