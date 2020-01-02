@extends('layouts.app')

@section('heading', 'USERS')

@section('sub-heading', 'List all users')

@section('content')



<div class="col-md-9">

@include('common.errors')

    <div class="main-card mb-3 card">
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
		                    <th>Phone</th>
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
				                    <td>{{ $user->phone }}</td>
				                    <td>{{ $user->role_name }}</td>
				                    <td>{!! editButton(route('admin.users.edit',$user->id)) !!} {!! deleteButton(route('admin.users.destroy',$user->id),'Delete','delete-user') !!}</td>
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
    </div>
</div>

@endsection


@section('scripts')
<script>
    $('.delete-user').click(function(e){
        e.preventDefault();
        if (confirm('Are you sure you want to delete user?')) {
            $(e.target).closest('form').submit();
        }
    });
</script>
@endsection