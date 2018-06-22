<?php

use Illuminate\Database\Seeder;

class gragesSlotsSeeder extends Seeder
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

            \App\grageSlotsModel::create([
                'grage_id' => '3',
                'slot' => $i,
                'state' => 1
            ]);

        }
    }
}
