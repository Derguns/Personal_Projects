@extends('master')
@section('title', 'The Coffers')

@section('content')

<div class='modal fade'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Cancel'></button>
        <h4 class='modal-title'>Managing Bank Account</h4>
      </div>
      <div class='modal-body'>
        <p>Bank Text Here</p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://localhost/laravel/laraveltest/ajaxfiles/manage_bank.js"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
{{ $alert }}
<a href='{{ route('account') }}'><div id='returnButton'>My Account</div></a>
<br>
	<div id='questWords'>
		<img src="{{ asset("images/icons/bankpile.png") }}"/>
		<br>
		Welcome to the First Veil Approved bank of the xth Century,
		you currently have <img src="{{ asset("images/icons/orb4.png") }}"/> {{ $bank_blue }} blue stones and <img src="{{ asset("images/icons/orb5.png") }}"/> {{ $bank_reactor }} reactor stones deposited
		into your bank account.
	</div>
	<div id="newsView">My Bank Account</div>
	<div id="questWords" style="display:flex;padding-left:35%;">
			<div data-toggle="modal" data-target=".modal" data-task="1" style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">
				Manage<br>
				Bank Account
			</div> 
			<div data-toggle="modal" data-target=".modal" data-task="3" style="filter:border:1px solid;border-radius:120px;background-color:rgba(83, 173, 94, 0.5803921568627451) !important;margin:1px;width:120px;height:120px;padding-top:35px;">
				Transfer<br>
				Stones
			</div>
	</div>
@endsection
