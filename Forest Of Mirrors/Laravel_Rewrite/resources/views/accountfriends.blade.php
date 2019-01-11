@extends('master')
@section('title', 'View Friendslist')

@section('content')
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
 <!-- Taken from Bootstrap's documentation -->
<div class='modal fade'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Cancel'></button>
        <h4 class='modal-title'>Managing Friend</h4>
      </div>
      <div class='modal-body'>
        <p>Manage friend </p>
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
  <script src="http://localhost/laravel/laraveltest/ajaxfiles/manage_friends.js"></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
<center>
	<a href='{{ route('account') }}'><div id='returnButton'>My Account</div></a>
	<div id="newsView">Manage Friendslist</div>
	<div id="questWords">
		Here is a list of all of your current friends.
	</div>
	<div id="questWords">
		<button class="btn btn-default" data-toggle='modal' data-target='.modal' data-task='2'>Friend Requests</button><button class="btn btn-default">Block List</button>
	</div>
	<div id="questWords" style='display:flex;flex-wrap:wrap;padding:15px;padding-left:80px;'>
	@foreach($friendlist as  $index => $friend)
		<div style="padding:2px;border:1px solid;border-radius:10px;width:145px;"><a href='/profile/view/{{$friend->username}}'><img src='{{$profilelist[$index]->avatar}}' style="width:100px;height:100px;"/><br>{{$friend->username}}</a> <img src='{{ asset("/images/icons/delete_icon.png") }}' data-toggle='modal' data-target='.modal' data-task='1' data-friend_id='{{$friend->uid}}'/></div>
	@endforeach
	</div>
</center>
 @endsection
