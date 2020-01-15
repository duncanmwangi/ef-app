@extends('layouts.app')

@section('heading', 'Investment Vehicles')

@section('sub-heading', 'List all investment vehicles')

@section('content')



<div class="col-md-9">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">
	            Investment Vehicles
	        </div>
	        <div class="card-body px-2 py-0">

	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th>ID</th>
		                    <th>Title</th>
		                    <th>Waiting Period</th>
		                    <th>Terms</th>
		                    <th>No of earning terms</th>
		                    <th>Status</th>
		                    <th>Date Created</th>
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
				                    <td>{{ $investmentVehicle->number_of_terms }}</td><td>{!! badge($investmentVehicle->status,$investmentVehicle->status=='active'?'success':'danger') !!}</td>
				                    <td>{{ formatDate($investmentVehicle->created_at) }}</td>
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
	            {{ $investmentVehicles->links() }}
	        </div>
    </div>
</div>

@endsection
