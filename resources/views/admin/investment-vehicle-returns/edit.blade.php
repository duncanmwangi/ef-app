@extends('layouts.app')

@section('heading', 'Investment Vehicle Returns')

@section('sub-heading', 'Edit Investment Vehicle Return')

@section('content')
<div class="col-md-9">
    @include('common.errors')
</div>



<div class="col-md-9">


    <div class="main-card mb-3 card">
        <form method="POST" action="{{ route('admin.investment-vehicle-returns.update',[$investmentVehicle,$investmentVehicleReturn]) }}"> 
            @csrf @method('PUT')
            <div class="card-header">
                Edit Investment Vehicle Return
                <div class="btn-actions-pane-right">{!! editButton(route('admin.investment-vehicle-returns.index',$investmentVehicle),$investmentVehicle->title.' '.ucwords($investmentVehicle->term).' Returns','btn-secondary','lnr-pointer-left') !!}</div>
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="title" class="">Title</label>
                            <input name="title" id="title" placeholder="Title" type="text" value="{{ old('title') ?? $investmentVehicleReturn->title }}" class="form-control @error('title') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="percent_return" class="">Percent Return</label>
                            <input name="percent_return" id="percent_return" placeholder="Percent Return" type="number"  step="0.01" value="{{ old('percent_return') ?? $investmentVehicleReturn->percent_return }}" class="form-control @error('percent_return') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="amount" class="">Status</label>
                            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @php 
                                $statuses = ['PENDING', 'ISSUED']; 
                                $selectedStatus = old('status') ?? $investmentVehicleReturn->status;
                                @endphp
                                @foreach($statuses as $status)
                                    @php $selected = $status == $selectedStatus ?'selected="selected"':''; @endphp
                                    <option value="{{ $status }}" {{$selected}}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="date_to_issue" class="">Date To Issue</label>
                            <input name="date_to_issue" id="date_to_issue" placeholder="Date To Issue" type="text" value="{{ formatDate(old('date_to_issue') ?? $investmentVehicleReturn->date_to_issue,'m/d/Y') }}" class="form-control datepicker @error('date_to_issue') is-invalid @enderror" data-toggle="datepicker">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="admin_notes" class="">Admin Notes</label>
                            <textarea rows="3" name="admin_notes" id="admin_notes" placeholder="Admin Notes" class="form-control @error('admin_notes') is-invalid @enderror">{{ old('admin_notes') ?? $investmentVehicleReturn->admin_notes }}</textarea>
                        </div>
                    </div>
                </div>
                

            </div>
            <div class="card-footer">
                <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Edit Investment Vehicle Return</button>
            </div>
        </form>
    </div>
</div>

@endsection
