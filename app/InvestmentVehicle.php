<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentVehicle extends Model
{
    public function investments()
    {
        return $this->hasMany('App\Investment','investment_vehicle_id');
    }
    public function returns()
    {
        return $this->hasMany('App\InvestmentVehicleReturns','investment_vehicle_id');
    }
}
