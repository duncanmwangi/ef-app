@extends('layouts.app')

@section('heading', 'Profile')

@section('sub-heading', 'Change Password')

@section('content')
  
<div class="col-md-6">

    @include('common.errors')

    <div class="main-card mb-3 card">
    	<form method="POST" action="{{ route('common.password.update') }}"> 
    		@csrf
	        <div class="card-header">
	            Change Password
	        </div>
	        <div class="card-body">
                <div class="position-relative form-group">
                    <label for="currentPassword" class="">Current Password</label>
                    <input name="currentPassword" id="currentPassword" placeholder="Current Password" type="password" class="form-control @error('currentPassword') is-invalid @enderror">
                </div>
                <div class="position-relative form-group">
                    <label for="newPassword" class="">New Password</label>
                    <input name="newPassword" id="newPassword" placeholder="New Password" type="password" class="form-control @error('newPassword') is-invalid @enderror">
                </div>
                <div class="position-relative form-group">
                    <label for="confirmPassword" class="">Confirm New Password</label>
                    <input name="confirmPassword" id="confirmPassword" placeholder="Confirm New Password" type="password" class="form-control @error('confirmPassword') is-invalid @enderror">
                </div>
	        </div>
	        <div class="card-footer">
	            <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Change Password</button>
	        </div>
        </form>
    </div>
</div>

@endsection
