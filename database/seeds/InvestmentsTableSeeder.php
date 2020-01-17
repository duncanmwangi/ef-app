<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class InvestmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        for($i = 1; $i<=250; $i++){
            $randomNum = rand(1,12);
	        DB::table('investments')->insert([
	            'amount' => rand(1,99)*1000,
	            'user_id' => $i%6==0?App\User::where('role','investor')->where('firstName','LIKE','%Duncan%')->first()->id:App\User::where('role','investor')->get()->random()->id,
	            'investment_vehicle_id' => App\InvestmentVehicle::where('status','active')->get()->random()->id,
	            'status' => $i%3?'PENDING':'APPROVED',
                'created_at'=>$i%60==0?Carbon::now()->subDays(rand(0,$randomNum)):Carbon::now()->subMonths(rand(0,$randomNum))
	        ]);
    	}
    }
}
