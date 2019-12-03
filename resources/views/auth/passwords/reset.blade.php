@extends('auth.pageLayout')

@section('content')



<div class="app-container">
        <div class="h-100 bg-plum-plate bg-animation">
            <div class="d-flex h-100 justify-content-center align-items-center">
                <div class="mx-auto app-login-box col-md-8">
                    <div class="app-logo-inverse mx-auto mb-3"></div>
                    <div class="modal-dialog w-100 mx-auto">
                        <div class="modal-content">
                                <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                            <div class="modal-body">
                                <div class="h5 modal-title text-center">
                                    <h4 class="mt-2">
                                        <div>Reset Password</div>
                                    </h4>
                                </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <input name="email" id="email" placeholder="Email here..." type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" autofocus>

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
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <input name="password_confirmation" id="password_confirmation" placeholder="Confirm Password here..." type="password" class="form-control @error('password_confirmation') is-invalid @enderror">
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <div class="modal-footer clearfix">
                                <div class="float-left">&nbsp;</div>
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
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
