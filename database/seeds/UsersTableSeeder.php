<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use Carbon\Carbon;

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
            'lastName' => 'Mwangi',
            'phone' => $faker->e164PhoneNumber,
            'street1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'country' => 'US',
            'role' => 'admin',
            'email' => 'admin@ef.com',
            'password' => bcrypt('admin@ef.com'),
            'created_at' => Carbon::now()->subMonths(24)
        ]);

        $fm_id = DB::table('users')->insertGetId([
            'firstName' => 'Luke',
            'lastName' => 'Dreyer',
            'phone' => $faker->e164PhoneNumber,
            'street1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'country' => 'US',
            'role' => 'fund-manager',
            'email' => 'fm@ef.com',
            'password' => bcrypt('fm@ef.com'),
            'user_id' => $admin_id,
            'created_at' => Carbon::now()->subMonths(24)
        ]);


        $investor_id = DB::table('users')->insertGetId([
            'firstName' => 'Michael',
            'lastName' => 'Ingram',
            'phone' => $faker->e164PhoneNumber,
            'street1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'country' => 'US',
            'role' => 'investor',
            'email' => 'mike@ef.com',
            'password' => bcrypt('mike@ef.com'),
            'user_id' => $fm_id,
            'created_at' => Carbon::now()->subMonths(23)
        ]);


        $investor_id = DB::table('users')->insertGetId([
            'firstName' => 'Martin',
            'lastName' => 'Allen',
            'phone' => $faker->e164PhoneNumber,
            'street1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'country' => 'US',
            'role' => 'investor',
            'email' => 'martin@ef.com',
            'password' => bcrypt('martin@ef.com'),
            'user_id' => $fm_id,
            'created_at' => Carbon::now()->subMonths(23)
        ]);
        // for($k = 1; $k<=15; $k++){
        //     $id = DB::table('users')->insertGetId([
        //         'firstName' => $faker->firstName,
        //         'lastName' => $faker->lastName,
        //         'phone' => $faker->e164PhoneNumber,
        //         'street1' => $faker->streetAddress,
        //         'city' => $faker->city,
        //         'state' => $faker->stateAbbr,
        //         'zip' => $faker->postcode,
        //         'country' => 'US',
        //         'role' => 'investor',
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => bcrypt(Str::random(10)),
        //         'user_id' => $fm_id,
        //         'created_at' => Carbon::now()->subMonths(rand(1,12))
        //     ]);
        // }


        // $n = rand(10,30);
        // for($j = 1; $j<=$n; $j++){
        //     $randomNum = rand(9,12);
        //     $fm_id = DB::table('users')->insertGetId([
        //         'firstName' => $faker->firstName,
        //         'lastName' => $faker->lastName,
        //         'phone' => $faker->e164PhoneNumber,
        //         'street1' => $faker->streetAddress,
        //         'city' => $faker->city,
        //         'state' => $faker->stateAbbr,
        //         'zip' => $faker->postcode,
        //         'country' => 'US',
        //         'role' => 'fund-manager',
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => bcrypt(Str::random(10)),
        //         'user_id' => $admin_id,
        //         'created_at' => Carbon::now()->subMonths($randomNum)
        //     ]);

        //     if(rand(1,10)%2==0)
        //         for($k = 1; $k<=15; $k++){
        //             $id = DB::table('users')->insertGetId([
        //                 'firstName' => $faker->firstName,
        //                 'lastName' => $faker->lastName,
        //                 'phone' => $faker->e164PhoneNumber,
        //                 'street1' => $faker->streetAddress,
        //                 'city' => $faker->city,
        //                 'state' => $faker->stateAbbr,
        //                 'zip' => $faker->postcode,
        //                 'country' => 'US',
        //                 'role' => 'investor',
        //                 'email' => $faker->unique()->safeEmail,
        //                 'password' => bcrypt(Str::random(10)),
        //                 'user_id' => $fm_id,
        //                 'created_at' => $k%4==0?Carbon::now()->subDays(rand(0,$randomNum)):Carbon::now()->subMonths(rand(0,$randomNum))
        //             ]);
        //         }
        // }

    }
}
