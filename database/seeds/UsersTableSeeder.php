<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstName' => 'Duncan',
            'lastName' => 'Mwangi',
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
            'lastName' => 'Mwangi',
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
            'lastName' => 'Mwangi',
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
            'lastName' => 'Mwangi',
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
    }
}
