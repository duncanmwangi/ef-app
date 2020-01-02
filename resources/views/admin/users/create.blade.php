@extends('layouts.app')

@section('heading', 'Users')

@section('sub-heading', 'Create New User')

@section('content')
<div class="col-md-9">
    @include('common.errors')
</div>



<div class="col-md-9">


    <div class="main-card mb-3 card">
    	<form method="POST" action="{{ route('admin.users.store') }}"> 
    		@csrf
	        <div class="card-header">
	            Create New User
	        </div>
	        <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="firstName" class="">First Name</label>
                            <input name="firstName" id="firstName" placeholder="First Name" type="text" value="{{ old('firstName') }}" class="form-control @error('firstName') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="lastName" class="">Last Name</label>
                            <input name="lastName" id="lastName" placeholder="Last Name" type="text" value="{{ old('lastName')  }}" class="form-control @error('lastName') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="email" class="">Email Address</label>
                            <input name="email" id="email" placeholder="Email Address" type="text" value="{{ old('email')  }}" class="form-control @error('email') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="phone" class="">Phone Number</label>
                            <input name="phone" id="phone" placeholder="Phone Number" type="text" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="alternatePhone" class="">Alternate Phone</label>
                            <input name="alternatePhone" id="alternatePhone" placeholder="Alternate Phone" type="text" value="{{ old('alternatePhone') }}" class="form-control @error('alternatePhone') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="password" class="">User Role</label>
                            <select id="dRole" name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">Select User Role</option>
                                @php $roles = ['investor'=>'Investor','fund-manager'=>'Fund Manager','regional-fund-manager'=>'Regional Fund Manager','admin'=>'Administrator']; @endphp
                                @foreach($roles as $key => $role)
                                    @php $selected = $key==old('role')?'selected="selected"':''; @endphp
                                    <option value="{{ $key }}" {{$selected}}>{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row dfms">
                    <div class="col-md-6 drfm">
                        <div class="position-relative form-group">
                            <label for="rfm" class="">Regional Fund Manager</label>
                            <select name="rfm" class="form-control rfm @error('rfm') is-invalid @enderror">
                                <option value="">Select Regional Fund Manager</option>
                                @foreach($regionalFundManagers as $rfm)
                                    @php $selected = $rfm->id==old('rfm')?'selected="selected"':''; @endphp
                                    <option value="{{ $rfm->id }}"  {{$selected}}>{{ $rfm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 dfm">
                        <div class="position-relative form-group">
                            <label for="fm" class="">Fund Manager</label>
                            <select name="fm" class="form-control fm @error('fm') is-invalid @enderror">
                                <option value="">Select Fund Manager</option>
                                @php $fundManagers = get_fundmanagers(old('rfm')) @endphp
                                @if($fundManagers)
                                    @foreach($fundManagers as $fm)
                                        @php $selected = $fm->id==old('fm')?'selected="selected"':''; @endphp
                                        <option value="{{ $fm->id }}"  {{$selected}}>{{ $fm->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>





                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="street1" class="">Street Address 1</label>
                            <input name="street1" id="street1" placeholder="Street Address 1" type="text" value="{{ old('street1') }}" class="form-control @error('street1') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="street2" class="">Street Address 2</label>
                            <input name="street2" id="street2" placeholder="Street Address 2" type="text" value="{{ old('street2') }}" class="form-control @error('street2') is-invalid @enderror">
                        </div>
                    </div>
                </div>




                <div class="form-row">
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="city" class="">City</label>
                            <input name="city" id="city" placeholder="City" type="text" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="state" class="">State</label>
                            @php $errorClass =$errors->get('state')?'is-invalid':''  @endphp
                            {!! USstatesSelect('state', old('state'), 'form-control '.$errorClass) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="zip" class="">Zip Code</label>
                            <input name="zip" id="zip" placeholder="Zip Code" type="text" value="{{ old('zip') }}" class="form-control @error('zip') is-invalid @enderror">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="password" class="">User Password</label>
                            <input name="password" id="password" placeholder="User Password" type="password" value="" class="form-control @error('password') is-invalid @enderror">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="password" class="">Confirm User Password</label>
                            <input name="cpassword" id="cpassword" placeholder="Confirm User Password" type="password" value="" class="form-control @error('password') is-invalid @enderror">
                        </div>
                    </div>
                </div>


	        </div>
	        <div class="card-footer">
	            <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Create New User</button>
	        </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
    <script type="text/javascript">
       $(document).ready(function() {
            let cRole = $('#dRole').val();
            if(cRole=='investor'){
                $('.dfms').show();
                $('.dfm').show();
                $('.drfm').show();
            }else if(cRole=='fund-manager'){
                $('.drfm').show();
                $('.dfms').show();
                $('.dfm').hide();
            }else{
                $('.dfms').hide();
            }

            $('#dRole').change(function(){
               let cRole = $('#dRole').val();
                if(cRole=='investor'){
                    $('.dfms').show();
                    $('.dfm').show();
                    $('.drfm').show();
                }else if(cRole=='fund-manager'){
                    $('.drfm').show();
                    $('.dfms').show();
                    $('.dfm').hide();
                }else{
                    $('.dfms').hide();
                }
            });

        $("body").on("change","select.rfm",function(){
            let rfm = $(this).val();
            if(rfm.length>0 && $('#dRole').val()=='investor'){
                let url = "{{route('admin.users.jsonRfms','RFM-ID-HOLDER')}}";
                $.get(url.replace('RFM-ID-HOLDER',rfm) ,function(data) {
                    $('.fm').empty();
                    $('.fm').append('<option value="" disable="true" selected="true">Select Fund Manager</option>');
                    $.each(JSON.parse(data), function(index, fmObj){
                        $('.fm').append('<option value="'+ fmObj.id +'">'+ fmObj.name +'</option>');
                    });
                });
            }
            else if($('#dRole').val()=='investor'){
                    $('.fm').empty();
                    $('.fm').append('<option value="" disable="true" selected="true">Select Fund Manager</option>');
            }
        });


        });



    </script>
@endsection
