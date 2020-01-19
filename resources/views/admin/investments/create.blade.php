@extends('layouts.app')

@section('heading', 'Investments')

@section('sub-heading', 'Create New Investment')

@section('content')
<div class="col-md-9">
    @include('common.errors')
</div>



<div class="col-md-9">


    <div class="main-card mb-3 card">
        <form method="POST" action="{{ route('admin.investments.store') }}"> 
            @csrf
            <div class="card-header">
                {!! editButton(route('admin.investments.index'),'Back','btn-xs btn-secondary mx-3 back-btn','lnr-pointer-left') !!}
                
                Create New Investment
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="title" class="">Investor</label>
                            <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                <option value="">Select Investor</option>
                                @foreach($investors as $investor)
                                    @php $selected = $investor->id==old('user_id') ?'selected="selected"':''; @endphp
                                    <option value="{{ $investor->id }}" {{$selected}}>{{ $investor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="description" class="">Investment Vehicle</label>
                            <select id="investment_vehicle_id" name="investment_vehicle_id" class="form-control @error('investment_vehicle_id') is-invalid @enderror">
                                <option value="">Select Investment Vehicle</option>
                                @foreach($investmentVehicles as $investmentVehicle)
                                    @php $selected = $investmentVehicle->id==old('investment_vehicle_id') ?'selected="selected"':''; @endphp
                                    <option value="{{ $investmentVehicle->id }}" {{$selected}}>{{ $investmentVehicle->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="amount" class="">Amount</label>
                            <input name="amount" id="amount" placeholder="Amount" type="number" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="status" class="">Investment Status</label>
                            
                            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="">Select Investment Status</option>
                                @php 
                                $statuses = ['PENDING', 'PROCESSING','APPROVED','DECLINED']; 
                                @endphp
                                @foreach($statuses as $status)
                                    @php $selected = $status==old('status') ?'selected="selected"':''; @endphp
                                    <option value="{{ $status }}" {{$selected}}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="investor_notes" class="">Investor Notes</label>
                            <textarea rows="3" name="investor_notes" id="investor_notes" placeholder="Client Notes" class="form-control @error('investor_notes') is-invalid @enderror">{{ old('investor_notes') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="admin_notes" class="">Admin Notes</label>
                            <textarea rows="3" name="admin_notes" id="admin_notes" placeholder="Admin Notes" class="form-control @error('admin_notes') is-invalid @enderror">{{ old('admin_notes') }}</textarea>
                        </div>
                    </div>
                </div>
                

            </div>
            <div class="card-footer">
                <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Create New Investment</button>
            </div>
        </form>
    </div>
</div>

@endsection
