@extends('layouts.app')

@section('heading', 'USERS')

@section('sub-heading', 'List all users')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">
	            Users
	        </div>
	        <div class="card-body px-2 py-0">
				<form action="{{ route('admin.users.search')}}" method="post">
					@csrf
		        	<div class="form-row mt-3 pt-3 px-2">
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="firstName" class="">First Name</label>
	                            <input name="firstName" id="firstName" placeholder="First Name" type="text" value="{{ $filterArray['firstName']??'' }}" class="form-control form-control-sm @error('firstName') is-invalid @enderror">
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="lastName" class="">Last Name</label>
	                            <input name="lastName" id="lastName" placeholder="Last Name" type="text" value="{{ $filterArray['lastName']??'' }}" class="form-control form-control-sm @error('lastName') is-invalid @enderror">
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="email" class="">Email Address</label>
	                            <input name="email" id="email" placeholder="Email Address" type="text" value="{{ $filterArray['email']??'' }}" class="form-control form-control-sm @error('email') is-invalid @enderror">
	                        </div>
	                    </div>

	                    
	                </div>

		        	<div class="form-row px-2">
						<div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="role" class="">Role</label>
	                            <select id="role" name="role" class="form-control form-control-sm @error('role') is-invalid @enderror">
	                                <option value="">Select Role</option>
	                                @php 
	                                $roles = ['administrator'=>'Administrator','fund-manager'=>'Fund Manager','investor'=>'Investor']; 
	                                $selectedrole = $filterArray['role'] ?? '';
	                                @endphp
	                                @foreach($roles as $key => $current_role)
	                                    @php $selected = $key==$selectedrole ?'selected="selected"':''; @endphp
	                                    <option value="{{ $key }}" {{$selected}}>{{ $current_role }}</option>
	                                @endforeach
	                            </select>
	                        </div>
	                    </div>

	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="phone" class="">Phone Number</label>
	                            <input name="phone" id="phone" placeholder="Phone Number" type="text" value="{{ $filterArray['phone']??'' }}" class="form-control form-control-sm @error('phone') is-invalid @enderror">
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="state" class="">State</label>
	                            @php $errorClass =$errors->get('state')?'is-invalid':''  @endphp
	                            {!! USstatesSelect('state', old('state')?? '', 'form-control '.$errorClass) !!}
	                        </div>
	                    </div>
	                </div>

		        	<div class="form-row mb-3 px-2">
	                    
						<div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="date_created_from" created_toclass="">Date Created From</label>
	                            <input name="date_created_from" id="date_created_from" placeholder="" type="text" value="{{ isset($filterArray['date_created_from']) ?formatDate($filterArray['date_created_from'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('date_created_from') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                    <div class="col-md-4">
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
				<h4 class="my-2">Users</h4>
	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th><a href="{{route('admin.users.index',sort_by($filterArray,'id'))}}">ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.users.index',sort_by($filterArray,'name'))}}">Name <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.users.index',sort_by($filterArray,'email'))}}">Email Address <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.users.index',sort_by($filterArray,'phone'))}}">Phone <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.users.index',sort_by($filterArray,'role'))}}">Role <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('admin.users.index',sort_by($filterArray,'created_at'))}}">Date Created <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th>Actions</th>
		                </tr>
	                </thead>
	                <tbody>

		                @if (count($users)>0)
		                	@php $offset = $users->LastItem() @endphp
		                    @foreach ($users as $user)
						        <tr>
				                    <th scope="row">{{ $offset++ }}</th>
				                    <td>{{ $user->id }}</td>
				                    <td>{{ $user->name }}</td>
				                    <td>{{ $user->email }}</td>
				                    <td>{{ $user->phone }}</td>
				                    <td>{!! badge($user->role_name,$user->role=='admin'?'danger':($user->role=='fund-manager'?'info':'success')) !!}</td>
				                    <td>{{ formatDate($user->created_at) }}</td>
				                    <td>{!! editButton(route('admin.users.edit',$user->id)) !!} {!! deleteButton(route('admin.users.destroy',$user->id),'Delete','delete-user') !!}</td>
				                </tr>
						    @endforeach
						@else
							<tr>
			                    <th scope="row" colspan="8">No records found</th>
			                </tr>
						@endif
	                </tbody>
	            </table>

                <div class="form-row">
                	
                </div>




	        </div>
	        <div class="card-footer">
	            {{ $users->appends($filterArray??[])->links() }}
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