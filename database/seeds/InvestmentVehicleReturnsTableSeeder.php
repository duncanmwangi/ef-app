<?php

use Illuminate\Database\Seeder;

class InvestmentVehicleReturnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $investmentVehicles = App\InvestmentVehicle::all();
        foreach ($investmentVehicles as $investmentVehicle) {
        	$months = $investmentVehicle->created_at->diffInMonths(now());
        	for($i=2; $i<$months;$i++){
        		$investmentVehicleReturn = new App\InvestmentVehicleReturn;
        		$investmentVehicleReturn->percent_return = rand(100,2000)/100;
        		$investmentVehicleReturn->status = 'PENDING';
        		$investmentVehicleReturn->date_to_issue = $investmentVehicle->created_at->addMonths($i);
        		$investmentVehicleReturn->created_at = $investmentVehicle->created_at->addMonths($i);
        		$investmentVehicleReturn->investment_vehicle_id = $investmentVehicle->id;
        		$investmentVehicleReturn->title = 'Earning for '.formatDate($investmentVehicle->created_at->addMonths($i),' F Y ');
        		$investmentVehicleReturn->save();
        	}
        }
    }
}
