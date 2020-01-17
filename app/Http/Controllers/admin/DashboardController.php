<?php

namespace App\Http\Controllers\admin;
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
    	$data['dontShowTitle'] = true;
    	$last12MonthsTbl = DB::raw("(SELECT DATE_FORMAT(a.a, '%m-%Y') as month_year,a.a as date FROM  (select Date_add(Now(),interval - 0 month) as a union all select Date_add(Now(),interval - 1 month) as a union all select Date_add(Now(),interval - 2 month) union all select Date_add(Now(),interval - 3 month) union all select Date_add(Now(),interval - 4 month) union all select Date_add(Now(),interval - 5 month) union all select Date_add(Now(),interval - 6 month) union all select Date_add(Now(),interval - 7 month) union all select Date_add(Now(),interval - 8 month) union all select Date_add(Now(),interval - 9 month) union all select Date_add(Now(),interval - 10 month) union all select Date_add(Now(),interval - 11 month)) as a) a");

    	$investmentsTbl = DB::raw("(SELECT DATE_FORMAT(i.created_at, '%m-%Y') as month_year,sum(i.amount) as investments FROM investments as i WHERE status='APPROVED' GROUP BY DATE_FORMAT(i.created_at, '%m-%Y') ) i");

    	$investorsTbl = DB::raw("(SELECT DATE_FORMAT(u.created_at, '%m-%Y') as month_year,count(u.id) as investors FROM users as u WHERE role='investor' GROUP BY DATE_FORMAT(u.created_at, '%m-%Y') ) investors");

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

    	$thisMonth['maturing_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')->where('investments.status','APPROVED')
    													->whereRaw("MONTH($maturity_date)=MONTH(CURDATE()) AND YEAR($maturity_date)=YEAR(CURDATE())")
    													->count('investments.id');
    	$thisMonth['maturing_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')->where('investments.status','APPROVED')
    													->whereRaw("MONTH($maturity_date)=MONTH(CURDATE()) AND YEAR($maturity_date)=YEAR(CURDATE())")
    													->sum('amount');
    	$thisMonth['new_investments'] = Investment::where('status','APPROVED')->whereRaw("MONTH(created_at)=MONTH(CURDATE()) AND YEAR(created_at)=YEAR(CURDATE())")->count();;
    	$thisMonth['new_investments_amount'] = Investment::where('status','APPROVED')->whereRaw("MONTH(created_at)=MONTH(CURDATE()) AND YEAR(created_at)=YEAR(CURDATE())")->sum('amount');
    	$thisMonth['new_fund_managers'] = User::where('role','fund-manager')->whereRaw("MONTH(created_at)=MONTH(CURDATE()) AND YEAR(created_at)=YEAR(CURDATE())")->count();
    	$thisMonth['new_investors'] = User::where('role','investor')->whereRaw("MONTH(created_at)=MONTH(CURDATE()) AND YEAR(created_at)=YEAR(CURDATE())")->count();
    	$data['thisMonth'] = (object)$thisMonth;



    	$allTime['administrators'] = User::where('role','admin')->count();
    	$allTime['fund_managers'] = User::where('role','fund-manager')->count();
    	$allTime['investors'] = User::where('role','investor')->count();
    	$allTime['investments'] = Investment::where('status','APPROVED')->count();
    	$allTime['investments_amount'] = Investment::where('status','APPROVED')->sum('amount');
    	$allTime['mature_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) <= now() ")
											    	->count('investments.id');
    	$allTime['mature_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) <= now() ")
											    	->sum('amount');
    	$allTime['immature_investments'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) > now() ")
											    	->count('investments.id');
    	$allTime['immature_investments_amount'] = Investment::leftJoin('investment_vehicles', 'investment_vehicles.id', '=', 'investments.investment_vehicle_id')->where('investments.status','APPROVED')
											    	->whereRaw("date(DATE_ADD(investments.created_at,INTERVAL investment_vehicles.waiting_period MONTH)) > now() ")
											    	->sum('amount');
    	$allTime['earnings'] = Earning::where('status','APPROVED')->count();
    	$allTime['earnings_amount'] = Earning::where('status','APPROVED')->sum('amount');
    	$allTime['average_earning'] = $allTime['earnings']>0?$allTime['earnings_amount']/$allTime['earnings']:0;
    	$data['allTime'] = (object)$allTime;

        return view('admin.dashboard',$data);
    }
}
