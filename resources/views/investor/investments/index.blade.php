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

	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th>ID</th>
		                    <th>Investment Vehicle</th>
		                    <th>Investment Status</th>
		                    <th>Maturity Status</th>
		                    <th>Maturity Date</th>
		                    <th>Amount</th>
		                    <th>Date Created</th>
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
				                </tr>
						    @endforeach
						@else
							<tr>
			                    <th scope="row" colspan="6">No records found</th>
			                </tr>
						@endif
	                </tbody>
	            </table>

                <div class="form-row">
                	
                </div>




	        </div>
	        <div class="card-footer">
	            {{ $investments->links() }}
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