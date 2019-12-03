@extends('auth.pageLayout')

@section('content')


<div class="app-container">
        <div class="h-100 bg-plum-plate bg-animation">
            <div class="d-flex h-100 justify-content-center align-items-center">
                <div class="mx-auto app-login-box col-md-6">
                    <div class="app-logo-inverse mx-auto mb-3"></div>
                    <div class="modal-dialog w-100">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="modal-header">
                                <div class="h5 modal-title">Forgot your Password?<h6 class="mt-1 mb-0 opacity-8"><span>Fill in the form below to recover it.</span></h6></div>
                            </div>
                            <div class="modal-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <div>
                                    <form class="">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group"><label for="exampleEmail" class="">Your Email Address</label><input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Address here ..." required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="divider"></div>
                                <h6 class="mb-0">Go to <a href="{{ route('login') }}" class="text-primary">Login</a></h6></div>
                            <div class="modal-footer clearfix">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary btn-lg">Recover Password</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="text-center text-white opacity-8 mt-3">Copyright &copy; Elite Funds {{ date('Y') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
