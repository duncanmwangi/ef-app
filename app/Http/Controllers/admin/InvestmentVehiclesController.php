<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\InvestmentVehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class InvestmentVehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|min:5|max:50|unique:investment_vehicles',
            'status' => 'nullable|in:active,suspended',
            'waiting_period_operation' => 'nullable|in:equal,less_than,less_than_or_equal,greater_than,greater_than_or_equal_to',
            'waiting_period' => 'nullable|integer|digits_between:1,3',
            'number_of_terms_operation' => 'nullable|in:equal,less_than,less_than_or_equal,greater_than,greater_than_or_equal_to',
            'waiting_period' => 'nullable|integer|digits_between:1,3',
            'termType' => "nullable|in:monthly,quarterly,bi-annual,annual",
            'date_created_from' => 'nullable|date|date_format:m/d/Y|before_or_equal:today',
            'date_created_to' => 'nullable|date|date_format:m/d/Y|before_or_equal:today',
        ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );

        $filterArray = [];

        $investmentVehicles = InvestmentVehicle::select('*');


        if ($validator->fails()) {
            $data['errors'] = $validator;
        }else{
            $title = $request->input('title');
            $termType = $request->input('termType');
            $status = $request->input('status');
            $waiting_period_operation = $request->input('waiting_period_operation');
            $waiting_period = $request->input('waiting_period');
            $number_of_terms_operation = $request->input('number_of_terms_operation');
            $number_of_terms = $request->input('number_of_terms');
            $date_created_from = $request->input('date_created_from');
            $date_created_to = $request->input('date_created_to');
            $sort = $request->input('sort');

            


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


            if(!empty($date_created_from)){
                $investmentVehicles->where('created_at','>=',$date_created_from);
                $filterArray['date_created_from'] = $date_created_from;
            }


            if(!empty($date_created_to)){
                $investmentVehicles->where('created_at','<=',$date_created_to);
                $filterArray['date_created_to'] = $date_created_to;
            }

        }

        $sortable = ['id','-id','title','-title','status','-status','waiting_period','-waiting_period','term','-term','created_at','-created_at','number_of_terms','-number_of_terms'];

        $sort = !empty($sort) && in_array($sort, $sortable) ?$sort:'title';

        $filterArray['sort'] = $sort;

        $investmentVehicles = $investmentVehicles->orderBy(DB::raw($sort),'DESC')->paginate(env('ITEMS_PER_PAGE'));

        $data['investmentVehicles'] = $investmentVehicles;
        $data['filterArray'] = $filterArray;



        return view('admin.investment-vehicles.index',$data);
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
