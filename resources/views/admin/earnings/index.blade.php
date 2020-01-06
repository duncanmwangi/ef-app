@extends('layouts.app')

@section('heading', 'Earnings')

@section('sub-heading', 'List all Earnings')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">
	            Earnings
	        </div>
	        <div class="card-body px-2 py-0">

	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th>ID</th>
		                    <th>Investment ID</th>
		                    <th>Investor Name</th>
		                    <th>Investment Vehicle</th>
		                    <th>Investment Amount</th>
		                    <th>Status</th>
		                    <th>Date Issued</th>
		                    <th>Return Percent</th>
		                    <th>Amount Earned</th>
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
                	
                </div>




	        </div>
	        <div class="card-footer">
	            {{ $earnings->links() }}
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