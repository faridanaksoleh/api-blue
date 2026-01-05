<?php

namespace Database\Factories;

use App\Models\StoreBalanceHistory;
use App\Models\StoreBalance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreBalanceHistory>
 */
class StoreBalanceHistoryFactory extends Factory
{
    protected $model = StoreBalanceHistory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),    //beda dari tutor
            'store_balance_id' => StoreBalance::factory(),
            'type' => 'initial',
            'reference_id' => null,
            'reference_type' => null,
            'amount' => $this->faker->randomFloat(2, 0, 100000),
            'remarks' => 'Pembuatan toko baru'
        ];
    }
}
