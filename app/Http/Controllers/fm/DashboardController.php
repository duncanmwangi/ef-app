<?php

namespace App\Http\Controllers\fm;
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
    	$fm_id = auth()->user()->id;

    	$data['dontShowTitle'] = true;
    	$last12MonthsTbl = DB::raw("(SELECT DATE_FORMAT(a.a, '%m-%Y') as month_year,a.a as date FROM  (select Date_add(Now(),interval - 0 month) as a union all select Date_add(Now(),interval - 1 month) as a union all select Date_add(Now(),interval - 2 month) union all select Date_add(Now(),interval - 3 month) union all select Date_add(Now(),interval - 4 month) union all select Date_add(Now(),interval - 5 month) union all select Date_add(Now(),interval - 6 month) union all select Date_add(Now(),interval - 7 month) union all select Date_add(Now(),interval - 8 month) union all select Date_add(Now(),interval - 9 month) union all select Date_add(Now(),interval - 10 month) union all select Date_add(Now(),interval - 11 month)) as a) a");

    	$investmentsTbl = DB::raw("(SELECT DATE_FORMAT(i.created_at, '%m-%Y') as month_year,sum(i.amount) as investments FROM investments as i LEFT JOIN users as u ON u.id=i.user_id WHERE status='APPROVED' AND u.user_id=$fm_id GROUP BY DATE_FORMAT(i.created_at, '%m-%Y') ) i");

    	$investorsTbl = DB::raw("(SELECT DATE_FORMAT(u.created_at, '%m-%Y') as month_year,count(u.id) as investors FROM users as u WHERE role='investor' AND user_id=$fm_id GROUP BY DATE_FORMAT(u.created_at, '%m-%Y') ) investors");

    	$chartData = DB::table($last12MonthsTbl)
    						->leftJoin($investmentsTbl,'a.month_year','=','i.month_year')
    						->leftJoin($investorsTbl,'a.month_year','=','investors.month_year')
    						->select(DB::raw("DATE_FORMAT(a.date, '%b %Y') as month_year"),DB::raw('IFNULL(i.investments,0) as investments'),DB::raw('IFNULL(investors.investors,0) as investors'))
    						->orderBy('a.date','ASC')
    						->get();
    	$data['investors'] = [];
    	$data['investments'] = [];
    	$data['months'] = [];
    	foreach ($chartData as $value) {
    		$data['investors'][] = $value->investors;
    		$data['investments'][] = $value->investments;
    		$data['months'][] = $value->month_year;
    	}
    	$maturity_date = "DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)";

    	$thisMonth['maturing_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    													->leftJoin('users','users.id','=','investments.user_id')
    													->where('users.user_id',$fm_id)
    													->where('investments.status','APPROVED')
    													->whereRaw("MONTH($maturity_date)=MONTH(CURDATE()) AND YEAR($maturity_date)=YEAR(CURDATE())")
    													->count('investments.id');
    	$thisMonth['maturing_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    													->leftJoin('users','users.id','=','investments.user_id')
    													->where('users.user_id',$fm_id)
    													->where('investments.status','APPROVED')
    													->whereRaw("MONTH($maturity_date)=MONTH(CURDATE()) AND YEAR($maturity_date)=YEAR(CURDATE())")
    													->sum('amount');
    	$thisMonth['new_investments'] = Investment::leftJoin('users','users.id','=','investments.user_id')
    													->where('users.user_id',$fm_id)
    													->where('status','APPROVED')
    													->whereRaw("MONTH(investments.created_at)=MONTH(CURDATE()) AND YEAR(investments.created_at)=YEAR(CURDATE())")
    													->count();;
    	$thisMonth['new_investments_amount'] = Investment::leftJoin('users','users.id','=','investments.user_id')
    													->where('users.user_id',$fm_id)
    													->where('status','APPROVED')
    													->whereRaw("MONTH(investments.created_at)=MONTH(CURDATE()) AND YEAR(investments.created_at)=YEAR(CURDATE())")
    													->sum('amount');

    	$thisMonth['new_investors'] = User::where('role','investor')->where('user_id',$fm_id)
    										->whereRaw("MONTH(created_at)=MONTH(CURDATE()) AND YEAR(created_at)=YEAR(CURDATE())")
    										->count();
    	$data['thisMonth'] = (object)$thisMonth;



    	$allTime['investors'] = User::where('role','investor')->where('user_id',$fm_id)->count();

    	$allTime['investments'] = Investment::leftJoin('users','users.id','=','investments.user_id')
												->where('users.user_id',$fm_id)
												->where('status','APPROVED')->count();
    	$allTime['investments_amount'] = Investment::leftJoin('users','users.id','=','investments.user_id')
												->where('users.user_id',$fm_id)
												->where('status','APPROVED')->sum('amount');
    	$allTime['mature_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    												->leftJoin('users','users.id','=','investments.user_id')
													->where('users.user_id',$fm_id)
													->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) <= now() ")
											    	->count('investments.id');
    	$allTime['mature_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    												->leftJoin('users','users.id','=','investments.user_id')
													->where('users.user_id',$fm_id)
													->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) <= now() ")
											    	->sum('amount');
    	$allTime['immature_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    												->leftJoin('users','users.id','=','investments.user_id')
													->where('users.user_id',$fm_id)
													->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) > now() ")
											    	->count('investments.id');
    	$allTime['immature_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')
    												->leftJoin('users','users.id','=','investments.user_id')
													->where('users.user_id',$fm_id)
													->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) > now() ")
											    	->sum('amount');

    	$allTime['earnings'] = Earning::leftJoin('investments','investments.id','=','earnings.investment_id')
    									->leftJoin('users','users.id','=','investments.user_id')
										->where('users.user_id',$fm_id)->where('earnings.status','APPROVED')
										->count('earnings.id');
    	$allTime['earnings_amount'] = Earning::leftJoin('investments','investments.id','=','earnings.investment_id')
	    									->leftJoin('users','users.id','=','investments.user_id')
											->where('users.user_id',$fm_id)->where('earnings.status','APPROVED')
											->sum('earnings.amount');
    	$allTime['average_earning'] = $allTime['earnings']>0?$allTime['earnings_amount']/$allTime['earnings']:0;
    	$data['allTime'] = (object)$allTime;

        return view('fm.dashboard',$data);
    }
}
