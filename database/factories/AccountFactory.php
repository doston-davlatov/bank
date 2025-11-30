<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $accountTypes = ['current', 'savings', 'card', 'loan'];
        $statuses = ['active', 'frozen', 'closed', 'dormant'];

        return [
            'account_number' => $this->faker->unique()->numerify('ACC######'),
            'customer_id' => Customer::factory(),
            'branch_id' => Branch::factory(),
            'opened_by' => User::factory(),
            'currency_code' => $this->faker->randomElement(['UZS', 'USD', 'EUR']),
            'account_type' => $this->faker->randomElement($accountTypes),
            'balance' => $this->faker->randomFloat(2, 0, 1000000),
            'available_balance' => $this->faker->randomFloat(2, 0, 1000000),
            'status' => $this->faker->randomElement($statuses),
            'opened_at' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'closed_at' => null, // default null, mumkin keyinchalik factory states bilan o'zgartirish
        ];
    }
}
