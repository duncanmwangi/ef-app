<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Investment extends Model
{
    public function investor()
    {
    	return $this->belongsTo('App\User','user_id');
    }
    public function investmentVehicle()
    {
    	return $this->belongsTo('App\InvestmentVehicle','investment_vehicle_id');
    }
    public function getMaturityStatusAttribute()
    {
        return $this->maturity_date->diffInDays(now(), false)<0?'IMMATURE':'MATURE';
    }
    public function getMaturityDateAttribute()
    {
        return $this->created_at->addMonths($this->investmentVehicle->waiting_period);
    }
    
    public function earnings()
    {
        return $this->hasMany('App\Earning','investment_id');
    }

    public function issue_earnings($investmentVehicleReturn)
    {
        //check if already awarded for this return id
        $found = $this->earnings()->where('investment_vehicle_return_id',$investmentVehicleReturn->id)->get()->isNotEmpty();
        
        if($found) return;
        
        //add earnings to db
        $earning = new Earning([
                    'investment_vehicle_return_id' => $investmentVehicleReturn->id,
                    'amount' => $this->amount*($investmentVehicleReturn->percent_return/100),
                    'status' => 'APPROVED',
                    'date_issued' =>  Carbon::now(),
                    'date_approved' => Carbon::now(),
                ]);

        $this->earnings()->save($earning);

        
        echo "\n\r INVESTMENT:\n\r";
        print_r($this);
        echo "\n\r EARNING:\n\r";
        print_r($earning);


        //print_r($investmentVehicleReturn);
    }
}
