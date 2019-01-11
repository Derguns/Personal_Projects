@extends('master')
@section('title', 'Reset Password')

@section('content')
    <div class="card-header">{{ __('Reset Password') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('resetpass') }}">
                        @csrf

                        <div class="form-group row" style="margin-left:-150px;">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <div class="col-md-6">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" style="margin-left:-200px;">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" style="margin-left:0px;width:200px !important;" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" id="returnButton" style="margin-left:75px">
                                    {{ __('Reset Password') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('login') }} " style="margin-left:-275px;margin-top:10px;">
                                    {{ __('Login') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection
