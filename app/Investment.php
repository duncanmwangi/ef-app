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
}
