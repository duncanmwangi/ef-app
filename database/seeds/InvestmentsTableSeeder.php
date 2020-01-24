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

        $investors = App\User::where('role','investor')->get(); 
        foreach ($investors as $investor) {
            if($investor->id==3){
                DB::table('investments')->insert([
                        'user_id' => $investor->id,
                        'amount' => 10000,
                        'investment_vehicle_id' => App\InvestmentVehicle::where('title','LIKE','%trifecta%')->first()->id,
                        'status' => 'APPROVED',
                        'created_at'=>Carbon::now()->subMonths(23)
                    ]);
            }
            if($investor->id==4){
                DB::table('investments')->insert([
                        'user_id' => $investor->id,
                        'amount' => 10000,
                        'investment_vehicle_id' => App\InvestmentVehicle::where('title','LIKE','%solar%')->first()->id,
                        'status' => 'APPROVED',
                        'created_at'=>Carbon::now()->subMonths(11)
                    ]);
            }
            
        }
    	
     //    for($i = 1; $i<=250; $i++){
     //        $randomNum = rand(1,12);
	    //     DB::table('investments')->insert([
	    //         'amount' => rand(1,10)*1000,
	    //         'user_id' => $i%10==0?App\User::where('role','investor')->where('firstName','LIKE','%Duncan%')->first()->id:App\User::where('role','investor')->get()->random()->id,
	    //         'investment_vehicle_id' => App\InvestmentVehicle::where('status','active')->get()->random()->id,
	    //         'status' => $i%3?'PENDING':'APPROVED',
     //            'created_at'=>$i%60==0?Carbon::now()->subDays(rand(0,$randomNum)):Carbon::now()->subMonths(rand(0,$randomNum))
	    //     ]);
    	// }
    }
}
