<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	@if($logged_in)

		<script type='text/javascript'>
	function getXMLHttp()
{
  var xmlHttp

  try
  {
    //Firefox, Opera 8.0+, Safari
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    //Internet Explorer
    try
    {
      xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
    }
    catch(e)
    {
      try
      {
        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
      }
      catch(e)
      {
        alert('Your browser does not support AJAX!')
        return false;
      }
    }
  }
  return xmlHttp;
}
function switchNavbar()
{
  var xmlHttp = getXMLHttp();
  
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
    }
  }

  xmlHttp.open('GET', 'http://localhost/laravel/laraveltest/ajaxfiles/navbar.php?username={{$username}}&usercode={{$usercode}}', true); 
  xmlHttp.send(null);
}
	</script>
	@endif
	<script>
		$(document).ready(function(){
			$("#hideshow").click(function(){
				$(".parent2").hide(1000);
				$("#parentsmol").show(1000);
				switchNavbar();
			});
			$("#showhide").click(function(){
				$("#parentsmol").hide(1000);
				$(".parent2").show(1000);
				switchNavbar();
			});
		});
	</script>
	<link href="{{ asset("public/css/app.css") }}" rel="stylesheet" title="elements">
    <title> @yield('title') </title>
  </head>
  <body>
 <body>
    <div id="con">
	<div id="wrapper">
</div>
	<div id="noFloat">
	<div id="header image">
		<center>
		<a href='{{ route('index') }}'><img src="{{ asset("images/icons/FoMHeader.png") }}"/>
	</div>
	
	<div id="menu">
		<a href='/myadopts/'><img src='{{ asset("images/icons/holdbutton.png") }}' /></a><a href='/creche'><img src='{{ asset("images/icons/crechebutton.png") }}' /></a><a href='/explore'><img src='{{ asset("images/icons/explorebutton.png") }}' /></a><a href='/shopping'><img src='{{ asset("images/icons/stallsbutton.png") }}'/></a><a href='/forum'><img src='{{ asset("images/icons/forumbutton.png") }}'/></a>
	</div>		
	@if($logged_in)
	<div id="parent">
		<div id="wide">
			<div id="parentsmol" class="parentsmol" style='
			@if($closeicon == 1)
				display:none;
			@endif
			'>
					<img src="{{ asset("images/icons/closeright.PNG") }}" style='margin-left:0px;margin-top:0px;' id='showhide'></img>
					@if($msgs > 0 || $interactPets > 0 || $interactScours > 0 || $alchemyDone > 0)
						<img src="{{ asset("images/icons/bellicon.PNG") }}" style='margin-left:5px;margin-top:-10px;'/>
					@endif
			</div>
			<div id="parent2" class ="parent2" style='
					@if($closeicon == 0)
						display:none;
					@endif '>
				<div id="blueStones" style="width:220px">
					<center>
						<a href="/inventory"><img src="{{ asset("images/icons/inventory.PNG") }}" style='margin-right:2px;'></img></a>
						<a href="/contest"><img src="{{ asset("images/icons/image2.PNG") }}" style='margin-right:2px;'></img></a>
						<a href="/battle"><img src="{{ asset("images/icons/image3.PNG") }}" style='margin-right:2px;'></img></a>
						<a href="/wishlist"><img src="{{ asset("images/icons/image1.PNG") }}" style='margin-right:2px;'></img></a>
						<a href="/scour"><img src="{{ asset("images/icons/treasure_map.PNG") }}" style='margin-right:2px;'></img></a>
						@if($interactScours > 0)
							<img src="{{ asset("images/icons/bellicon.PNG") }}" style='margin-left:-10px;margin-top:-10px;'/>
						@endif
						<a href="/bestiary/attached"><img src="{{ asset("images/icons/collection_icon_black.png") }}" style='margin-right:2px;'></img></a>
						@if($interactPets > 0)
							<img src="{{ asset("images/icons/bellicon.PNG") }}" style='margin-left:-10px;margin-top:-10px;'/>
						@endif
						<a href="{{ route('alchemy') }}"><img src='/laravel/laraveltest/images/icons/{{$userClan}}alchemy.png' style='margin-right:2px;'></img></a>
						@if($alchemyDone > 0)
							<img src="{{ asset("images/icons/bellicon.PNG") }}" style='margin-left:-10px;margin-top:-10px;'/>
						@endif
						<a href="/messages"><img src="{{ asset("images/icons/black-envelope.png") }}" style='margin-right:2px;'></img>
						@if($msgs > 0 )
							<img src="{{ asset("images/icons/bellicon.PNG") }}" style='margin-left:-10px;margin-top:-10px;'/>
						@endif
						</a>
						</center>
						<img src="{{ asset("images/icons/closeleft.PNG") }}" style='margin-left:200px;margin-top:-30px;' id='hideshow'></img>
					</div>
			</div>

		</div>
		<div id="wider"></div>
		

			<div id="narrow">
				<div id="parent2">
					<div id="account"><center><a href="{{ route('account') }}"><img src="{{ asset("images/icons/user-icon.png") }}"></img><br>Account</a></center></div>
					<div id="logout"><center><a href="/login/logout"><img src="{{ asset("images/icons/exit.png") }}"></img><br>Logout</a></center></div>
					<div id="weather"><center><img src="/laravel/laraveltest/images/icons/{{$season}}.png" title="{{$season}}"><img src="/laravel/laraveltest/images/icons/{{$weather}}.png" title="{{$weather}}"><br></center></div>
					<div id="clan"><center><a href='/leader'><img src='/laravel/laraveltest/images/icons/{{$clan}}con.png'></img><br><div style='margin-top:-2px'>{{$clan}}</div></a></center></div>
				</div>
			</div>
		</div>
	@else
	<div id="parentLogin">
		<div id="wideLogin">
		</div>
		<div id="widerLogin"></div>
			<div id="narrower" style="font-size:12px;padding-top:5px;padding-left:20px;width:200px;height:50px;color:#1d1d1d">
				<div style='padding-top:5px;font-size:20px;'><a href='/login'>Login</a></div><div style='width:20px;'></div><br><div id='register'>Need an account? <a href='/register'>Register.</a></div>
			</div>
