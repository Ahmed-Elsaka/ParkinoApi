<?php

use Illuminate\Database\Seeder;

class SystemCardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0 ; $i <90; $i++){
            \App\SystemCards::create([
                'qr_no'=>'55555555'.$i,
                'rfid_no'=>'55555555'.$i,
            ]);
        }
    }
}
