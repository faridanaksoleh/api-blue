<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::factory()->count(10)->create()->each(function ($store) {
            StoreBalance::factory()->create(['store_id' => $store->id]);
        });
    }
}