</div>	
	@endif

	<br>
	@if($logged_in && count($alertping) > 0)
	<script src="{{ asset("ajaxfiles//alerts.js") }}"></script>
       <div id="alers" style='font-size:12px;border-radius:10px;border:2px solid;padding-top:5px;padding-right:5px;'>
	    @foreach($alertping as $indexKey => $alert)
			<div style="border-bottom:1px dotted;padding-left:10px;" class="alerted"><div style='text-align:left;'>💡 {!! $alert->text !!}</div><div style='text-align:right;'><i><?php echo date('m-d-Y H:i:s', $alert->dated);?></i> <img src="http://forestofmirrors.x10.mx/templates/icons/delete.gif" onclick="clearAlert('{{$alert->aid}}','{{$user->uid}}', '{{$indexKey}}')" value="x" id="alertedButton"></div></div>
		@endforeach
		<div style='text-align:right'><a href='{{ route('alerts') }}'>View {{$alert_count}} More...</a></div>
		</div>
	@endif
	@if($user_group == 'admin' && $reportsLeft > 0)
	<div id="alers" style='background: #f38a7bb3 !important;border: 3px solid #790707 !important;'>
		<div id="alers1"><a href='/report/reportProcess' style="color:red !important">Hello {{$username}}! There are {$reportsLeft} reports that need to be checked.</a></div></div>	
    @endif
	<br>
	@if($logged_in)
	<div id="parentProfileBar">
		<div id="wideest"></div>
		<div id="profileBar">
			<div id='profileBarFlexInfo'>
				<div id='profileBarAvatar'>
					<a href='{{ route('editprofile') }}'><img height="60" width="60" src='{{$avatar}}'></img></a>
				</div>
				<div id='profileBarFavPet' style='margin-left:-20px;'>
					<a href='battle/change'><img height="45" width="45" src='http://localhost/laravel/laraveltest/image/{{$favpet}}'></img><br><div style='margin-left:5px'>({{$favpet}})</div></a>
				</div>
			</div>
			<div id='ProfileBarUserinfo'>
				<div id='ProfileBarUsername'>
					<center><a href='profile/view/{{$username}}'><div style='margin-left:px'>{{$username}}</div></a></center>
				</div>
				<div id='profileBarClan' style='margin-left:5px;width:500px;font-size:8px'>
					<center><img src='{{ asset("images/icons/orb4.png") }}'></img> {{$bluestones}} <img src='{{ asset("images/icons/orb5.png") }}'></img> {{$reactorstones}}</center>
				</div>
			</div>
		</div>
	</div>
	@endif
	<div id="center">
		<div id='documentTitle'><h1><img src='{{ asset("images/icons/swirly.png") }}'></img>@yield('title')</h1></div>
		<br>
			<center>
			@if($faction != 'none' or !$logged_in)
				@if($user_group == 'banned')
					<center> You are currently banned! The reason for your ban is: <br> {$ban_reason}. <br>You will be unbanned automatically on {$ban_time_left}.
				@else
					<center>
					@if($form_alert != 1)
						<div class="alert alert-success" role="alert">{!! $form_alert !!}</div><br>
					@endif
					@yield('content') </center>
				@endif
			@else
				@if($logged_in)
					@if($page == 'clans' or $page1 == 'clans')
						<center>
					@if($form_alert != 1)
						<div class="alert alert-success" role="alert">{!! $form_alert !!}</div><br>
					@endif
						@yield('content') </center>
					@else
						{$optionalContent}
					@endif
				@else
					<center>
					@if($form_alert != 1)
						<div class="alert alert-success" role="alert">{!! $form_alert !!}</div><br>
					@endif
				    @yield('content')</center>
				@endif
			@endif
			</center>
			<br><br>
			<center>
<br>
	</div>
	</div>

<center>
	<div id="footerPush"><div id="footerContent"><center>★ <a href="http://forestofmirrors.x10.mx/online">{{$online}} Online</a> ★</center><center>
	<hr>			
<div class="footer">

<p>
<right><a href="http://forestofmirrors.x10.mx/credits">Art Credits</a> ★ <a href="http://forestofmirrors.x10.mx/tos">TOS</a> ★ <a href="http://forestofmirrors.x10.mx/privacy">Privacy Policy</a> ★ <a href="http://forestofmirrors.x10.mx/report/bug">Bug Reports</a> ★ <a href="https://www.patreon.com/bePatron?u=9437311">Support Us on Patreon!</a><br></right></p>
</div></center></div></div></center>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script>
$(function () {
      $(document).tooltip({
          content: function () {
              return $(this).prop('title');
          }
      });
  });
</script>
<style>
.ui-widget.ui-widget-content {
    margin-top: -350px !important;
}
</style>
  </body>
</html>

 
 