<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class InvestmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        for($i = 1; $i<=15; $i++){
	        DB::table('investments')->insert([
	            'amount' => rand(1,99)*1000,
	            'user_id' => App\User::where('role','investor')->get()->random()->id,
	            'investment_vehicle_id' => App\InvestmentVehicle::where('status','active')->get()->random()->id,
	            'status' => $i%3?'PENDING':'APPROVED',
                'created_at'=>Carbon::now()
	        ]);
    	}
    }
}
