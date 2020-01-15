<?php

namespace App\Http\Controllers\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Investment;
use App\User;
use App\InvestmentVehicle;
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

        $investments->where('investments.user_id','=',auth()->user()->id);

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
            return redirect(route('investor.investments.index'))->withErrors($validator);
        }else{
            
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
                $investments->whereRaw("DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH) ".($maturity_status=='MATURE'?'<=':'>=')." now() ");
                $filterArray['maturity_status'] = $maturity_status;
            }



        }

        $sortable = ['id','-id','investmentVehicle','-investmentVehicle','status','-status','maturityStatus','-maturityStatus','maturityDate','-maturityDate','amount','-amount','created_at','-created_at'];

        $sort = !empty($sort) && in_array($sort, $sortable) ?$sort:'id';

        $filterArray['sort'] = $sort;
        $asc_desc = 'DESC';
        if($sort=='id'){
            $sort = 'investments.id';
            $asc_desc = 'ASC';
        }elseif($sort=='-id'){
            $sort = 'investments.id';
        }
        if($sort=='investmentVehicle'){
            $sort = 'investment_vehicles.title';
            $asc_desc = 'ASC';
        }elseif($sort=='-investmentVehicle'){
            $sort = 'investment_vehicles.title';
        }

        if($sort=='maturityDate'){
            $sort = 'DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)';
            $asc_desc = 'ASC';
        }elseif($sort=='-maturityDate'){
            $sort = 'DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)';
        }


        if($sort=='maturityStatus'){
            $sort = 'TIMESTAMPDIFF(DAY,DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH) , now())';
            $asc_desc = 'ASC';
        }elseif($sort=='-maturityStatus'){
            $sort = 'TIMESTAMPDIFF(DAY,DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH) , now())';
        }


        

        $data['investments'] = $investments->orderBy(DB::raw($sort),$asc_desc)->paginate(env('ITEMS_PER_PAGE'));

        $data['investmentVehicles'] = InvestmentVehicle::where('status','active')->orderBy('title','ASC')->get();

        $data['fundManagers'] = User::allFundManagers();

        $data['filterArray'] = $filterArray;

        return view('investor.investments.index',$data);
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
