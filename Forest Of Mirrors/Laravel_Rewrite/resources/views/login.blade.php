@extends('master')
@section('title', 'Login')

@section('content')
    <div class="card-header">{{ __('Login') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row" style="margin-left:-150px;">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-left:-200px;">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" style="margin-left:0px;width:200px !important;" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-left:-175px;">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
									
                                    <label class="form-check-label" for="remember" style="margin-left:15px;">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" id="returnButton" style="margin-left:75px">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('resetpass') }} " style="margin-left:-275px;margin-top:10px;">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection
