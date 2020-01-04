<?php

namespace App\Http\Controllers\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Investment;

class InvestmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investments = auth()->user()->investments()->latest()->paginate(env('ITEMS_PER_PAGE'));

        return view('investor.investments.index',['investments'=>$investments]);
    }

}
