<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\InvestmentVehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvestmentVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investmentVehicles = InvestmentVehicle::orderBy('title','asc')->paginate(env('ITEMS_PER_PAGE'));

        return view('admin.investment-vehicles.index',['investmentVehicles'=>$investmentVehicles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.investment-vehicles.create');
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
                'title' => 'required|min:5|max:50|unique:investment_vehicles',
                'status' => 'required|in:active,suspended',
                'description' => 'nullable|min:2',
                'number_of_terms' => 'required|integer|digits_between:1,3',
                'waiting_period' => 'required|integer|digits_between:1,3',
                'termType' => "required|in:monthly,quarterly,bi-annual,annual",
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );

        $investmentVehicle = new InvestmentVehicle;
        $investmentVehicle->title = $request->title;
        $investmentVehicle->status = $request->status;
        $investmentVehicle->number_of_terms = $request->number_of_terms;
        $investmentVehicle->waiting_period = $request->waiting_period;
        $investmentVehicle->term = $request->termType;
        $investmentVehicle->description = $request->description;

        $investmentVehicle->save();
        return redirect()->route('admin.investment-vehicles.create')->withSuccess('Investment Vehicle has been created successfully');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvestmentVehicle  $investmentVehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestmentVehicle $investmentVehicle)
    {
        return view('admin.investment-vehicles.edit', compact('investmentVehicle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvestmentVehicle  $investmentVehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvestmentVehicle $investmentVehicle)
    {
        $request->validate(
                [
                'title' => ['required','min:5','max:50',Rule::unique('investment_vehicles')->ignore($investmentVehicle->id)],
                'status' => 'required|in:active,suspended',
                'description' => 'nullable|min:2',
                'number_of_terms' => 'required|integer|min:1|max:84',
                'waiting_period' => 'required|integer|min:1|max:84',
                'termType' => "required|in:monthly,quarterly,bi-annual,annual",
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );

        
        $investmentVehicle->title = $request->title;
        $investmentVehicle->status = $request->status;
        $investmentVehicle->number_of_terms = $request->number_of_terms;
        $investmentVehicle->waiting_period = $request->waiting_period;
        $investmentVehicle->term = $request->termType;
        $investmentVehicle->description = $request->description;

        $investmentVehicle->save();

        return redirect()->route('admin.investment-vehicles.edit',$investmentVehicle)->withSuccess('Investment Vehicle has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvestmentVehicle  $investmentVehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvestmentVehicle $investmentVehicle)
    {
        return redirect()->route('admin.investment-vehicles.index')->withError('Currently deleting investment vehicle is disabled');
    }

    public function fieldNames()
    {
        return [
            'number_of_terms'=> 'Number Of Terms',
            'waiting_period'=> 'Waiting Period',
            'termType'=> 'Term Type',
        ];
    }

    public function customValidationMessages()
    {
        return [

        ];
    }
}
