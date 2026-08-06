<?php

namespace Database\Seeders;

use App\models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Buku::factory(30)->create();
    }
}
