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
        DB::table('users')->insert([
            'firstName' => 'Duncan',
            'lastName' => 'Administrator',
            'phone' => '0720455419',
            'street1' => '48',
            'city' => 'TAMPA',
            'state' => 'FL',
            'zip' => '01034',
            'country' => 'US',
            'role' => 'admin',
            'email' => 'admin@ef.com',
            'password' => bcrypt('admin@ef.com'),
        ]);

        DB::table('users')->insert([
            'firstName' => 'Duncan',
            'lastName' => 'RFM',
            'phone' => '0720455419',
            'street1' => '48',
            'city' => 'TAMPA',
            'state' => 'FL',
            'zip' => '01034',
            'country' => 'US',
            'role' => 'regional-fund-manager',
            'email' => 'rfm@ef.com',
            'password' => bcrypt('rfm@ef.com'),
        ]);

        DB::table('users')->insert([
            'firstName' => 'Duncan',
            'lastName' => 'FM',
            'phone' => '0720455419',
            'street1' => '48',
            'city' => 'TAMPA',
            'state' => 'FL',
            'zip' => '01034',
            'country' => 'US',
            'role' => 'fund-manager',
            'email' => 'fm@ef.com',
            'password' => bcrypt('fm@ef.com'),
        ]);


        DB::table('users')->insert([
            'firstName' => 'Duncan',
            'lastName' => 'Investor',
            'phone' => '0720455419',
            'street1' => '48',
            'city' => 'TAMPA',
            'state' => 'FL',
            'zip' => '01034',
            'country' => 'US',
            'role' => 'investor',
            'email' => 'investor@ef.com',
            'password' => bcrypt('investor@ef.com'),
        ]);

        for($i = 1; $i<=20; $i++){
            DB::table('users')->insert([
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
            ]);
        }

        for($i = 1; $i<=20; $i++){
            DB::table('users')->insert([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'phone' => rand(10000000,999999999),
                'street1' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'zip' => $faker->postcode,
                'country' => 'US',
                'role' => 'fund-manager',
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt(Str::random(10)),
            ]);
        }

        for($i = 1; $i<=20; $i++){
            DB::table('users')->insert([
                'firstName' => $faker->firstName,
                'lastName' => $faker->lastName,
                'phone' => rand(10000000,999999999),
                'street1' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'zip' => $faker->postcode,
                'country' => 'US',
                'role' => 'regional-fund-manager',
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt(Str::random(10)),
            ]);
        }
    }
}
