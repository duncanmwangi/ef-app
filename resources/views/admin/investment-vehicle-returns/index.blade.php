@extends('layouts.app')

@section('heading', 'Investment Vehicle Returns')

@section('sub-heading', 'List all Investment Vehicle Returns')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">
	            Investment Vehicle Returns For: {{ $investmentVehicle->title }}
	            <div class="btn-actions-pane-right">{!! editButton(route('admin.investment-vehicle-returns.create',$investmentVehicle),'Create New '.ucwords($investmentVehicle->term).' Return','btn-success','lnr-plus-circle') !!}</div>
	        </div>
	        <div class="card-body px-2 py-0">

	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th>ID</th>
		                    <th>Title</th>
		                    <th>Percent ROI</th>
		                    <th>Return Issue Date</th>
		                    <th>Return Status</th>
		                    <th># Investments Affected</th>
		                    <th>Return Amount Issued</th>
		                    <th>Date Created</th>
		                    <th>Actions</th>
		                </tr>
	                </thead>
	                <tbody>

		                @if (count($investmentVehicleReturns)>0)
		                	@php $offset = $investmentVehicleReturns->firstItem() @endphp
		                    @foreach ($investmentVehicleReturns as $investmentVehicleReturn)
						        <tr>
				                    <th scope="row">{{ $offset++ }}</th>
				                    <td>{{ $investmentVehicleReturn->id }}</td>
				                    <td>{{ $investmentVehicleReturn->title }}</td>
				                    <td>{{ $investmentVehicleReturn->percent_return }}</td>
				                    <td>{{ $investmentVehicleReturn->date_to_issue }}</td>
				                    <td>{{ $investmentVehicleReturn->status }}</td>
				                    <td>{{ $investmentVehicleReturn->affected_investments }}</td>
				                    <td>{{ $investmentVehicleReturn->status=='ISSUED'?moneyFormat($investmentVehicleReturn->amount_affected):'' }}</td>
				                    <td>{{ formatDate($investmentVehicleReturn->created_at) }}</td>
				                    <td>{!! $investmentVehicleReturn->status=='PENDING'? editButton(route('admin.investment-vehicle-returns.edit',[$investmentVehicle, $investmentVehicleReturn])):'' !!} {!! $investmentVehicleReturn->status=='PENDING'?deleteButton(route('admin.investment-vehicle-returns.destroy',[$investmentVehicle,$investmentVehicleReturn]),'Delete','delete-investment-vehicle-return'):'' !!}</td>
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
	            {{ $investmentVehicleReturns->links() }}
	        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    $('.delete-investment-vehicle-return').click(function(e){
        e.preventDefault();
        if (confirm('Are you sure you want to delete investment vehicle return?')) {
            $(e.target).closest('form').submit();
        }
    });
</script>
@endsection