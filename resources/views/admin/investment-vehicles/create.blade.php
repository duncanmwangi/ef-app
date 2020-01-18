@extends('layouts.app')

@section('heading', 'Investment Vehicles')

@section('sub-heading', 'Create New Investment Vehicle')

@section('content')
<div class="col-md-9">
    @include('common.errors')
</div>



<div class="col-md-9">


    <div class="main-card mb-3 card">
    	<form method="POST" action="{{ route('admin.investment-vehicles.store') }}"> 
    		@csrf
	        <div class="card-header">

                @if ( !count(request()->all()))
                    {!! editButton(url()->previous(),'Back','btn-xs btn-secondary mx-3 back-btn','lnr-pointer-left') !!}
                @endif

	            Create New Investment Vehicle
	        </div>
	        <div class="card-body">

                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="title" class="">Title</label>
                            <input name="title" id="title" placeholder="Title" type="text" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="description" class="">Description</label>
                            <textarea rows="3" name="description" id="description" placeholder="Description" class="form-control @error('description') is-invalid @enderror">{{ old('description')  }}</textarea>
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="termType" class="">Term Type</label>
                            <select id="termType" name="termType" class="form-control @error('termType') is-invalid @enderror">
                                <option value="">Select termType</option>
                                @php $termTypes = ['monthly'=>'Monthly','quarterly'=>'Quarterly','bi-annual'=>'Bi-annual','annual'=>'Annual']; @endphp
                                @foreach($termTypes as $key => $termType)
                                    @php $selected = $key==old('termType')?'selected="selected"':''; @endphp
                                    <option value="{{ $key }}" {{$selected}}>{{ $termType }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="number_of_terms" class="">Number of Terms</label>
                            <input name="number_of_terms" id="number_of_terms" placeholder="Number of Terms" type="text" value="{{ old('number_of_terms') }}" class="form-control @error('number_of_terms') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="waiting_period" class="">Waiting Period(months)</label>
                            <input name="waiting_period" id="waiting_period" placeholder="Waiting Period" type="text" value="{{ old('waiting_period') }}" class="form-control @error('waiting_period') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="status" class="">Status</label>
                            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @php $statuses = ['active'=>'Active','suspended'=>'Suspended']; @endphp
                                @foreach($statuses as $key => $status)
                                    @php $selected = $key==old('status')?'selected="selected"':''; @endphp
                                    <option value="{{ $key }}" {{$selected}}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                

	        </div>
	        <div class="card-footer">
	            <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Create New Investment Vehicle</button>
	        </div>
        </form>
    </div>
</div>

@endsection
