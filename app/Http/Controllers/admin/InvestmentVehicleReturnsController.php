<?php

namespace App\Http\Controllers\admin;

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

        return view('admin.investment-vehicle-returns.index',['investmentVehicleReturns'=>$investmentVehicleReturns,'investmentVehicle'=>$investmentVehicle]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InvestmentVehicle $investmentVehicle)
    {
        
        return view('admin.investment-vehicle-returns.create',['investmentVehicle'=>$investmentVehicle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, InvestmentVehicle $investmentVehicle)
    {
        $request->validate(
                [
                'title' => 'required|min:5|max:50',
                'date_to_issue' => 'required|date|date_format:m/d/Y|after:yesterday',
                'percent_return' => 'numeric|min:0|max:100',
                'status' => 'required|in:PENDING,ISSUED',
                'admin_notes' => 'nullable',
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );
        $investmentVehicleReturn = new InvestmentVehicleReturn;
        $investmentVehicleReturn->title = $request->title;
        $investmentVehicleReturn->date_to_issue = Carbon::createFromFormat('m/d/Y',$request->date_to_issue);
        $investmentVehicleReturn->status = $request->status;
        $investmentVehicleReturn->admin_notes = $request->admin_notes;
        $investmentVehicleReturn->percent_return = $request->percent_return;
        $investmentVehicleReturn->investment_vehicle_id =$investmentVehicle->id;

        $investmentVehicleReturn->save();
        return redirect()->route('admin.investment-vehicle-returns.create',$investmentVehicle)->withSuccess('Investment Vehicle Return has been created successfully');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestmentVehicle $investmentVehicle, InvestmentVehicleReturn $investmentVehicleReturn)
    {
        if($investmentVehicle->id!=$investmentVehicleReturn->investment_vehicle_id) return redirect()->back()->withError('Requested resource was not found');

        $data['investmentVehicle'] = $investmentVehicle;
        $data['investmentVehicleReturn'] = $investmentVehicleReturn;
        return view('admin.investment-vehicle-returns.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,InvestmentVehicle $investmentVehicle, InvestmentVehicleReturn $investmentVehicleReturn)
    {
        if($investmentVehicle->id!=$investmentVehicleReturn->investment_vehicle_id) return redirect()->back()->withError('Requested resource was not found');

        $request->validate(
                [
                'title' => 'required|min:5|max:50',
                'date_to_issue' => 'required|date|date_format:m/d/Y|after:yesterday',
                'percent_return' => 'numeric|min:0|max:100',
                'status' => 'required|in:PENDING,ISSUED',
                'admin_notes' => 'nullable',
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );
        
        $investmentVehicleReturn->title = $request->title;
        $investmentVehicleReturn->date_to_issue = Carbon::createFromFormat('m/d/Y',$request->date_to_issue);
        $investmentVehicleReturn->status = $request->status;
        $investmentVehicleReturn->admin_notes = $request->admin_notes;
        $investmentVehicleReturn->percent_return = $request->percent_return;
        $investmentVehicleReturn->investment_vehicle_id =$investmentVehicle->id;

        $investmentVehicleReturn->save();

        return redirect()->route('admin.investment-vehicle-returns.edit',[$investmentVehicle,$investmentVehicleReturn])->withSuccess('Investment Vehicle Return has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvestmentVehicle $investmentVehicle, InvestmentVehicleReturn $investmentVehicleReturn)
    {
        if($investmentVehicle->id!=$investmentVehicleReturn->investment_vehicle_id) return redirect()->back()->withError('Requested resource was not found');

        return redirect()->route('admin.investment-vehicle-returns.index',$investmentVehicle)->withError('Currently deleting Investment Vehicle Return is disabled');
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
