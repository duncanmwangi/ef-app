@extends('layouts.app')

@section('heading', 'My Earnings')

@section('sub-heading', 'List all Earnings')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">
	            My Earnings
	        </div>
	        <div class="card-body px-2 py-0">
				<form action="{{ route('investor.earnings.search')}}" method="post">
					@csrf
		        	<div class="form-row mt-3 pt-3 px-2">
	                    <div class="col-md-4">
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
	                    <div class="col-md-4">
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
						<div class="col-md-4">
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

	                    
	                </div>

		        	<div class="form-row px-2">
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="issue_from" created_toclass="">Issue Date From</label>
	                            <input name="issue_from" id="issue_from" placeholder="" type="text" value="{{ isset($filterArray['issue_from']) ?formatDate($filterArray['issue_from'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('issue_from') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="issue_to" created_toclass="">Issue Date To</label>
	                            <input name="issue_to" id="issue_to" placeholder="" type="text" value="{{ isset($filterArray['issue_to']) ?formatDate($filterArray['issue_to'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('issue_to') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                    <div class="col-md-4 pt-1 pl-3">
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
		                    <th><a href="{{route('investor.earnings.index',sort_by($filterArray,'id'))}}">ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.earnings.index',sort_by($filterArray,'investmentID'))}}">Investment ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.earnings.index',sort_by($filterArray,'title'))}}">Investment Vehicle <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.earnings.index',sort_by($filterArray,'INVamount'))}}">Investment Amount <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.earnings.index',sort_by($filterArray,'status'))}}">Status <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.earnings.index',sort_by($filterArray,'issue'))}}">Date Issued <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.earnings.index',sort_by($filterArray,'percent'))}}">Return Percent <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('investor.earnings.index',sort_by($filterArray,'amount'))}}">Amount Earned <i class="fa fa-fw fa-sort"></i></a></th>
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
				                    <td>{{ $earning->investment->investmentVehicle->title }}</td>
				                    <td>{{ moneyFormat($earning->investment->amount) }}</td>
				                    <td>{!! badge($earning->status,$earning->status=='ISSUED'?'info':($earning->status=='APPROVED'?'success':'danger')) !!}</td>
				                    <td>{{ formatDate($earning->date_issued) }}</td>
				                    <td>{{ percent_return($earning) }}%</td>
				                    <td>{{ moneyFormat($earning->amount) }}</td>
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
                	
                </div>




	        </div>
	        <div class="card-footer">
	            {{ $earnings->appends($filterArray??[])->links()  }}
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
</script>
@endsection