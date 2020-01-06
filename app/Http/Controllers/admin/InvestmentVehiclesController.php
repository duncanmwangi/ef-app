<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\InvestmentVehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class InvestmentVehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->query('title');
        $termType = $request->query('termType');
        $status = $request->query('status');
        $waiting_period_operation = $request->query('waiting_period_operation');
        $waiting_period = $request->query('waiting_period');
        $number_of_terms_operation = $request->query('number_of_terms_operation');
        $number_of_terms = $request->query('number_of_terms');
        $sort = $request->query('sort');

        $filterArray = [];
        $investmentVehicles = InvestmentVehicle::select('*');
        if(!empty($title)){
            $investmentVehicles->where('title','LIKE',"%$title%");
            $filterArray['title'] = $title;
        }
        if(!empty($termType)){
            $investmentVehicles->where('term',$termType);
            $filterArray['termType'] = $termType;
        }
        if(!empty($status)){
            $investmentVehicles->where('status',$status);
            $filterArray['status'] = $status;
        }
        if(!empty($waiting_period) && !empty($waiting_period_operation)){
            $filterArray['waiting_period'] = $waiting_period;
            $filterArray['waiting_period_operation'] = $waiting_period_operation;
            $waiting_period_operation = $this->sign_to_db($waiting_period_operation);
            $investmentVehicles->where('waiting_period',$waiting_period_operation,$waiting_period);
        }
        if(!empty($number_of_terms) && !empty($waiting_period_operation)){
            $filterArray['number_of_terms'] = $number_of_terms;
            $filterArray['waiting_period_operation'] = $waiting_period_operation;
            $number_of_terms_operation = $this->sign_to_db($number_of_terms_operation);
            $investmentVehicles->where('number_of_terms',$number_of_terms_operation,$number_of_terms);
        }

        $sortable = ['id','id','title','-title','status','-status','waiting_period','-waiting_period','term','-term','created_at','-created_at','number_of_terms','-number_of_terms'];

        $sort = !empty($sort) && in_array($sort, $sortable) ?$sort:'title';

        $filterArray['sort'] = $sort;




        // $request->validate(
        //         [
        //         'title' => 'nullable|min:5|max:50|unique:investment_vehicles',
        //         'status' => 'nullable|in:active,suspended',
        //         'waiting_period_operation' => 'nullable|in:equal,less_than,less_than_or_equal,greater_than,greater_than_or_equal_to',
        //         'waiting_period' => 'nullable|integer|digits_between:1,3',
        //         'number_of_terms_operation' => 'nullable|in:equal,less_than,less_than_or_equal,greater_than,greater_than_or_equal_to',
        //         'waiting_period' => 'nullable|integer|digits_between:1,3',
        //         'termType' => "nullable|in:monthly,quarterly,bi-annual,annual",
        //     ],
        //     $this->customValidationMessages(), 
        //     $this->fieldNames()
        // );

        $investmentVehicles = $investmentVehicles->orderBy(DB::raw($sort),'DESC')->paginate(env('ITEMS_PER_PAGE'));

        return view('admin.investment-vehicles.index',['investmentVehicles'=>$investmentVehicles,'filterArray'=>$filterArray]);
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

    public function sign_to_db($operation='')
    {
        $sign = ''; 
        switch ($operation) {
            case 'equal':
                $sign = '=';
                break;
            case 'less_than':
                $sign = '<';
                break;
            case 'less_than_or_equal':
                $sign = '<=';
                break;
            case 'greater_than':
                $sign = '>';
                break;
            case 'greater_than_or_equal_to':
                $sign = '>=';
                break;
            
            default:
                $sign = '=';
                break;
        }
        return $sign;
    }
}
