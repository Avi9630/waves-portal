@extends('auth.layouts.main')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card  mt-4">
                <div class="card-body p-4">

                    <div class="text-center mt-2">
                        <h5 class="text-primary">Welcome Back !</h5>
                        <p class="text-muted">Sign in to continue to iffi.</p>
                        <span>
                            <h4 class="alert-danger"></h4>
                        </span>
                        @foreach (['success', 'info', 'danger', 'warning'] as $msg)
                            @if (Session::has($msg))
                                <div id="flash-message" class="alert alert-{{ $msg }}" role="alert">
                                    {{ Session::get($msg) }}
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="p-2 mt-4">
                        <form method="POST" action="{{ route('login') }}"> @csrf @method('post')

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                                    autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="float-end">
                                    <a href="{{ route('sendOtp') }}" class="text-primary">Forgot
                                        password?</a>
                                </div>
                                <label class="form-label" for="password-input">Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror  password-input"
                                        placeholder="Enter password" id="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn common-btn w-100" type="submit">Sign In</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
