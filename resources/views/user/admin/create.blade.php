@include('layouts.header')
@include('layouts.includes.bar')
<div class="hero-head">

    <div class="hero-content">

        <h1 class="logo">{{ $title }}</h1>

        <div class="spacer20"></div>

        <div class="container panel">
            <div class="row">
                <div class="col-md-12">

                    <div class="spacer20"></div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <label for="name" class="col-md-4 text-right login-page-text">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="spacer20"></div>

                        <div class="row">
                            <label for="email" class="col-md-4 text-right login-page-text">{{ __('Email Address') }}</label>
        
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="spacer20"></div>

                        <div class="row">
                            <label for="password" class="col-md-4 text-right login-page-text">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="spacer20"></div>

                        <div class="row">
                            <label for="password-confirm" class="col-md-4 text-right login-page-text">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="spacer20"></div>

                        <div class="row">
                            <div class="col-md-4 text-right"></div>

                            <div class="col-md-3 text-left">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="login-page-text remember-me" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <div class="col-md-3 text-right">
                                @if (Route::has('password.request'))
                                <a class="login-page-text forgot-password" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                            </div>
                        </div>

                        <div class="spacer20"></div>

                        <div class="rows">
                            <div class="col-md-3 text-center">
                                <button type="submit" class="btn btn-gradient-purple-alternative btn100">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="spacer20"></div>

                </div>
            </div>
        </div>

        <div class="spacer20"></div>

    </div>

</div>
@include('layouts.footer')