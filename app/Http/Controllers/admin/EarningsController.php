<?php

namespace App\Http\Controllers\admin;

use App\Earning;
use App\User;
use App\InvestmentVehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EarningsController extends Controller
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
            'fund_manager' => 'nullable|exists:users,id',
            'investor' => 'nullable|exists:users,id',
            'investment_vehicle' => 'nullable|exists:investment_vehicles,id',
            'amount_operation' => 'nullable|in:equal,less_than,less_than_or_equal,greater_than,greater_than_or_equal_to',
            'amount' => 'nullable|integer|digits_between:1,10',
            'status' => 'nullable|in:ISSUED,APPROVED,DECLINED',
            'issue_from' => 'nullable|date|date_format:m/d/Y|before_or_equal:today',
            'issue_to' => 'nullable|date|date_format:m/d/Y|before_or_equal:today',
        ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );

        $filterArray = [];

        $earnings = Earning::leftJoin('investments', 'investments.id', '=', 'earnings.investment_id')
            ->leftJoin('users', 'users.id', '=', 'investments.user_id')
            ->leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
            ->select('earnings.*');

        $fund_manager = $request->input('fund_manager');
        $investor = $request->input('investor');
        $investment_vehicle = $request->input('investment_vehicle');

        $amount_operation = $request->input('amount_operation');
        $amount = $request->input('amount');

        $status = $request->input('status');

        $issue_from = $request->input('issue_from');
        $issue_to = $request->input('issue_to');

        $sort = $request->input('sort');

        if ($validator->fails()) {
            return redirect(route('admin.earnings.index'))->withErrors($validator);
        }else{
            


            if(!empty($fund_manager)){
                $earnings->where('users.user_id','=',$fund_manager);
                $filterArray['fund_manager'] = $fund_manager;
                $data['investors'] = User::find($fund_manager)->investors;
            }
            if(!empty($investor)){
                $earnings->where('investments.user_id','=',$investor);
                $filterArray['investorinvestor'] = $investor;
            }
            if(!empty($investment_vehicle)){
                $earnings->where('investments.investment_vehicle_id','=',$investment_vehicle);
                $filterArray['investment_vehicle'] = $investment_vehicle;
            }
            if(!empty($status)){
                $earnings->where('earnings.status','=',$status);
                $filterArray['status'] = $status;
            }
            
            if(!empty($amount) && !empty($amount_operation)){
                $filterArray['amount'] = $amount;
                $filterArray['amount_operation'] = $amount_operation;
                $amount_operation = sign_to_db($amount_operation);
                $earnings->where('earnings.amount',$amount_operation,$amount);
            }

            

            if(!empty($issue_from)){
                $earnings->where('earnings.date_issued','>=',$issue_from);
                $filterArray['issue_from'] = $issue_from;
            }


            if(!empty($issue_to)){
                $earnings->where('earnings.date_issued','<=',$issue_to);
                $filterArray['issue_to'] = $issue_to;
            }




        }

        $sortable = ['id','-id','investmentID','-investmentID','name','-name','title','-title','INVamount','-INVamount','status','-status','issue','-issue','percent','-percent','amount','-amount'];

        $sort = !empty($sort) && in_array($sort, $sortable) ?$sort:'-id';

        $filterArray['sort'] = $sort;
        $asc_desc = 'DESC';
        if($sort=='id'){
            $sort = 'earnings.id';
            $asc_desc = 'ASC';
        }elseif($sort=='-id'){
            $sort = 'earnings.id';
        }
        
        if($sort=='investmentID'){
            $sort = 'investments.id';
            $asc_desc = 'ASC';
        }elseif($sort=='-investmentID'){
            $sort = 'investments.id';
        }
        
        if($sort=='name'){
            $sort = 'users.firstName';
            $asc_desc = 'ASC';
        }elseif($sort=='-name'){
            $sort = 'users.firstName';
        }
        
        if($sort=='title'){
            $sort = 'investment_vehicles.title';
            $asc_desc = 'ASC';
        }elseif($sort=='-title'){
            $sort = 'investment_vehicles.title';
        }
        
        if($sort=='INVamount'){
            $sort = 'investments.amount';
            $asc_desc = 'ASC';
        }elseif($sort=='-INVamount'){
            $sort = 'investments.amount';
        }
        
        if($sort=='status'){
            $sort = 'earnings.status';
            $asc_desc = 'ASC';
        }elseif($sort=='-status'){
            $sort = 'earnings.status';
        }
        
        if($sort=='issue'){
            $sort = 'earnings.date_issued';
            $asc_desc = 'ASC';
        }elseif($sort=='-issue'){
            $sort = 'earnings.date_issued';
        }
        
        if($sort=='percent'){
            $sort = '(earnings.amount*100/investments.amount)';
            $asc_desc = 'ASC';
        }elseif($sort=='-percent'){
            $sort = '(earnings.amount*100/investments.amount)';
        }

        if($sort=='amount'){
            $sort = 'earnings.amount';
            $asc_desc = 'ASC';
        }elseif($sort=='-amount'){
            $sort = 'earnings.amount';
        }

        $stats = [];

        $stats_earnings_obj = clone $earnings;
        $stats['earnings'] = $stats_earnings_obj->count();

        $stats_earnings_amount_obj = clone $earnings;
        $stats['earnings_amount'] = $stats_earnings_amount_obj->sum('earnings.amount');

        $stats_investments_obj = clone $earnings;
        $stats['investments'] = $stats_investments_obj->groupBy('investments.id')->count();

        $stats_investments_amount_obj = clone $earnings;
        $stats['investments_amount'] = $stats_investments_amount_obj->groupBy('investments.id')->sum('investments.amount');

        $stats['average_earning'] = $stats['earnings']==0?0:$stats['earnings_amount']/$stats['earnings'];

        $stats['average_investment'] = $stats['investments']==0?0:$stats['investments_amount']/$stats['investments'];

        $stats['average_roi'] = $stats['average_investment']==0?0:$stats['average_earning']*100/$stats['average_investment'];


        $data['earnings'] = $earnings->orderBy(DB::raw($sort),$asc_desc)->paginate(env('ITEMS_PER_PAGE'));

        $data['investmentVehicles'] = InvestmentVehicle::where('status','active')->orderBy('title','ASC')->get();

        $data['fundManagers'] = User::allFundManagers();

        $data['filterArray'] = $filterArray;

        $data['stats'] = (object)$stats;

        return view('admin.earnings.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function show(Earning $earning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function edit(Earning $earning)
    {
        $data['earning'] = $earning;
        return view('admin.earnings.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Earning $earning)
    {
        $request->validate(
                [
                'amount' => 'required|numeric|min:0',
                'status' => 'required|in:ISSUED,APPROVED,DECLINED',
                'admin_notes' => 'nullable',
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );
        
        $earning->amount = $request->amount;
        $earning->status = $request->status;
        $earning->admin_notes = $request->admin_notes;

        $earning->save();

        return redirect()->route('admin.earnings.edit',$earning)->withSuccess('Earning has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Earning $earning)
    {
        return redirect()->route('admin.earnings.index')->withError('Currently deleting earnings is disabled');
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
