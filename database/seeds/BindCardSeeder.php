<?php

use Illuminate\Database\Seeder;

class BindCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0 ; $i <50; $i++){
            \App\BindCard::create([
                'user_id'=>'',
                'card_no'
            ]);


        }
    }
}
