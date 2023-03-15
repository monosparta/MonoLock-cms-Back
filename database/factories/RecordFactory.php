<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\user;
use \App\Models\locker;
use phpDocumentor\Reflection\Types\Null_;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $locker = locker::where("userId", "<>", NULL)->where('lockerNo', '<>', '00')->inRandomOrder()->first();
        $randnum = rand(1, 40);
        $userId = $locker->userId;
        $description = NULL;
        if ($randnum == 1) {
            $user = user::where("permission", "=", 0)->inRandomOrder()->first();
            if ($user != NULL) {
                $userId = $user->id;
                $description = $this->faker->text();
            }
        }
        return [
            'description' => $description,
            'lockerId' => $locker->id,
            'userId' => $userId,
        ];
    }
}
