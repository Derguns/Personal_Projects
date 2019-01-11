@extends('master')
@section('title', 'My Alerts')

@section('content')

<body style="">
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="http://localhost/laravel/laraveltest/ajaxfiles/manage_tabs.js"></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
  <a href='{{ route('account') }}'><div id='returnButton'>My Account</div></a>
	<div id="newsView">Viewing Alerts</div>
	<div id="questWords"> Below is a list of all of your last 100 alerts, sorted by newest first. 
	</div>
	<div id="questWords">
		@foreach($alertlist as $alert)
		<div style="border-bottom:1px dotted;padding-left:10px;"><div style='text-align:left;'>{!! $alert->text !!}</div><div style='text-align:right;'><i><?php echo date('m-d-Y H:i:s', $alert->dated);?></i></div></div>
		@endforeach
	</div>
	</ul>
	@endsection
