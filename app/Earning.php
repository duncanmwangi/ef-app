<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
	protected $fillable = ['investment_vehicle_return_id','amount','status','date_issued','date_approved'];

    public function investment()
    {
    	return $this->belongsTo('App\Investment','investment_id');
    }
    public function investmentVehicleReturn()
    {
    	return $this->belongsTo('App\InvestmentVehicleReturn','investment_vehicle_return_id');
    }
}
