@extends('layouts.app')

@section('heading', 'Earnings')

@section('sub-heading', 'List all Earnings')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">

                @if ( count(request()->all()))
                    {!! editButton(url()->previous(),'Back','btn-xs btn-secondary mx-3 back-btn','lnr-pointer-left') !!}
                @endif
                
	            Earnings
	        </div>

	        <div class="card-body px-2 py-0">
	        	<form action="{{ route('admin.earnings.search')}}" method="post">
					@csrf
		        	<div class="form-row mt-3 pt-3 px-2">
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="fund_manager" class="">Fund Manager</label>
	                            <select id="fund_manager" name="fund_manager" class="form-control form-control-sm @error('fund_manager') is-invalid @enderror">
		                            <option value="">Select Fund Manager</option>
	                                @if(isset($fundManagers) && $fundManagers)
	                                    @foreach($fundManagers as $fund_manager)
	                                        @php 
	                                        $selectedIV = old('fund_manager') ?? $filterArray['fund_manager'] ?? '';
	                                        $selected = $fund_manager->id==$selectedIV?'selected="selected"':''; 
	                                        @endphp
	                                        <option value="{{ $fund_manager->id }}"  {{$selected}}>{{ $fund_manager->name }}</option>
	                                    @endforeach
	                                @endif
	                            </select>
	                        </div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="investor" class="">Investor</label>
	                            <select id="investor" name="investor" class="form-control form-control-sm @error('investor') is-invalid @enderror">
		                            <option value="">Select Investor</option>
	                                @if(isset($investors) && $investors)
	                                    @foreach($investors as $investor)
	                                        @php 
	                                        $selectedIV = old('investor') ?? $filterArray['investor'] ?? '';
	                                        $selected = $investor->id==$selectedIV?'selected="selected"':''; 
	                                        @endphp
	                                        <option value="{{ $investor->id }}"  {{$selected}}>{{ $investor->name }}</option>
	                                    @endforeach
	                                @endif
	                            </select>
	                        </div>
	                    </div>
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

	                    
	                </div>

		        	<div class="form-row px-2">
						<div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="status" class="">Earning Status</label>
	                            <select id="status" name="status" class="form-control form-control-sm @error('status') is-invalid @enderror">
	                                <option value="">Select earning status</option>
	                                @php 
	                                $statuses = ['ISSUED', 'APPROVED', 'DECLINED']; 
	                                $selectedstatus = $filterArray['status'] ?? '';
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
	                            <label for="issue_from" created_toclass="">Issue Date From</label>
	                            <input name="issue_from" id="issue_from" placeholder="" type="text" value="{{ isset($filterArray['issue_from']) ?formatDate($filterArray['issue_from'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('issue_from') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="position-relative form-group">
	                            <label for="issue_to" created_toclass="">Issue Date To</label>
	                            <input name="issue_to" id="issue_to" placeholder="" type="text" value="{{ isset($filterArray['issue_to']) ?formatDate($filterArray['issue_to'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('issue_to') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                    <div class="col-md-3 pt-1 pl-3">
	                        <button type="submit" class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-success mt-3 ml-3">Search</button>
	                    </div>
	                </div>
				</form>
				<hr>
				<h4 class="my-2">Earnings</h4>

	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'id'))}}">ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'investmentID'))}}">Investment ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'name'))}}">Investor Name <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'title'))}}">Investment Vehicle <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'INVamount'))}}">Investment Amount <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'status'))}}">Status <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'issue'))}}">Date Issued <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'percent'))}}">Return Percent <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.earnings.index',sort_by($filterArray,'amount'))}}">Amount Earned <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th>Actions</th>
		                </tr>
	                </thead>
	                <tbody>

		                @if (count($earnings)>0)
		                	@php $offset = $earnings->firstItem() @endphp
		                    @foreach ($earnings as $earning)
						        <tr>
				                    <th scope="row">{{ $offset++ }}</th>
				                    <td>{{ $earning->id }}</td>
				                    <td>{{ $earning->investment->id }}</td>
				                    <td>{{ $earning->investment->investor->name }}</td>
				                    <td>{{ $earning->investment->investmentVehicle->title }}</td>
				                    <td>{{ moneyFormat($earning->investment->amount) }}</td>
				                    <td>{!! badge($earning->status,$earning->status=='ISSUED'?'info':($earning->status=='APPROVED'?'success':'danger')) !!}</td>
				                    <td>{{ formatDate($earning->date_issued) }}</td>
				                    <td>{{ percent_return($earning) }}%</td>
				                    <td>{{ moneyFormat($earning->amount) }}</td>
				                    <td>{!! editButton(route('admin.earnings.edit',$earning)) !!} {!! deleteButton(route('admin.earnings.destroy',$earning),'Delete','delete-earning') !!}</td>
				                </tr>
						    @endforeach
						@else
							<tr>
			                    <th scope="row" colspan="11">No records found</th>
			                </tr>
						@endif
	                </tbody>
	            </table>

                <div class="form-row">
	            	{{ $earnings->appends($filterArray??[])->links()  }}
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
				                                <div class="widget-heading">Earnings Amount</div>
				                                <div class="widget-subheading">Total amount of earnings</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">{{ moneyFormat($stats->earnings_amount) }}</div>
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
				                                <div class="widget-heading">Average Earning Amount</div>
				                                <div class="widget-subheading">Average amount per earning</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">{{ moneyFormat($stats->average_earning) }}</div>
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
				                                <div class="widget-heading">Number of Investments</div>
				                                <div class="widget-subheading">Total number of investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ $stats->investments }}</div>
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
				                                <div class="widget-heading">Average Investment Amount</div>
				                                <div class="widget-subheading">Average amount per investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ moneyFormat($stats->average_investment) }}</div>
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
				                                <div class="widget-heading">Total Investments Amount</div>
				                                <div class="widget-subheading">Total amount of investment investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ moneyFormat($stats->investments_amount) }}</div>
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
				                                <div class="widget-subheading">Average earning per return per investment</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ percentFormat($stats->average_roi) }}</div>
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
    $('.delete-earning').click(function(e){
        e.preventDefault();
        if (confirm('Are you sure you want to delete earning?')) {
            $(e.target).closest('form').submit();
        }
    });
    $("body").on("change","select#fund_manager",function(){
            let fm = $(this).val();
            if(fm>0){
                let url = "{{route('admin.users.jsonInvestors','FM-ID-HOLDER')}}";
                $.get(url.replace('FM-ID-HOLDER',fm) ,function(data) {
                    $('#investor').empty();
                    $('#investor').append('<option value="" disable="true" selected="true">Select Investor</option>');
                    $.each(JSON.parse(data), function(index, investorObj){
                        $('#investor').append('<option value="'+ investorObj.id +'">'+ investorObj.name +'</option>');
                    });
                });
            }
        });
</script>
@endsection