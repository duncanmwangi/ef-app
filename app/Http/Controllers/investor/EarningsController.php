<?php

namespace App\Http\Controllers\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Earning;

class EarningsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $earnings = auth()->user()->earnings()->latest()->paginate(env('ITEMS_PER_PAGE'));
        return view('investor.earnings.index',['earnings'=>$earnings]);
    }
}
