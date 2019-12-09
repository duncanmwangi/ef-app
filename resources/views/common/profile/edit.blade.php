@extends('layouts.app')

@section('heading', 'Profile')

@section('sub-heading', 'Update Profile')

@section('content')
<div class="col-md-9">
    @include('common.errors')
</div>



<div class="col-md-6">


    <div class="main-card mb-3 card">
    	<form method="POST" action="{{ route('common.profile.update') }}"> 
    		@csrf
	        <div class="card-header">
	            Update Profile
	        </div>
	        <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="firstName" class="">First Name</label>
                            <input name="firstName" id="firstName" placeholder="First Name" type="text" value="{{ old('firstName') ?? $user->firstName }}" class="form-control @error('firstName') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="lastName" class="">Last Name</label>
                            <input name="lastName" id="lastName" placeholder="Last Name" type="text" value="{{ old('lastName') ?? $user->lastName }}" class="form-control @error('lastName') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="email" class="">Email Address</label>
                            <input name="email" id="email" placeholder="Email Address" type="text" value="{{ old('email') ?? $user->email }}" class="form-control @error('email') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="phone" class="">Phone Number</label>
                            <input name="phone" id="phone" placeholder="Phone Number" type="text" value="{{ old('phone') ?? $user->phone }}" class="form-control @error('phone') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="alternatePhone" class="">Alternate Phone</label>
                            <input name="alternatePhone" id="alternatePhone" placeholder="Alternate Phone" type="text" value="{{ old('alternatePhone') ?? $user->alternatePhone }}" class="form-control @error('alternatePhone') is-invalid @enderror">
                        </div>
                    </div>
                </div>




                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="street1" class="">Street Address 1</label>
                            <input name="street1" id="street1" placeholder="Street Address 1" type="text" value="{{ old('street1') ?? $user->street1 }}" class="form-control @error('street1') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="street2" class="">Street Address 2</label>
                            <input name="street2" id="street2" placeholder="Street Address 2" type="text" value="{{ old('street2') ?? $user->street2 }}" class="form-control @error('street2') is-invalid @enderror">
                        </div>
                    </div>
                </div>




                <div class="form-row">
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="city" class="">City</label>
                            <input name="city" id="city" placeholder="City" type="text" value="{{ old('city') ?? $user->city }}" class="form-control @error('city') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="state" class="">State</label>
                            {!! USstatesSelect('state', old('state') ?? $user->state, 'form-control') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="zip" class="">Zip Code</label>
                            <input name="zip" id="zip" placeholder="Zip Code" type="text" value="{{ old('zip') ?? $user->zip }}" class="form-control @error('zip') is-invalid @enderror">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="currentPassword" class="">Current Password</label>
                            <input name="currentPassword" id="currentPassword" placeholder="Current Password" type="password" value="" class="form-control @error('currentPassword') is-invalid @enderror">
                        </div>
                    </div>
                </div>


	        </div>
	        <div class="card-footer">
	            <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Update Profile</button>
	        </div>
        </form>
    </div>
</div>


<div class="col-md-3">


    <div class="main-card mb-3 card">
        <form method="POST" action="{{ route('common.profile.picture') }}" enctype="multipart/form-data"> 
            @csrf
            <div class="card-header">
                Change Profile Picture
            </div>
            <div class="card-body">

                

                <div class="text-center mb-3">
                    <img src="{{ $user->avatarSrc }}" class="rounded " alt="{{ $user->name }}">
                </div>
                <div class="form-row mt-3">
                        <div class="position-relative form-group">
                            <input name="profilePic" id="profilePic" placeholder="Change Profile Picture" type="file"  class="form-control @error('profilePic') is-invalid @enderror">
                        </div>
                </div>




            </div>
            <div class="card-footer">
                <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Change Profile Picture</button>
            </div>
        </form>
    </div>
</div>
@endsection
