@extends('auth.pageLayout')

@section('content')
    <div class="app-container">
        <div class="h-100 bg-info bg-animation">
            <div class="d-flex h-100 justify-content-center align-items-center">
                <div class="mx-auto app-login-box col-md-8">
                    <div class="app-logo-inverse mx-auto mb-3"></div>
                    <div class="modal-dialog w-100 mx-auto">
                        <div class="modal-content">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                            <div class="modal-body">
                                <div class="h5 modal-title text-center">
                                    <h4 class="mt-2">
                                        <div>Welcome back,</div>
                                        <span>Please sign in to your account below.</span>
                                    </h4>
                                </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <input name="email" id="email" placeholder="Email here..." type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <input name="password" id="password" placeholder="Password here..." type="password" class="form-control @error('password') is-invalid @enderror">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative form-check"><input name="remember" id="remember" type="checkbox" class="form-check-input"{{ old('remember') ? 'checked' : '' }}><label for="remember" class="form-check-label" >Keep me logged in</label></div>
                                @if (Route::has('password.request'))
                                <div class="divider"></div>
                                <h6 class="mb-0">Forgot Password? <a href="{{ route('password.request') }}" class="text-primary">Recover Password</a></h6>
                                @endif
                            </div>
                            <div class="modal-footer clearfix">
                                <div class="float-left">&nbsp;</div>
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary btn-lg">Login to Dashboard</button>
                                </div>
                            </div>
                                </form>
                        </div>
                    </div>
                    <div class="text-center text-white opacity-8 mt-3">Copyright &copy; Solar Funds {{ date('Y') }}</div>
                </div>
            </div>
        </div>
    </div>

@endsection
