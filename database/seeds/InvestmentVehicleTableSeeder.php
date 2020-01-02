<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class InvestmentVehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($i = 1; $i<=15; $i++){
	        DB::table('investment_vehicles')->insert([
	            'title' => 'Solar Funds Vehicle #'.$i,
	            'description' => 'Solar Funds Vehicle #'.$i,
	            'status' => 'active',
	            'term' => 'monthly',
	            'waiting_period' => 1,
	            'number_of_terms' => 12,
                'created_at'=>Carbon::now()
	        ]);
    	}
    }
}
