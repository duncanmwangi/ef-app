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

        $investmentVehicles = InvestmentVehicle::select('investment_vehicles.*','p.num','p.amount');
        $p_investments_sql = DB::raw("(SELECT IFNULL(count(i.id),0) as num, IFNULL(sum(i.amount),0) as amount,i.investment_vehicle_id FROM investments as i WHERE i.status='APPROVED'  GROUP BY i.investment_vehicle_id) as p");
        $investmentVehicles->leftjoin($p_investments_sql,'investment_vehicles.id','=','p.investment_vehicle_id');

        if ($validator->fails()) {
            return redirect('admin.investment-vehicles.index')->withErrors($validator);
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
                $waiting_period_operation = sign_to_db($waiting_period_operation);
                $investmentVehicles->where('waiting_period',$waiting_period_operation,$waiting_period);
            }
            if(!empty($number_of_terms) && !empty($waiting_period_operation)){
                $filterArray['number_of_terms'] = $number_of_terms;
                $filterArray['waiting_period_operation'] = $waiting_period_operation;
                $number_of_terms_operation = sign_to_db($number_of_terms_operation);
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

        $sortable = ['id','-id','title','-title','num','-num','amount','-amount','status','-status','waiting_period','-waiting_period','term','-term','created_at','-created_at','number_of_terms','-number_of_terms'];

        $sort = !empty($sort) && in_array($sort, $sortable) ?$sort:'title';

        $filterArray['sort'] = $sort;
        

        $asc_desc = 'DESC';
       
        
        
        if($sort=='title'){
            $asc_desc = 'ASC';
        }elseif($sort=='-title'){
            $sort = 'title';
        }
        
        
        if($sort=='id'){
            $asc_desc = 'ASC';
        }elseif($sort=='-id'){
            $sort = 'id';
        }
        
        
        if($sort=='num'){
            $asc_desc = 'ASC';
        }elseif($sort=='-num'){
            $sort = 'num';
        }
        
        
        if($sort=='amount'){
            $asc_desc = 'ASC';
        }elseif($sort=='-amount'){
            $sort = 'amount';
        }
        
        
        if($sort=='status'){
            $asc_desc = 'ASC';
        }elseif($sort=='-status'){
            $sort = 'status';
        }
        
        
        if($sort=='waiting_period'){
            $asc_desc = 'ASC';
        }elseif($sort=='-waiting_period'){
            $sort = 'waiting_period';
        }
        
        
        if($sort=='term'){
            $asc_desc = 'ASC';
        }elseif($sort=='-term'){
            $sort = 'term';
        }
        
        
        if($sort=='created_at'){
            $asc_desc = 'ASC';
        }elseif($sort=='-created_at'){
            $sort = 'created_at';
        }
        
        
        if($sort=='number_of_terms'){
            $asc_desc = 'ASC';
        }elseif($sort=='-number_of_terms'){
            $sort = 'number_of_terms';
        }

        $stats = [];

        $stats_investments_obj = clone $investmentVehicles;
        $stats_mature_investments_obj = clone $investmentVehicles;
        $stats_immature_investments_obj = clone $investmentVehicles;
        $stats_earnings_obj = clone $investmentVehicles;
        $stats_returns_obj = clone $investmentVehicles;
        $stats_unissued_returns_obj = clone $investmentVehicles;

        $c_investments_sql = DB::raw("(SELECT count(i.id) as num, sum(i.amount) as amount,i.investment_vehicle_id FROM investments as i WHERE i.status='APPROVED'  GROUP BY i.investment_vehicle_id) as c_investments");
        $investments = $stats_investments_obj->leftjoin($c_investments_sql,'investment_vehicles.id','=','c_investments.investment_vehicle_id');
        $stats['investments'] = $investments->sum('c_investments.num');
        $stats['investments_amount'] = $investments->sum('c_investments.amount');

        $c_mature_investments_sql = DB::raw("(SELECT count(i.id) as num, sum(i.amount) as amount,i.investment_vehicle_id FROM investments as i LEFT JOIN investment_vehicles as iv ON iv.id=i.investment_vehicle_id WHERE  DATE_ADD(i.created_at,INTERVAL iv.waiting_period MONTH) <= now() AND  i.status='APPROVED'  GROUP BY i.investment_vehicle_id) as c_mature_investments");
        $mature_investments = $stats_mature_investments_obj->leftjoin($c_mature_investments_sql,'investment_vehicles.id','=','c_mature_investments.investment_vehicle_id');
        $stats['mature_investments'] = $mature_investments->sum('c_mature_investments.num');
        $stats['mature_investments_amount'] = $mature_investments->sum('c_mature_investments.amount');

        $c_immature_investments_sql = DB::raw("(SELECT count(i.id) as num, sum(i.amount) as amount,i.investment_vehicle_id FROM investments as i LEFT JOIN investment_vehicles as iv ON iv.id=i.investment_vehicle_id WHERE  DATE_ADD(i.created_at,INTERVAL iv.waiting_period MONTH) > now() AND  i.status='APPROVED'  GROUP BY i.investment_vehicle_id) as c_immature_investments");
        $immature_investments = $stats_immature_investments_obj->leftjoin($c_immature_investments_sql,'investment_vehicles.id','=','c_immature_investments.investment_vehicle_id');
        $stats['immature_investments'] = $immature_investments->sum('c_immature_investments.num');
        $stats['immature_investments_amount'] = $immature_investments->sum('c_immature_investments.amount');


        $c_returns_sql = DB::raw("(SELECT count(r.id) as num, sum(percent_return) as roi, r.investment_vehicle_id FROM investment_vehicle_returns as r WHERE r.status='ISSUED' GROUP BY r.investment_vehicle_id) as c_returns");
        $returns = $stats_returns_obj->leftjoin($c_returns_sql,'investment_vehicles.id','=','c_returns.investment_vehicle_id');
        $stats['returns'] = $returns->sum('c_returns.num');
        $sum_roi = $returns->sum('c_returns.roi');
        $stats['average_roi'] = $stats['returns']<=0?0:$sum_roi/$stats['returns'];


        $c_unissued_returns_sql = DB::raw("(SELECT count(r.id) as num, sum(percent_return) as roi, r.investment_vehicle_id FROM investment_vehicle_returns as r WHERE r.status='PENDING' GROUP BY r.investment_vehicle_id) as c_returns");
        $unissued_returns = $stats_unissued_returns_obj->leftjoin($c_unissued_returns_sql,'investment_vehicles.id','=','c_returns.investment_vehicle_id');
        $stats['unissued_returns'] = $unissued_returns->sum('c_returns.num');
        $sum_roi = $unissued_returns->sum('c_returns.roi');
        $stats['unissued_average_roi'] = $stats['unissued_returns']<=0?0:$sum_roi/$stats['unissued_returns'];



        $c_earnings_sql = DB::raw("(SELECT count(e.id) as num, sum(e.amount) as amount,r.investment_vehicle_id FROM earnings as e LEFT JOIN investment_vehicle_returns as r ON r.id=e.investment_vehicle_return_id WHERE  e.status='APPROVED'  GROUP BY r.investment_vehicle_id) as c_earnings");
        $earnings = $stats_earnings_obj->leftjoin($c_earnings_sql,'investment_vehicles.id','=','c_earnings.investment_vehicle_id');
        $stats['earnings'] = $earnings->sum('c_earnings.num');
        $stats['earnings_amount'] = $earnings->sum('c_earnings.amount');

        $investmentVehicles = $investmentVehicles->orderBy(DB::raw($sort),$asc_desc)->paginate(env('ITEMS_PER_PAGE'));

        $data['investmentVehicles'] = $investmentVehicles;

        $data['filterArray'] = $filterArray;

        $data['stats'] = (object)$stats;



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

   
}
