@extends('layouts.app')

@section('heading', 'USERS')

@section('sub-heading', 'List all users')

@section('content')

@include('common.errors')

<div class="col-md-9">


    <div class="main-card mb-3 card">
    	<form method="POST" action="{{ route('common.profile.update') }}"> 
    		@csrf
	        <div class="card-header">
	            Users
	        </div>
	        <div class="card-body px-2 py-0">

	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th>ID</th>
		                    <th>First Name</th>
		                    <th>Email Address</th>
		                    <th>Role</th>
		                    <th>Actions</th>
		                </tr>
	                </thead>
	                <tbody>

		                @if (count($users)>0)
		                	@php $offset = $users->firstItem() @endphp
		                    @foreach ($users as $user)
						        <tr>
				                    <th scope="row">{{ $offset++ }}</th>
				                    <td>{{ $user->id }}</td>
				                    <td>{{ $user->name }}</td>
				                    <td>{{ $user->email }}</td>
				                    <td>{{ $user->role_name }}</td>
				                    <td>{{ $user->role_name }}</td>
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
	            {{ $users->links() }}
	        </div>
        </form>
    </div>
</div>

@endsection
