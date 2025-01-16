<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'noticias', 'created_by' => 1],
            ['name' => 'Tutoriales', 'created_by' => 1],
            ['name' => 'Eventos', 'created_by' => 1],
        ]);
    }
}
