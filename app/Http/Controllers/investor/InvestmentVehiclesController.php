<?php

namespace App\Http\Controllers\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\InvestmentVehicle;
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
        $investor_id = auth()->user()->id;

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
        $p_investments_sql = DB::raw("(SELECT IFNULL(count(i.id),0) as num, IFNULL(sum(i.amount),0) as amount,i.investment_vehicle_id FROM investments as i WHERE i.status='APPROVED' AND i.user_id = $investor_id  GROUP BY i.investment_vehicle_id) as p");
        $investmentVehicles->leftjoin($p_investments_sql,'investment_vehicles.id','=','p.investment_vehicle_id');


        if ($validator->fails()) {
            return redirect('investor.investment-vehicles.index')->withErrors($validator);
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
        
        
        if($sort=='id'){
            $asc_desc = 'ASC';
        }elseif($sort=='-id'){
            $sort = 'id';
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
        
        

        $investmentVehicles = $investmentVehicles->orderBy(DB::raw($sort),$asc_desc)->paginate(env('ITEMS_PER_PAGE'));

        $data['investmentVehicles'] = $investmentVehicles;
        $data['filterArray'] = $filterArray;



        return view('investor.investment-vehicles.index',$data);
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
