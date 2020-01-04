<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InvestmentVehicleReturn extends Model
{
    public function investmentVehicle()
    {
    	return $this->belongsTo('App\InvestmentVehicle','investment_vehicle_id');
    }
    public function earnings()
    {
        return $this->hasMany('App\Earning','investment_vehicle_return_id');
    }

    public static function issue_return_earnings()
    {
    	echo "\n\r\n\r\n\r==========cron has started at: ".formatDateTime(Carbon::now())." ============\n\r";
    	$investmentVehicleReturns = InvestmentVehicleReturn::where('status','PENDING')->where('date_to_issue','<',Carbon::now())->get();
    	foreach ($investmentVehicleReturns as $investmentVehicleReturn) { 
    		if($investmentVehicleReturn->investmentVehicle->mature_investments->count()){
    			foreach ($investmentVehicleReturn->investmentVehicle->mature_investments as $investment) {
    				$investment->issue_earnings($investmentVehicleReturn);
    			}
    		}
            $investmentVehicleReturn->mark_return_as_issued();
    	}
    	echo "==========cron has finished at: ".formatDateTime(Carbon::now())." ============\n\r";
    }
    public function mark_return_as_issued()
    {
        $this->status = 'ISSUED';
        $this->date_issued = Carbon::now();
        $this->save();
    }

    public function getAffectedInvestmentsAttribute()
    {
    	if($this->status=='PENDING'){
    		return $this->investmentVehicle->mature_investments->count();
    	}elseif($this->status=='ISSUED'){
    		//return $this->earnings->count();
    	}
    	return 0;
    }


}
