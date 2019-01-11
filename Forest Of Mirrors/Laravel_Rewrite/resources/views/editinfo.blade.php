@extends('master')
@section('title', 'Managing Email / Password')

@section('content')
  <a href='{{ route('account') }}'><div id='returnButton'>My Account</div></a>
	<div id="newsView">Editing Email and Password</div>
	<div id="questWords">Manage and change your email and password below. Any changes made here will require a password and email confirmation, and will log you out once they are submitted.
	</div>
<form method="POST" action="{{ route('editinfo') }}">
	<center>
        <div class="form-group row">
		<div id="questWords">
				@csrf
                    <div class="form-group row" style="">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('New E-Mail Address') }}</label>
                        <div class="col-md-6">
                        <input id="email" type="email" style="width:300px!important" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>					
                        <div class="form-group row" style="">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __(' New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" style="width:300px!important" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                      </div>				
                        <div class="form-group row" style="">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Repeat New Password') }}</label>

                            <div class="col-md-6">
                                <input id="confirmpassword" type="password" style="width:300px!important" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="confirmpassword" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                      </div>					</div>
			<div id="questWords">
                    <div class="form-group row" style="">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Confirm Current E-Mail Address') }}</label>
                        <div class="col-md-6">
                        <input id="pastemail" type="email" style="width:300px!important" class="form-control{{ $errors->has('pastemail') ? ' is-invalid' : '' }}" name="pastemail" value="" required autofocus>

                                @if ($errors->has('pastemail'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pastemail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>					
                        <div class="form-group row" style="">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="pastpassword" type="password" style="width:300px!important" class="form-control{{ $errors->has('pastpassword') ? ' is-invalid' : '' }}" name="pastpassword" required>

                                @if ($errors->has('pastpassword'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pastpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                      </div>				
			</div>
            </div>
	</center>
    <button type="submit" id="returnButton" style="margin-left:350px;">
    Save Changes
    </button>
</form>

 @endsection
