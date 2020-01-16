<?php

namespace App\Http\Controllers\fm;

use App\Http\Controllers\Controller;
use App\InvestmentVehicleReturn;
use App\User;
use App\InvestmentVehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

class InvestmentVehicleReturnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InvestmentVehicle $investmentVehicle)
    {
        $investmentVehicleReturns = $investmentVehicle->returns()->paginate(env('ITEMS_PER_PAGE'));

        return view('fm.investment-vehicle-returns.index',['investmentVehicleReturns'=>$investmentVehicleReturns,'investmentVehicle'=>$investmentVehicle]);
    }

    
    public function fieldNames()
    {
        return [
        ];
    }

    public function customValidationMessages()
    {
        return [

        ];
    }
}
