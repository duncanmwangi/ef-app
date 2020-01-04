<?php

namespace App\Http\Controllers\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\InvestmentVehicle;

class InvestmentVehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['investmentVehicles'] = InvestmentVehicle::orderBy('title','asc')->paginate(env('ITEMS_PER_PAGE'));
        return view('investor.investment-vehicles.index',$data);
    }

   
}
