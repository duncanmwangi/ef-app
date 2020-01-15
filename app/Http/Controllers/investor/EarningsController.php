<?php

namespace App\Http\Controllers\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Earning;
use App\User;
use App\InvestmentVehicle;
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

        $earnings->where('investments.user_id','=',auth()->user()->id);

        $investment_vehicle = $request->input('investment_vehicle');

        $amount_operation = $request->input('amount_operation');
        $amount = $request->input('amount');

        $status = $request->input('status');

        $issue_from = $request->input('issue_from');
        $issue_to = $request->input('issue_to');

        $sort = $request->input('sort');

        if ($validator->fails()) {
            return redirect(route('investor.earnings.index'))->withErrors($validator);
        }else{
            
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

        $sortable = ['id','-id','investmentID','-investmentID','title','-title','INVamount','-INVamount','status','-status','issue','-issue','percent','-percent','amount','-amount'];

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



        

        $data['earnings'] = $earnings->orderBy(DB::raw($sort),$asc_desc)->paginate(env('ITEMS_PER_PAGE'));

        $data['investmentVehicles'] = InvestmentVehicle::where('status','active')->orderBy('title','ASC')->get();

        $data['fundManagers'] = User::allFundManagers();

        $data['filterArray'] = $filterArray;

        return view('investor.earnings.index',$data);
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
