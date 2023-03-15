<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use \App\Models\Locker;
use App\Models\User;

class LockerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::all()->toArray();
        $lockerList = ["00", "01", NULL, NULL, NULL, NULL, "02", "03", "04", NULL, NULL, NULL, NULL, "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33",];
        
        foreach ($lockerList as $value) {
            if($value == "00") continue;
            $locker = ['lockerNo' => $value];
            if ($value != NULL) {
                $index = random_int(0, count($users) - 1);
                $locker['lockerEncoding'] = $faker->unique()->regexify('[0-9]{4}');
                $locker['userId'] = $users[$index]['id'];
                array_splice($users, $index, 1);
            } else {
                $locker['lockerEncoding'] = NULL;
            }
            Locker::create(
                $locker
            );
        }
    }
}
