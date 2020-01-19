@extends('layouts.app')

@section('heading', 'My Investments')

@section('sub-heading', 'List all Investments')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">
	            My Investments
	        </div>
	        <div class="card-body px-2 py-0">
				<form action="{{ route('investor.investments.search')}}" method="post">
					@csrf
		        	<div class="form-row mt-3 pt-3 px-2">
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="investment_vehicle" class="">Investment Vehicle</label>
	                            <select id="investment_vehicle" name="investment_vehicle" class="form-control form-control-sm @error('investment_vehicle') is-invalid @enderror">
		                            <option value="">Select Investment Vehicle</option>
	                                @if($investmentVehicles)
	                                    @foreach($investmentVehicles as $current_iv)
	                                        @php 
	                                        $selectedIV = old('investment_vehicle') ?? $filterArray['investment_vehicle'] ?? '';
	                                        $selected = $current_iv->id==$selectedIV?'selected="selected"':''; 
	                                        @endphp
	                                        <option value="{{ $current_iv->id }}"  {{$selected}}>{{ $current_iv->title }}</option>
	                                    @endforeach
	                                @endif
	                            </select>
	                        </div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="email" class="">Amount</label>
	                            <div class="col-md-12 row p-0 m-0">
	                            	<div class="col-md-4 px-0">
										<select id="amount_operation" name="amount_operation" class="form-control form-control-sm @error('amount_operation') is-invalid @enderror">
			                                @php 
			                                $amount_operations = ['equal'=>'Equal To','less_than'=>'Less Than','less_than_or_equal'=>'Less Than Or Equal To','greater_than'=>'Greater Than','greater_than_or_equal_to'=>'Greater Than Or Equal To']; 
			                                $selectedamount_operation = $filterArray['amount_operation'] ?? '';
			                                @endphp
			                                @foreach($amount_operations as $key => $value)
			                                    @php $selected = $key==$selectedamount_operation ?'selected="selected"':''; @endphp
			                                    <option value="{{ $key }}" {{$selected}}>{{ $value }}</option>
			                                @endforeach
			                            </select>
	                            	</div>
	                            	<div class="col-md-8 px-0">
										<input name="amount" id="amount" placeholder="Amount" type="number" value="{{ $filterArray['amount'] ?? '' }}" class="form-control form-control-sm @error('amount') is-invalid @enderror">
	                            	</div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="date_created_from" created_toclass="">Date Created From</label>
	                            <input name="date_created_from" id="date_created_from" placeholder="" type="text" value="{{ isset($filterArray['date_created_from']) ?formatDate($filterArray['date_created_from'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('date_created_from') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="date_created_to" created_toclass="">Date Created To</label>
	                            <input name="date_created_to" id="date_created_to" placeholder="" type="text" value="{{ isset($filterArray['date_created_to']) ?formatDate($filterArray['date_created_to'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('date_created_to') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>

	                    
	                </div>

		        	<div class="form-row px-2">
						<div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="investmentStatus" class="">Investment Status</label>
	                            <select id="investmentStatus" name="investmentStatus" class="form-control form-control-sm @error('investmentStatus') is-invalid @enderror">
	                                <option value="">Select investment status</option>
	                                @php 
	                                $statuses = ['PENDING', 'PROCESSING', 'APPROVED', 'DECLINED']; 
	                                $selectedstatus = $filterArray['investmentStatus'] ?? '';
	                                @endphp
	                                @foreach($statuses as $current_status)
	                                    @php $selected = $current_status==$selectedstatus ?'selected="selected"':''; @endphp
	                                    <option value="{{ $current_status }}" {{$selected}}>{{ $current_status }}</option>
	                                @endforeach
	                            </select>
	                        </div>
	                    </div>
						<div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="maturity_status" class="">Maturity Status</label>
	                            <select id="maturity_status" name="maturity_status" class="form-control form-control-sm @error('maturity_status') is-invalid @enderror">
	                                <option value="">Select maturity status</option>
	                                @php 
	                                $Mstatuses = ['MATURE', 'IMMATURE']; 
	                                $selectedMstatus = $filterArray['maturity_status'] ?? '';
	                                @endphp
	                                @foreach($Mstatuses as $current_Mstatus)
	                                    @php $selected = $current_Mstatus==$selectedMstatus ?'selected="selected"':''; @endphp
	                                    <option value="{{ $current_Mstatus }}" {{$selected}}>{{ $current_Mstatus }}</option>
	                                @endforeach
	                            </select>
	                        </div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="maturity_from" created_toclass="">Maturity Date From</label>
	                            <input name="maturity_from" id="maturity_from" placeholder="" type="text" value="{{ isset($filterArray['maturity_from']) ?formatDate($filterArray['maturity_from'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('maturity_from') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="maturity_to" created_toclass="">Maturity Date To</label>
	                            <input name="maturity_to" id="maturity_to" placeholder="" type="text" value="{{ isset($filterArray['maturity_to']) ?formatDate($filterArray['maturity_to'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('maturity_to') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                </div>

		        	<div class="form-row mb-3 px-2">
	                    
						
	                    <div class="col-md-4 pt-1 pl-3">
	                        <button type="submit" class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-success mt-3 ml-3">Search</button>
	                    </div>
	                </div>
				</form>
				<hr>
				<h4 class="my-2">Investments</h4>
	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th><a href="{{route('investor.investments.index',sort_by($filterArray,'id'))}}">ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.investments.index',sort_by($filterArray,'investmentVehicle'))}}">Investment Vehicle <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.investments.index',sort_by($filterArray,'status'))}}">Investment Status <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.investments.index',sort_by($filterArray,'maturityStatus'))}}">Maturity Status <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.investments.index',sort_by($filterArray,'maturityDate'))}}">Maturity Date <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.investments.index',sort_by($filterArray,'amount'))}}">Amount <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.investments.index',sort_by($filterArray,'created_at'))}}">Date Created <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th>Actions</th>
		                </tr>
	                </thead>
	                <tbody>

		                @if (count($investments)>0)
		                	@php $offset = $investments->firstItem() @endphp
		                    @foreach ($investments as $investment)
						        <tr>
				                    <th scope="row">{{ $offset++ }}</th>
				                    <td>{{ $investment->id }}</td>
				                    <td>{{ $investment->investmentVehicle->title }}</td>
				                    <td>{!! badge($investment->status,$investment->status=='PENDING'?'warning':($investment->status=='PROCESSING'?'info':($investment->status=='APPROVED'?'success':'danger'))) !!}</td>
				                    <td>{!! badge($investment->maturity_status, $investment->maturity_status=='MATURE'?'success':'warning') !!}</td>
				                    <td>{{ formatDate($investment->maturity_date) }}</td>
				                    <td>{{ moneyFormat($investment->amount) }}</td>
				                    <td>{{ formatDate($investment->created_at) }}</td>
				                    <td>{!! $investment->earnings->count()? editButton(route('investor.earnings.index',['investment_id'=>$investment->id]),'Earnings','btn-alternate','lnr-eye'):'' !!} </td>
				                </tr>
						    @endforeach
						@else
							<tr>
			                    <th scope="row" colspan="8">No records found</th>
			                </tr>
						@endif
	                </tbody>
	            </table>

                <div class="form-row">
                	{{ $investments->appends($filterArray??[])->links() }}
                </div>




	        </div>
	        <div class="card-footer px-0">
	            

	           <div class="no-gutters mt-1 px-0 col-md-12 row">
				    <div class="col-md-12">
				        <h3 class="card-header-title font-size-lg text-capitalize font-weight-bold ml-3">Statistics</h3></div>
				    <div class="col-md-12 col-lg-4">
				        <ul class="list-group list-group-flush">
				            <li class="bg-transparent list-group-item">
				                <div class="widget-content p-0">
				                    <div class="widget-content-outer">
				                        <div class="widget-content-wrapper">
				                            <div class="widget-content-left">
				                                <div class="widget-heading">Number of Investments</div>
				                                <div class="widget-subheading">Total number of investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">{{ $stats->investments }}</div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </li>
				            <li class="bg-transparent list-group-item">
				                <div class="widget-content p-0">
				                    <div class="widget-content-outer">
				                        <div class="widget-content-wrapper">
				                            <div class="widget-content-left">
				                                <div class="widget-heading">Amount of Investment</div>
				                                <div class="widget-subheading">Total amount of investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">{{ moneyFormat($stats->investments_amount) }}</div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </li>
				        </ul>
				    </div>
				    <div class="col-md-12 col-lg-4">
				        <ul class="list-group list-group-flush">
				            <li class="bg-transparent list-group-item">
				                <div class="widget-content p-0">
				                    <div class="widget-content-outer">
				                        <div class="widget-content-wrapper">
				                            <div class="widget-content-left">
				                                <div class="widget-heading">Number of Mature Investments</div>
				                                <div class="widget-subheading">Total number of mature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ $stats->mature_investments }}</div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </li>
				            <li class="bg-transparent list-group-item">
				                <div class="widget-content p-0">
				                    <div class="widget-content-outer">
				                        <div class="widget-content-wrapper">
				                            <div class="widget-content-left">
				                                <div class="widget-heading">Amount of Mature Investments</div>
				                                <div class="widget-subheading">Total amount of mature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ moneyFormat($stats->mature_investments_amount) }}</div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </li>
				        </ul>
				    </div>
				    <div class="col-md-12 col-lg-4">
				        <ul class="list-group list-group-flush">
				            <li class="bg-transparent list-group-item">
				                <div class="widget-content p-0">
				                    <div class="widget-content-outer">
				                        <div class="widget-content-wrapper">
				                            <div class="widget-content-left">
				                                <div class="widget-heading">Number of Immature Investments</div>
				                                <div class="widget-subheading">Total number of immature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ $stats->immature_investments }}</div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </li>
				            <li class="bg-transparent list-group-item">
				                <div class="widget-content p-0">
				                    <div class="widget-content-outer">
				                        <div class="widget-content-wrapper">
				                            <div class="widget-content-left">
				                                <div class="widget-heading">Amount of Immature Investments</div>
				                                <div class="widget-subheading">Total amount of immature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ moneyFormat($stats->immature_investments_amount) }}</div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </li>
				        </ul>
				    </div>
				</div>
	        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    $('.delete-investment').click(function(e){
        e.preventDefault();
        if (confirm('Are you sure you want to delete user?')) {
            $(e.target).closest('form').submit();
        }
    });
</script>
@endsection