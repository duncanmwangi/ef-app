<?php

namespace App\Http\Controllers\investor;
use App\User;
use App\Investment;
use App\Earning;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$investor_id = auth()->user()->id;

    	$data['dontShowTitle'] = true;
    	$last12MonthsTbl = DB::raw("(SELECT DATE_FORMAT(a.a, '%m-%Y') as month_year,a.a as date FROM  (select Date_add(Now(),interval - 0 month) as a union all select Date_add(Now(),interval - 1 month) as a union all select Date_add(Now(),interval - 2 month) union all select Date_add(Now(),interval - 3 month) union all select Date_add(Now(),interval - 4 month) union all select Date_add(Now(),interval - 5 month) union all select Date_add(Now(),interval - 6 month) union all select Date_add(Now(),interval - 7 month) union all select Date_add(Now(),interval - 8 month) union all select Date_add(Now(),interval - 9 month) union all select Date_add(Now(),interval - 10 month) union all select Date_add(Now(),interval - 11 month)) as a) a");

    	$investmentsTbl = DB::raw("(SELECT DATE_FORMAT(i.created_at, '%m-%Y') as month_year,sum(i.amount) as investments FROM investments as i  WHERE status='APPROVED' AND i.user_id=$investor_id GROUP BY DATE_FORMAT(i.created_at, '%m-%Y') ) i");

    	$chartData = DB::table($last12MonthsTbl)
    						->leftJoin($investmentsTbl,'a.month_year','=','i.month_year')
    						->select(DB::raw("DATE_FORMAT(a.date, '%b %Y') as month_year"),DB::raw('IFNULL(i.investments,0) as investments'))
    						->orderBy('a.date','ASC')
    						->get();
    	$data['investments'] = [];
    	$data['months'] = [];
    	foreach ($chartData as $value) {
    		$data['investments'][] = $value->investments;
    		$data['months'][] = $value->month_year;
    	}
    	$maturity_date = "DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)";

    	$thisMonth['maturing_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    													->where('investments.user_id',$investor_id)
    													->where('investments.status','APPROVED')
    													->whereRaw("MONTH($maturity_date)=MONTH(CURDATE()) AND YEAR($maturity_date)=YEAR(CURDATE())")
    													->count('investments.id');
    	$thisMonth['maturing_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    													->where('investments.user_id',$investor_id)
    													->where('investments.status','APPROVED')
    													->whereRaw("MONTH($maturity_date)=MONTH(CURDATE()) AND YEAR($maturity_date)=YEAR(CURDATE())")
    													->sum('amount');
    	$thisMonth['new_investments'] = Investment::where('investments.user_id',$investor_id)
    													->where('status','APPROVED')
    													->whereRaw("MONTH(investments.created_at)=MONTH(CURDATE()) AND YEAR(investments.created_at)=YEAR(CURDATE())")
    													->count();;
    	$thisMonth['new_investments_amount'] = Investment::where('investments.user_id',$investor_id)
    													->where('status','APPROVED')
    													->whereRaw("MONTH(investments.created_at)=MONTH(CURDATE()) AND YEAR(investments.created_at)=YEAR(CURDATE())")
    													->sum('amount');
    	$data['thisMonth'] = (object)$thisMonth;




    	$allTime['investments'] = Investment::where('investments.user_id',$investor_id)
												->where('status','APPROVED')->count();
    	$allTime['investments_amount'] = Investment::where('investments.user_id',$investor_id)
												->where('status','APPROVED')->sum('amount');
    	$allTime['mature_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    												->where('investments.user_id',$investor_id)
													->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) <= now() ")
											    	->count('investments.id');
    	$allTime['mature_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    												->where('investments.user_id',$investor_id)
													->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) <= now() ")
											    	->sum('amount');
    	$allTime['immature_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    												->where('investments.user_id',$investor_id)
													->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) > now() ")
											    	->count('investments.id');
    	$allTime['immature_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    												->where('investments.user_id',$investor_id)
													->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) > now() ")
											    	->sum('amount');

    	$allTime['earnings'] = Earning::leftJoin('investments','investments.id','=','earnings.investment_id')
    									->where('investments.user_id',$investor_id)->where('earnings.status','APPROVED')
										->count('earnings.id');
    	$allTime['earnings_amount'] = Earning::leftJoin('investments','investments.id','=','earnings.investment_id')
	    									->where('investments.user_id',$investor_id)->where('earnings.status','APPROVED')
											->sum('earnings.amount');
    	$allTime['average_earning'] = $allTime['earnings']>0?$allTime['earnings_amount']/$allTime['earnings']:0;
    	$data['allTime'] = (object)$allTime;

        return view('investor.dashboard',$data);
    }
}
