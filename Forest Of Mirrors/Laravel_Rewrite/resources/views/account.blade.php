@extends('master')
@section('title', 'Managing My Account')

@section('content')
<body style="">
<article>
<div id="speciesInformation">Here is a list of options that you can use to manage and view your account information.</div>
	<div id="newsView">Manage Holding Area</div>
	<div id="questWords">
		<a href="/myadopts">
			<button class="btn btn-default">My Holding Area</button>
		</a>
		<a href="{{ route('tabs') }}">
			<button class="btn btn-default">Manage Sorting</button>
		</a>
		<a href="{{ route('hide') }}">
			<button class="btn btn-default">{{$hideshow}}</button>
		</a>
	</div>
	<div id="newsView">View My Account</div>
	<div id="questWords">
		<a href="/profile/view/Q">
			<button class="btn btn-default">View Profile</button>
		</a>
		<a href="{{ route('alerts') }}">
			<button class="btn btn-default">View Alerts</button>
		</a>
		<a href="{{ route('achievements') }}">
			<button class="btn btn-default">View Achievements</button>
		</a>
	</div>
	<div id="newsView">Manage Account Information</div>
	<div id="questWords">
		<a href="{{ route('editprofile') }}">
			<button class="btn btn-default">Profile Information</button>
		</a>
		<a href="{{ route('editinfo') }}">
			<button class="btn btn-default">Email & Password</button>
		</a>
		<a href="{{ route('username') }}">
			<button class="btn btn-default">Change Username</button>
		</a>
	</div>
	<div id="newsView">Clan Information</div>
	<div id="questWords">
		<a href="/element">
			<button class="btn btn-default">Diety Tasks</button>
		</a>
		<a href="/element/change">
			<button class="btn btn-default">Change My Clan</button>
		</a>
		<a href="/leader">
			<button class="btn btn-default">Clan Leadership</button>
		</a>
	</div>
	<div id="newsView">Forum Information</div>
	<div id="questWords">
		<a href="/Forum/edit_signature">
			<button class="btn btn-default">Edit Appearance</button>
		</a>
		<a href="/Forum/subscribed_threads">
			<button class="btn btn-default">My Subscriptions</button>
		</a>
		<a href="/Forum/thread/200000">
			<button class="btn btn-default">My Posts</button>
		</a>
	</div>
	<div id="newsView">User Interactions</div>
	<div id="questWords">
		<a href="{{ route('friends') }}">
			<button class="btn btn-default">My Friendslist</button>
		</a>
		<a href="/block">
			<button class="btn btn-default">My Blocklist</button>
		</a>
	</div><br>
</article>
 @endsection
