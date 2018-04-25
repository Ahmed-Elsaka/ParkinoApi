<?php

use Illuminate\Database\Seeder;

class RegisterSeeder extends Seeder
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

            \App\User::create([
                'name' => 'ahmed'.$i,
                'email' => 'ahmed0'.$i.'@yahoo.com',
                'password' => 123456,
                'phone_number'=>'01006031228',
                //'password' => Hash::make($request->password),
            ]);

        }
    }
}
