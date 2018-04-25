<?php

use Illuminate\Database\Seeder;

class BarkingAreaSeeder extends Seeder
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

            \App\ParkingArea::create([
                'name'=>$faker->name(),
                'admin_id'=>'1',
                'owner_ssd'=>'123123123'.$i,
                'long'=>'123'.$i,
                'lat'=>'123'.$i,
                'slots_no'=>5 + $i,


            ]);

        }
    }
}
