<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentVehicleReturns extends Model
{
    public function investmentVehicle()
    {
    	return $this->belongsTo('App\InvestmentVehicle','investment_vehicle_id');
    }
}
