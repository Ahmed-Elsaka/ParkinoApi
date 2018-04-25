<?php

use Illuminate\Database\Seeder;

class MakeReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0 ; $i <10; $i++){

            \App\MakeReservation::create([
                'long'=>1231,
                'lat'=>1231,
                'user_id'=>$i+10,
                'hourly_tier'=>1
            ]);

        }
    }
}
