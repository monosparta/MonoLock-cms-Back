<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\locker>
 */
class LockerFactory extends Factory
{
    static $cnt = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'userId'=>User::table("users")->where("permission", "=", 1)->inRandomOrder(),
            'userId'=>references('id')->on('users'),
            'lockerNo' => sprintf("%02d", $this->faker->unique()->numberBetween(0, 33)),
            'lockerEncoding' => $this->faker->unique()->regexify('[0-9]{4}'),
        ];
    }
}
