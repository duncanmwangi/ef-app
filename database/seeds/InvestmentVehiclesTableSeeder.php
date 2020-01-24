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
        DB::table('investment_vehicles')->insert([
            'title' => 'Solar Funds',
            'description' => 'Solar Funds',
            'status' => 'active',
            'term' => 'monthly',
            'waiting_period' => 12,
            'number_of_terms' => 84,
            'created_at'=>Carbon::now()->subMonths(24)
        ]);
        DB::table('investment_vehicles')->insert([
            'title' => 'Trifecta Elite Fund',
            'description' => 'Trifecta Elite Fund',
            'status' => 'active',
            'term' => 'monthly',
            'waiting_period' => 12,
            'number_of_terms' => 84,
            'created_at'=>Carbon::now()->subMonths(24)
        ]);

    	// for($i = 1; $i<=15; $i++){
	    //     DB::table('investment_vehicles')->insert([
	    //         'title' => $faker->sentence(rand(2,4)),
	    //         'description' => $faker->paragraph(),
	    //         'status' => 'active',
	    //         'term' => $i%3==0?'quarterly':'monthly',
	    //         'waiting_period' => rand(1,10),
	    //         'number_of_terms' => rand(10,36),
     //            'created_at'=>Carbon::now()->subMonths(rand(1,15))
	    //     ]);
    	// }
    }
}
