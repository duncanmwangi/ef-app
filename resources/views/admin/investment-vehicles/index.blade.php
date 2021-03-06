@extends('layouts.app')

@section('heading', 'Investment Vehicles')

@section('sub-heading', 'List all investment vehicles')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">

	            @if ( count(request()->all()))
					{!! editButton(url()->previous(),'Back','btn-xs btn-secondary mx-3 back-btn','lnr-pointer-left') !!}
	            @endif
	            
	            Investment Vehicles
	        </div>
	        <div class="card-body px-2 py-0">
				<form action="{{ route('admin.investment-vehicles.search')}}" method="post">
					@csrf
		        	<div class="form-row mt-3 pt-3 px-2">
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="title" class="">Title</label>
	                            <input name="title" id="title" placeholder="Title" type="text" value="{{ $filterArray['title']??'' }}" class="form-control form-control-sm @error('title') is-invalid @enderror">
	                        </div>
	                    </div>

	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="termType" class="">Term Type</label>
	                            <select id="termType" name="termType" class="form-control form-control-sm @error('termType') is-invalid @enderror">
	                                <option value="">Select Term Type</option>
	                                @php 
	                                $termTypes = ['monthly'=>'Monthly','quarterly'=>'Quarterly','bi-annual'=>'Bi-annual','annual'=>'Annual']; 
	                                $selectedTermType = $filterArray['termType'] ?? '';
	                                @endphp
	                                @foreach($termTypes as $key => $termType)
	                                    @php $selected = $key==$selectedTermType ?'selected="selected"':''; @endphp
	                                    <option value="{{ $key }}" {{$selected}}>{{ $termType }}</option>
	                                @endforeach
	                            </select>
	                        </div>
	                    </div>

	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="date_created_from" created_toclass="">Date Created From</label>
	                            <input name="date_created_from" id="date_created_from" placeholder="" type="text" value="{{ isset($filterArray['date_created_from']) ?formatDate($filterArray['date_created_from'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('date_created_from') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                </div>

		        	<div class="form-row px-2">
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="waiting_period" class="">Waiting Period</label>
	                            <div class="col-md-12 row p-0 m-0">
	                            	<div class="col-md-6 px-0">
										<select id="waiting_period_operation" name="waiting_period_operation" class="form-control form-control-sm @error('waiting_period_operation') is-invalid @enderror">
			                                @php 
			                                $waiting_period_operations = ['equal'=>'Equal To','less_than'=>'Less Than','less_than_or_equal'=>'Less Than Or Equal To','greater_than'=>'Greater Than','greater_than_or_equal_to'=>'Greater Than Or Equal To']; 
			                                $selectedWaiting_period_operation = $filterArray['waiting_period_operation'] ?? '';
			                                @endphp
			                                @foreach($waiting_period_operations as $key => $value)
			                                    @php $selected = $key==$selectedWaiting_period_operation ?'selected="selected"':''; @endphp
			                                    <option value="{{ $key }}" {{$selected}}>{{ $value }}</option>
			                                @endforeach
			                            </select>
	                            	</div>
	                            	<div class="col-md-6 px-0">
										<input name="waiting_period" id="waiting_period" placeholder="Waiting Period" type="number" value="{{ $filterArray['waiting_period'] ?? '' }}" class="form-control form-control-sm @error('waiting_period') is-invalid @enderror">
	                            	</div>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="description" class="">Number Of Terms</label>
	                            <div class="col-md-12 row p-0 m-0">
	                            	<div class="col-md-6 px-0">
										<select id="number_of_terms_operation" name="number_of_terms_operation" class="form-control form-control-sm @error('number_of_terms_operation') is-invalid @enderror">
			                                @php 
			                                $number_of_terms_operations = ['equal'=>'Equal To','less_than'=>'Less Than','less_than_or_equal'=>'Less Than Or Equal To','greater_than'=>'Greater Than','greater_than_or_equal_to'=>'Greater Than Or Equal To']; 
			                                $selectednumber_of_terms_operation = $filterArray['number_of_terms_operation'] ?? '';
			                                @endphp
			                                @foreach($number_of_terms_operations as $key => $value)
			                                    @php $selected = $key==$selectednumber_of_terms_operation ?'selected="selected"':''; @endphp
			                                    <option value="{{ $key }}" {{$selected}}>{{ $value }}</option>
			                                @endforeach
			                            </select>
	                            	</div>
	                            	<div class="col-md-6 px-0">
										<input name="number_of_terms" id="number_of_terms" placeholder="Waiting Period" type="number" value="{{ $filterArray['number_of_terms'] ?? '' }}" class="form-control form-control-sm @error('number_of_terms') is-invalid @enderror">
	                            	</div>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="date_created_to" created_toclass="">Date Created To</label>
	                            <input name="date_created_to" id="date_created_to" placeholder="" type="text" value="{{ isset($filterArray['date_created_to']) ?formatDate($filterArray['date_created_to'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('date_created_to') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                </div>

		        	<div class="form-row mb-3 px-2">
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="termType" class="">Status</label>
	                            <select id="status" name="status" class="form-control form-control-sm @error('status') is-invalid @enderror">
	                                <option value="">Select Status</option>
	                                @php 
	                                $statuses = ['active'=>'Active','suspended'=>'Suspended']; 
	                                $selectedStatus = $filterArray['status'] ?? '';
	                                @endphp
	                                @foreach($statuses as $key => $status)
	                                    @php $selected = $key==$selectedStatus ?'selected="selected"':''; @endphp
	                                    <option value="{{ $key }}" {{$selected}}>{{ $status }}</option>
	                                @endforeach
	                            </select>
	                        </div>
	                    </div>

	                    <div class="col-md-4 pt-1 pl-3">
	                        <button type="submit" class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-success mt-3 ml-3">Search</button>
	                    </div>
	                </div>
				</form>
				<hr>
				<h4 class="my-2">Investment Vehicles</h4>
	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'id'))}}">ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'title'))}}">Title <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'waiting_period'))}}">Waiting<br/>Period <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'term'))}}">Terms <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'number_of_terms'))}}">No of<br/>earning<br/>terms <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'status'))}}">Status <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'num'))}}">No of<br/>Investments <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'amount'))}}">Amount of<br/>Investments <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investment-vehicles.index',sort_by($filterArray,'created_at'))}}">Date Created <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th>Actions</th>
		                </tr>
	                </thead>
	                <tbody>

		                @if (count($investmentVehicles)>0)
		                	@php $offset = $investmentVehicles->firstItem() @endphp
		                    @foreach ($investmentVehicles as $investmentVehicle)
						        <tr>
				                    <th scope="row">{{ $offset++ }}</th>
				                    <td>{{ $investmentVehicle->id }}</td>
				                    <td>{{ $investmentVehicle->title }}</td>
				                    <td>{{ $investmentVehicle->waiting_period }}</td>
				                    <td>{{ ucwords($investmentVehicle->term) }}</td>
				                    <td>{{ $investmentVehicle->number_of_terms }}</td>
				                    <td>{!! badge($investmentVehicle->status,$investmentVehicle->status=='active'?'success':'danger') !!}</td>
				                    <td>{{ num($investmentVehicle->num) }}</td>
				                    <td>{{ moneyFormat($investmentVehicle->amount) }}</td>
				                    <td>{{ formatDate($investmentVehicle->created_at) }}</td>
				                    <td>{!! editButton(route('admin.investments.index',['investment_vehicle'=>$investmentVehicle->id]),'Investments','btn-info') !!} {!! $investmentVehicle->returns->count()?editButton(route('admin.investment-vehicle-returns.index',$investmentVehicle),'Returns','btn-success','lnr-eye'):"" !!} {!! $investmentVehicle->returns->count()?editButton(route('admin.earnings.index',['investment_vehicle'=>$investmentVehicle->id]),'Earnings','btn-alternate','lnr-eye'):"" !!} {!! editButton(route('admin.investment-vehicles.edit',$investmentVehicle)) !!} {!! $investmentVehicle->returns->count()<1?deleteButton(route('admin.investment-vehicles.destroy',$investmentVehicle),'Delete','delete-investmentVehicle'):'' !!}</td>
				                </tr>
						    @endforeach
						@else
							<tr>
			                    <th scope="row" colspan="9">No records found</th>
			                </tr>
						@endif
	                </tbody>
	            </table>

                <div class="form-row">
	            	{{ $investmentVehicles->appends($filterArray??[])->links() }}
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

				                                <div class="widget-heading">Total Investments Amount</div>
				                                <div class="widget-subheading">Total amount of investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">{{ moneyFormat($stats->investments_amount) }}</div>
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

				                                <div class="widget-heading">Number Of Mature Investments</div>
				                                <div class="widget-subheading">Total number of mature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">{{ $stats->mature_investments }}</div>
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

				                                <div class="widget-heading">Mature Investments Amount</div>
				                                <div class="widget-subheading">Total amount of immature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">{{ moneyFormat($stats->immature_investments_amount) }}</div>
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
				                                <div class="widget-heading">Number of Issued Returns</div>
				                                <div class="widget-subheading">Total number of Issued Returns</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ $stats->returns }}</div>
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
				                                <div class="widget-heading">Average ROI</div>
				                                <div class="widget-subheading">Average return on investment</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ percentFormat($stats->average_roi) }}</div>
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
				                                <div class="widget-heading">Mature Investments Amount</div>
				                                <div class="widget-subheading">Total amount of mature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ moneyFormat($stats->mature_investments_amount) }}</div>
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
				                                <div class="widget-heading">Number of Unissued Returns</div>
				                                <div class="widget-subheading">Total number of unissued returns</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ $stats->unissued_returns }}</div>
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
				                                <div class="widget-heading">Number of Earnings</div>
				                                <div class="widget-subheading">Total number of earnings</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ $stats->earnings }}</div>
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
				                                <div class="widget-heading">Earnings Amount</div>
				                                <div class="widget-subheading">Total amount of earnings</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ moneyFormat($stats->earnings_amount) }}</div>
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
				                                <div class="widget-heading">Number Of Immature Investments</div>
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
				                                <div class="widget-heading">Average Unissued ROI</div>
				                                <div class="widget-subheading">Average ROI for all unissued returns</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ percentFormat($stats->unissued_average_roi) }}</div>
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
    $('.delete-investmentVehicle').click(function(e){
        e.preventDefault();
        if (confirm('Are you sure you want to delete Investment Vehicle?')) {
            $(e.target).closest('form').submit();
        }
    });
</script>
@endsection