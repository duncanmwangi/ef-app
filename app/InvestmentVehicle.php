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
        return $this->hasMany('App\InvestmentVehicleReturn','investment_vehicle_id');
    }

    public function mature_investments()
    {
        return $this->investments()->whereRaw(' DATE_ADD(created_at,INTERVAL ? MONTH) < NOW() ',$this->waiting_period);
    }
}
