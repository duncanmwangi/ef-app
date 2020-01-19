@extends('layouts.app')

@section('heading', 'Investors')

@section('sub-heading', 'List all Investors')

@section('content')



<div class="col-md-12">

@include('common.errors')

    <div class="main-card mb-3 card">
	        <div class="card-header">
	            Investors
	        </div>
	        <div class="card-body px-2 py-0">
				<form action="{{ route('fm.investors.search')}}" method="post">
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
	                    
						<div class="col-md-4">
	                        <div class="position-relative form-group">
	                            <label for="date_created_from" created_toclass="">Date Created From</label>
	                            <input name="date_created_from" id="date_created_from" placeholder="" type="text" value="{{ isset($filterArray['date_created_from']) ?formatDate($filterArray['date_created_from'] ,'m/d/Y'):'' }}" class="form-control form-control-sm datepicker @error('date_created_from') is-invalid @enderror" data-toggle="datepicker">
	                        </div>
	                    </div>
	                </div>

		        	<div class="form-row mb-3 px-2">
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
				<h4 class="my-2">Investors</h4>
	        	<table class="mb-0 table table-striped table-hover">
	                <thead>
		                <tr>
		                    <th>#</th>
		                    <th><a href="{{route('fm.investors.index',sort_by($filterArray,'id'))}}">ID <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('fm.investors.index',sort_by($filterArray,'name'))}}">Name <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('fm.investors.index',sort_by($filterArray,'email'))}}">Email Address <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('fm.investors.index',sort_by($filterArray,'phone'))}}">Phone <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('fm.investors.index',sort_by($filterArray,'role'))}}">Role <i class="fa fa-fw fa-sort"></i></a></th>
		                    <th><a href="{{route('fm.investors.index',sort_by($filterArray,'created_at'))}}">Date Created <i class="fa fa-fw fa-sort"></i></a></th>
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
				                    <td>{!! badge($user->role_name,$user->role=='admin'?'danger':($user->role=='fund-manager'?'info':'success')) !!}</td>
				                    <td>{{ formatDate($user->created_at) }}</td>
				                    <td>
										@php 
				                    		if($user->role=='investor' && $user->investments->count()){ $investments_route_array = ['investor'=>$user->id]; } 
				                    	@endphp
				                    	{!! isset($investments_route_array)? editButton(route('fm.investments.index',$investments_route_array),'Investments','btn-success'):'' !!} {!! isset($investments_route_array)? editButton(route('fm.earnings.index',$investments_route_array),'Earnings','btn-alternate'):'' !!} {!! editButton(route('fm.investors.edit',$user->id)) !!}
										@php 
											unset($investments_route_array)
										@endphp
				                    </td>
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
                	{{ $users->appends($filterArray??[])->links() }}
                </div>




	        </div>
	        <div class="card-footer px-0">
	           <div class="no-gutters mt-1 px-0 col-md-12 row">
				    <div class="col-md-12">
				        <h3 class="card-header-title font-size-lg text-capitalize font-weight-bold ml-3">Statistics</h3>
				    </div>
				    <div class="col-md-12 col-lg-4">
				        <ul class="list-group list-group-flush">
				            <li class="bg-transparent list-group-item">
				                <div class="widget-content p-0">
				                    <div class="widget-content-outer">
				                        <div class="widget-content-wrapper">
				                            <div class="widget-content-left">
				                                <div class="widget-heading">Admins</div>
				                                <div class="widget-subheading">Number of Admins</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">1</div>
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
				                                <div class="widget-heading">Fund Managers</div>
				                                <div class="widget-subheading">Number of Fund Managers</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">2</div>
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
				                                <div class="widget-heading">Investors</div>
				                                <div class="widget-subheading">Number of Investors</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-success">2</div>
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
				                                <div class="widget-heading">Investments</div>
				                                <div class="widget-subheading">Number of Investments</div>
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
				                                <div class="widget-heading">Mature Investments</div>
				                                <div class="widget-subheading">Number of Mature Investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ $stats->mature_investments }}</div>
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
				                                <div class="widget-heading">Immature Investments</div>
				                                <div class="widget-subheading">Number of Immature Investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-warning">{{ $stats->immature_investments }}</div>
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
				                                <div class="widget-heading">Investments Amount</div>
				                                <div class="widget-subheading">Total amount invested</div>
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
				                                <div class="widget-heading">Mature Investments Amount</div>
				                                <div class="widget-subheading">Total amount of mature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ moneyFormat($stats->mature_investments_amount) }}</div>
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
				                                <div class="widget-heading">Immature Investments Amount</div>
				                                <div class="widget-subheading">Total amount of immature investments</div>
				                            </div>
				                            <div class="widget-content-right">
				                                <div class="widget-numbers text-danger">{{ moneyFormat($stats->immature_investments_amount) }}</div>
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
    $('.delete-user').click(function(e){
        e.preventDefault();
        if (confirm('Are you sure you want to delete user?')) {
            $(e.target).closest('form').submit();
        }
    });
</script>
@endsection