<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'buku_id'         => Buku::inRandomOrder()->first()->id ?? Buku::factory(),
            'nama_peminjam'   => fake()->name(),
            'tanggal_pinjam'  => fake()->dateTimeBetween('now'),
            'status'          => fake()->randomElement(['Dipinjam',]),
            ]
        ;
    }
}
