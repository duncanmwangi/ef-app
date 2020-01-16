<?php

namespace App\Http\Controllers\fm;

use App\Http\Controllers\Controller;
use App\Investment;
use App\User;
use App\InvestmentVehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvestmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterArray = [];

        $validator = Validator::make($request->all(), [
            'investor' => 'nullable|exists:users,id',
            'investment_vehicle' => 'nullable|exists:investment_vehicles,id',
            'amount_operation' => 'nullable|in:equal,less_than,less_than_or_equal,greater_than,greater_than_or_equal_to',
            'amount' => 'nullable|integer|digits_between:1,10',
            'maturity_status' => 'nullable|in:MATURE,IMMATURE',
            'investmentStatus' => "nullable|in:PENDING,PROCESSING,APPROVED,DECLINED",
            'maturity_from' => 'nullable|date|date_format:m/d/Y',
            'maturity_to' => 'nullable|date|date_format:m/d/Y',
            'date_created_from' => 'nullable|date|date_format:m/d/Y|before_or_equal:today',
            'date_created_to' => 'nullable|date|date_format:m/d/Y|before_or_equal:today',
        ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );

        $filterArray = [];

        $investments = Investment::leftJoin('users', 'users.id', '=', 'investments.user_id')
            ->leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
            ->select('investments.*');

        $investments->where('users.user_id','=',auth()->user()->id);

        $investor = $request->input('investor');

        $investment_vehicle = $request->input('investment_vehicle');

        $amount_operation = $request->input('amount_operation');
        $amount = $request->input('amount');

        $maturity_status = $request->input('maturity_status');
        $maturity_from = $request->input('maturity_from');
        $maturity_to = $request->input('maturity_to');

        $investmentStatus = $request->input('investmentStatus');

        $date_created_from = $request->input('date_created_from');
        $date_created_to = $request->input('date_created_to');
        $sort = $request->input('sort');

        if ($validator->fails()) {
            return redirect(route('admin.investments.index'))->withErrors($validator);
        }else{
            
            if(!empty($investor)){
                $investments->where('investments.user_id','=',$investor);
                $filterArray['investorinvestor'] = $investor;
            }
            if(!empty($investment_vehicle)){
                $investments->where('investments.investment_vehicle_id','=',$investment_vehicle);
                $filterArray['investment_vehicle'] = $investment_vehicle;
            }
            if(!empty($investmentStatus)){
                $investments->where('investments.status','=',$investmentStatus);
                $filterArray['investmentStatus'] = $investmentStatus;
            }
            if(!empty($amount) && !empty($amount_operation)){
                $filterArray['amount'] = $amount;
                $filterArray['amount_operation'] = $amount_operation;
                $amount_operation = sign_to_db($amount_operation);
                $investments->where('amount',$amount_operation,$amount);
            }

            

            if(!empty($date_created_from)){
                $investments->where('investments.created_at','>=',$date_created_from);
                $filterArray['date_created_from'] = $date_created_from;
            }


            if(!empty($date_created_to)){
                $investments->where('investments.created_at','<=',$date_created_to);
                $filterArray['date_created_to'] = $date_created_to;
            }



            if(!empty($maturity_from)){
                $filterArray['maturity_from'] = $maturity_from;
                $maturity_from = Carbon::parse($maturity_from)->format('Y-m-d');
                $investments->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) >= date('$maturity_from') ");
               // dd($investments->toSql());
            }

            if(!empty($maturity_to)){
                $filterArray['maturity_to'] = $maturity_to;
                $maturity_to = Carbon::parse($maturity_to)->format('Y-m-d');
                $investments->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) <= date('$maturity_to') ");
            }


            if(!empty($maturity_status)){
                $investments->whereRaw("DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH) ".($maturity_status=='MATURE'?'<=':'>')." now() ");
                $filterArray['maturity_status'] = $maturity_status;
            }



        }

        $sortable = ['id','-id','investorName','-investorName','investorID','-investorID','investmentVehicle','-investmentVehicle','status','-status','maturityStatus','-maturityStatus','maturityDate','-maturityDate','amount','-amount','created_at','-created_at'];

        $sort = !empty($sort) && in_array($sort, $sortable) ?$sort:'id';

        $filterArray['sort'] = $sort;
        $asc_desc = 'DESC';
        if($sort=='id'){
            $sort = 'investments.id';
            $asc_desc = 'ASC';
        }elseif($sort=='-id'){
            $sort = '-investments.id';
        }
        if($sort=='investorID'){
            $sort = 'investments.user_id';
        }elseif($sort=='-investorID'){
            $sort = '-investments.user_id';
        }
        if($sort=='investmentVehicle'){
            $sort = 'investment_vehicles.title';
            $asc_desc = 'ASC';
        }elseif($sort=='-investmentVehicle'){
            $sort = 'investment_vehicles.title';
        }
        if($sort=='investorName'){
            $sort = 'users.firstName';
            $asc_desc = 'ASC';
        }elseif($sort=='-investorName'){
            $sort = 'users.firstName';
        }

        if($sort=='maturityDate'){
            $sort = 'DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)';
            $asc_desc = 'ASC';
        }elseif($sort=='-maturityDate'){
            $sort = 'DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)';
            $asc_desc = 'DESC';
        }


        if($sort=='maturityStatus'){
            $sort = 'TIMESTAMPDIFF(DAY,DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH) , now())';
            $asc_desc = 'ASC';
        }elseif($sort=='-maturityStatus'){
            $sort = 'TIMESTAMPDIFF(DAY,DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH) , now())';
            $asc_desc = 'DESC';
        }


        $stats = [];

        $stats_investments_obj = clone $investments;
        $stats['investments'] = $stats_investments_obj->count();

        $stats_investments_amount_obj = clone $investments;
        $stats['investments_amount'] = $stats_investments_amount_obj->sum('investments.amount');

        $stats_mature_investments_obj = clone $investments;
        $stats['mature_investments'] = $stats_mature_investments_obj->whereRaw("DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)<=now()")->count();

        $stats_mature_investments_amount_obj = clone $investments;
        $stats['mature_investments_amount'] = $stats_mature_investments_amount_obj->whereRaw("DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)<=now()")->sum('investments.amount');

        $stats_immature_investments_obj = clone $investments;
        $stats['immature_investments'] = $stats_immature_investments_obj->whereRaw("DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)>now()")->count();

        $stats_immature_investments_amount_obj = clone $investments;
        $stats['immature_investments_amount'] = $stats_immature_investments_amount_obj->whereRaw("DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)>now()")->sum('investments.amount');


        $data['investments'] = $investments->orderBy(DB::raw($sort),$asc_desc)->paginate(env('ITEMS_PER_PAGE'));

        $data['investmentVehicles'] = InvestmentVehicle::where('status','active')->orderBy('title','ASC')->get();

        $data['investors'] = User::find(auth()->user()->id)->investors;

        $data['filterArray'] = $filterArray;

        $data['stats'] = (object)$stats;

        return view('fm.investments.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['investors'] = User::where('role','investor')->where('user_id',auth()->user()->id)->get();
        $data['investmentVehicles'] = InvestmentVehicle::where('status','active')->get();
        return view('fm.investments.create',$data);
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

        if(User::find($request->user_id)->user_id != auth()->user()->id) return redirect()->route('fm.investments.create')->withError('You can only add investments to investors under this account');

        $investment = new Investment;
        $investment->user_id = $request->user_id;
        $investment->investment_vehicle_id = $request->investment_vehicle_id;
        $investment->amount = $request->amount;
        $investment->admin_notes = $request->admin_notes;
        $investment->status = $request->status;
        $investment->investor_notes = $request->investor_notes;

        $investment->save();
        return redirect()->route('fm.investments.create')->withSuccess('Investment has been created successfully');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {


        if(User::find($investment->user_id)->user_id != auth()->user()->id) return redirect()->route('fm.investments.index')->withError('You can only edit investments to investors under this account');

        $data['investment'] = $investment;
        $data['investors'] = User::where('role','investor')->where('user_id',auth()->user()->id)->get();
        $data['investmentVehicles'] = InvestmentVehicle::where('status','active')->get();
        return view('fm.investments.edit', $data);
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
        
        if(User::find($request->user_id)->user_id != auth()->user()->id) return redirect()->route('fm.investments.index')->withError('You can only update investments to investors under this account');

        $investment->user_id = $request->user_id;
        $investment->investment_vehicle_id = $request->investment_vehicle_id;
        $investment->amount = $request->amount;
        $investment->admin_notes = $request->admin_notes;
        $investment->status = $request->status;
        $investment->investor_notes = $request->investor_notes;

        $investment->save();

        return redirect()->route('fm.investments.edit',$investment)->withSuccess('Investment has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {

        if(User::find($investment->user_id)->user_id != auth()->user()->id) return redirect()->route('fm.investments.index')->withError('You can only add investments to investors under this account');

        return redirect()->route('fm.investments.index')->withError('Currently deleting investment is disabled');
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
