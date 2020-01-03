<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Investment;
use App\User;
use App\InvestmentVehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvestmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investments = Investment::latest()->paginate(env('ITEMS_PER_PAGE'));

        return view('admin.investments.index',['investments'=>$investments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['investors'] = User::where('role','investor')->get();
        $data['investmentVehicles'] = InvestmentVehicle::where('status','active')->get();
        return view('admin.investments.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
                [
                'user_id' => 'required|exists:users,id',
                'investment_vehicle_id' => 'required|exists:investment_vehicles,id',
                'amount' => 'numeric|min:0',
                'status' => 'required|in:PENDING,PROCESSING,APPROVED,DECLINED',
                'admin_notes' => 'nullable',
                'investor_notes' => "nullable",
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );
        $investment = new Investment;
        $investment->user_id = $request->user_id;
        $investment->investment_vehicle_id = $request->investment_vehicle_id;
        $investment->amount = $request->amount;
        $investment->admin_notes = $request->admin_notes;
        $investment->status = $request->status;
        $investment->investor_notes = $request->investor_notes;

        $investment->save();
        return redirect()->route('admin.investments.create')->withSuccess('Investment has been created successfully');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {
        $data['investment'] = $investment;
        $data['investors'] = User::where('role','investor')->get();
        $data['investmentVehicles'] = InvestmentVehicle::where('status','active')->get();
        return view('admin.investments.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Investment $investment)
    {
        $request->validate(
                [
                'user_id' => 'required|exists:users,id',
                'investment_vehicle_id' => 'required|exists:investment_vehicles,id',
                'amount' => 'numeric|min:0',
                'status' => 'required|in:PENDING,PROCESSING,APPROVED,DECLINED',
                'admin_notes' => 'nullable',
                'investor_notes' => "nullable",
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );
        
        $investment->user_id = $request->user_id;
        $investment->investment_vehicle_id = $request->investment_vehicle_id;
        $investment->amount = $request->amount;
        $investment->admin_notes = $request->admin_notes;
        $investment->status = $request->status;
        $investment->investor_notes = $request->investor_notes;

        $investment->save();

        return redirect()->route('admin.investments.edit',$investment)->withSuccess('Investment has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {
        return redirect()->route('admin.investments.index')->withError('Currently deleting investment is disabled');
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
