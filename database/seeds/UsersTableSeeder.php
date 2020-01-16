<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $admin_id = DB::table('users')->insertGetId([
            'firstName' => 'Duncan',
            'lastName' => 'Administrator',
            'phone' => $faker->e164PhoneNumber,
            'street1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'country' => 'US',
            'role' => 'admin',
            'email' => 'admin@ef.com',
            'password' => bcrypt('admin@ef.com'),
        ]);

        $fm_id = DB::table('users')->insertGetId([
            'firstName' => 'Duncan',
            'lastName' => 'FM',
            'phone' => $faker->e164PhoneNumber,
            'street1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'country' => 'US',
            'role' => 'fund-manager',
            'email' => 'fm@ef.com',
            'password' => bcrypt('fm@ef.com'),
            'user_id' => $admin_id
        ]);


        $investor_id = DB::table('users')->insertGetId([
            'firstName' => 'Duncan',
            'lastName' => 'Investor',
            'phone' => $faker->e164PhoneNumber,
            'street1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'country' => 'US',
            'role' => 'investor',
            'email' => 'investor@ef.com',
            'password' => bcrypt('investor@ef.com'),
            'user_id' => $fm_id
        ]);
        for($k = 1; $k<=15; $k++){
            $id = DB::table('users')->insertGetId([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'phone' => $faker->e164PhoneNumber,
                'street1' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'zip' => $faker->postcode,
                'country' => 'US',
                'role' => 'investor',
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt(Str::random(10)),
                'user_id' => $fm_id
            ]);
        }


        $n = rand(10,30);
        for($j = 1; $j<=$n; $j++){
            $fm_id = DB::table('users')->insertGetId([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'phone' => $faker->e164PhoneNumber,
                'street1' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'zip' => $faker->postcode,
                'country' => 'US',
                'role' => 'fund-manager',
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt(Str::random(10)),
                'user_id' => $admin_id
            ]);

            if(rand(1,10)%2==0)
                for($k = 1; $k<=10; $k++){
                    $id = DB::table('users')->insertGetId([
                        'firstName' => $faker->firstName,
                        'lastName' => $faker->lastName,
                        'phone' => $faker->e164PhoneNumber,
                        'street1' => $faker->streetAddress,
                        'city' => $faker->city,
                        'state' => $faker->stateAbbr,
                        'zip' => $faker->postcode,
                        'country' => 'US',
                        'role' => 'investor',
                        'email' => $faker->unique()->safeEmail,
                        'password' => bcrypt(Str::random(10)),
                        'user_id' => $fm_id
                    ]);
                }
        }

    }
}
