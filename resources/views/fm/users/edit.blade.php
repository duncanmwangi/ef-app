@extends('layouts.app')

@section('heading', 'Investors')

@section('sub-heading', 'Create New Investor')

@section('content')
<div class="col-md-9">
    @include('common.errors')
</div>



<div class="col-md-9">


    <div class="main-card mb-3 card">
    	<form method="POST" action="{{ route('fm.investors.update',$user->id) }}"> 
    		@csrf @method('PUT')
	        <div class="card-header">
                {!! editButton(route('fm.investors.index'),'Back','btn-xs btn-secondary mx-3 back-btn','lnr-pointer-left') !!}
	            Edit Investor
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
                            <input name="lastName" id="lastName" placeholder="Last Name" type="text" value="{{ old('lastName') ?? $user->lastName   }}" class="form-control @error('lastName') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="email" class="">Email Address</label>
                            <input name="email" id="email" placeholder="Email Address" type="text" value="{{ old('email') ?? $user->email   }}" class="form-control @error('email') is-invalid @enderror">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="phone" class="">Phone Number</label>
                            <input name="phone" id="phone" placeholder="Phone Number" type="text" value="{{ old('phone') ?? $user->phone  }}" class="form-control @error('phone') is-invalid @enderror">
                        </div>
                    </div>
                </div>


                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="alternatePhone" class="">Alternate Phone</label>
                            <input name="alternatePhone" id="alternatePhone" placeholder="Alternate Phone" type="text" value="{{ old('alternatePhone') ?? $user->alternatePhone  }}" class="form-control @error('alternatePhone') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="password" class="">User Role</label>
                            <select id="dRole" name="role" class="form-control @error('role') is-invalid @enderror">
                                @php $roles = ['investor'=>'Investor']; @endphp
                                @foreach($roles as $key => $role)
                                    @php 
                                    $selectedRrole = old('role') ?? $user->role;
                                    $selected = $key==$selectedRrole?'selected="selected"':''; 
                                    @endphp
                                    <option value="{{ $key }}" {{$selected}}>{{ $role }}</option>
                                @endforeach
                            </select>
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
                            @php $errorClass =$errors->get('state')?'is-invalid':''  @endphp
                            {!! USstatesSelect('state', old('state')??$user->state, 'form-control '.$errorClass) !!}
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
	            <button class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-primary">Update Investor</button>
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
            }else if(cRole=='fund-manager'){
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
                }else if(cRole=='fund-manager'){
                    $('.dfms').show();
                    $('.dfm').hide();
                }else{
                    $('.dfms').hide();
                }
            });

        // $("body").on("change","select.rfm",function(){
        //     let rfm = $(this).val();
        //     if(rfm.length>0 && $('#dRole').val()=='investor'){
        //         let url = "{{route('admin.users.jsonRfms','RFM-ID-HOLDER')}}";
        //         $.get(url.replace('RFM-ID-HOLDER',rfm) ,function(data) {
        //             $('.fm').empty();
        //             $('.fm').append('<option value="" disable="true" selected="true">Select Fund Manager</option>');
        //             $.each(JSON.parse(data), function(index, fmObj){
        //                 $('.fm').append('<option value="'+ fmObj.id +'">'+ fmObj.name +'</option>');
        //             });
        //         });
        //     }else if($('#dRole').val()=='investor'){
        //             $('.fm').empty();
        //             $('.fm').append('<option value="" disable="true" selected="true">Select Fund Manager</option>');
        //     }
        // });


        });



    </script>
@endsection
