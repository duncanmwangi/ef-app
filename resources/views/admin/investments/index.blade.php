@extends('layouts.app')

@section('heading', 'Investments')

@section('sub-heading', 'List all Investments')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">
	            Investments
	        </div>
	        <div class="card-body px-2 py-0">
				<form action="{{ route('admin.investments.search')}}" method="post">
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
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'id'))}}">ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'investorID'))}}">Investor ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'investorName'))}}">Investor Name <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'investmentVehicle'))}}">Investment Vehicle <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'status'))}}">Investment Status <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'maturityStatus'))}}">Maturity Status <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'maturityDate'))}}">Maturity Date <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'amount'))}}">Amount <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.investments.index',sort_by($filterArray,'created_at'))}}">Date Created <i class="fa fa-fw fa-sort"></i></a></th>
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
				                    <td>{{ $investment->investor->id }}</td>
				                    <td>{{ $investment->investor->name }}</td>
				                    <td>{{ $investment->investmentVehicle->title }}</td>
				                    <td>{!! badge($investment->status,$investment->status=='PENDING'?'warning':($investment->status=='PROCESSING'?'info':($investment->status=='APPROVED'?'success':'danger'))) !!}</td>
				                    <td>{!! badge($investment->maturity_status, $investment->maturity_status=='MATURE'?'success':'warning') !!}</td>
				                    <td>{{ formatDate($investment->maturity_date) }}</td>
				                    <td>{{ moneyFormat($investment->amount) }}</td>
				                    <td>{{ formatDate($investment->created_at) }}</td>
				                    <td>{!! editButton(route('admin.investments.edit',$investment)) !!} {!! deleteButton(route('admin.investments.destroy',$investment),'Delete','delete-investment') !!}</td>
				                </tr>
						    @endforeach
						@else
							<tr>
			                    <th scope="row" colspan="10">No records found</th>
			                </tr>
						@endif
	                </tbody>
	            </table>

                <div class="form-row">
                	
                </div>




	        </div>
	        <div class="card-footer">
	            {{ $investments->appends($filterArray??[])->links() }}
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