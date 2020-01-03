@extends('layouts.app')

@section('heading', 'Earnings')

@section('sub-heading', 'Edit Earnings')

@section('content')




<div class="col-md-6">
@include('common.errors')

    <div class="main-card mb-3 card">
        <form method="POST" action="{{ route('admin.earnings.update',$earning) }}"> 
            @csrf @method('PUT')
            <div class="card-header">
                Edit Earnings
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="investor" class="">Investor ID</label>
                            <input name="investor" id="investor" type="text" disabled="disabled" value="{{ $earning->investment->investor->id }}" class="form-control ">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="investor" class="">Investor Name</label>
                            <input name="investor" id="investor" type="text" disabled="disabled" value="{{ $earning->investment->investor->name }}" class="form-control ">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="investmentVehicle" class="">Investment Vehicle ID</label>
                            <input name="investmentVehicle" id="investmentVehicle" type="text" disabled="disabled" value="{{ $earning->investment->investmentVehicle->id }}" class="form-control ">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="investmentVehicle" class="">Investment Vehicle Title</label>
                            <input name="investmentVehicle" id="investmentVehicle" type="text" disabled="disabled" value="{{ $earning->investment->investmentVehicle->title }}" class="form-control ">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="investmentVehicle" class="">Investment Amount</label>
                            <input name="investmentVehicle" id="investmentVehicle" type="text" disabled="disabled" value="{{ moneyFormat($earning->investment->amount) }}" class="form-control ">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="investmentVehicle" class="">Investment Date</label>
                            <input name="investmentVehicle" id="investmentVehicle" type="text" disabled="disabled" value="{{ formatDate($earning->investment->created_at) }}" class="form-control ">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="date_issued" class="">Date Issued</label>
                            <input name="date_issued" id="date_issued" type="text" disabled="disabled" value="{{ formatDate($earning->date_issued) }}" class="form-control ">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="date_approved" class="">Date Approved</label>
                            <input name="date_approved" id="date_approved" type="text" disabled="disabled" value="{{ formatDate($earning->date_approved) }}" class="form-control ">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="amount" class="">Amount</label>
                            <input name="amount" id="amount" placeholder="Amount" type="number" step="0.01" value="{{ old('amount') ?? $earning->amount }}" class="form-control @error('amount') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="status" class="">Status</label>
                            
                            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="">Select Status</option>
                                @php 
                                $statuses = ['ISSUED', 'APPROVED', 'DECLINED']; 
                                $selectedStatus = old('status') ?? $earning->status ?? '';
                                @endphp
                                @foreach($statuses as $status)
                                    @php $selected = $status==$selectedStatus ?'selected="selected"':''; @endphp
                                    <option value="{{ $status }}" {{$selected}}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="admin_notes" class="">Admin Notes</label>
                            <textarea rows="3" name="admin_notes" id="admin_notes" placeholder="Admin Notes" class="form-control @error('admin_notes') is-invalid @enderror">{{ old('admin_notes') ?? $earning->admin_notes }}</textarea>
                        </div>
                    </div>
                </div>
                

            </div>
            <div class="card-footer">
                <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Update Earning</button>
            </div>
        </form>
    </div>
</div>

@endsection
