@extends('master')
@section('title', 'Change Username')

@section('content')
  <a href='{{ route('account') }}'><div id='returnButton'>My Account</div></a>
	<div id="newsView">Changing Username</div>
	<div id="questWords">Here you are able to change your username. It will cost <img src='{{ asset("images/icons/orb5.png") }}'></img> 500 Reactor Stones in order to complete this action, and you will be automatically logged out once cofirmed. 
	</div>
<form method="POST" action="{{ route('username') }}">
	<center>
        <div class="form-group row">
		<div id="questWords">
				@csrf
                    <div class="form-group row" style="">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('New Username') }}</label>
                        <div class="col-md-6">
                        <input id="username" type="text" style="width:300px!important" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>					
				</div>
			<div id="questWords">
                    <div class="form-group row" style="">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Confirm Current Username') }}</label>
                        <div class="col-md-6">
                        <input id="currentuser" type="text" style="width:300px!important" class="form-control{{ $errors->has('currentuser') ? ' is-invalid' : '' }}" name="currentuser" value="" required autofocus>

                                @if ($errors->has('currentuser'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('currentuser') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>					
 			</div>
            </div>
	</center>
    <button type="submit" id="returnButton" style="margin-left:350px;">
    Change Username
    </button>
</form>

 @endsection
