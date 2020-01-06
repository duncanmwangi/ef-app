<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

use Carbon\Carbon;

class InvestmentVehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
    	for($i = 1; $i<=15; $i++){
	        DB::table('investment_vehicles')->insert([
	            'title' => $faker->sentence(rand(2,4)),
	            'description' => $faker->paragraph(),
	            'status' => 'active',
	            'term' => $i%3==0?'quarterly':'monthly',
	            'waiting_period' => rand(1,10),
	            'number_of_terms' => rand(10,36),
                'created_at'=>Carbon::now()->subMonths(rand(1,15))
	        ]);
    	}
    }
}
