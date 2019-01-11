<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;


class AccountController extends Controller
{
	public function account(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		view()->share('hideshow', "Show Adults");
		$user = user();
		
		if($user->hidden == "no"){
			view()->share('hideshow', "Hide Adults");
		}
    	return view('account');
	}
	public function tabs(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$all_tabs = DB::table('adopts_user_tabs')
			->where('uid', $_SESSION['uid'])
			->orderBy('tab_order', 'asc')
			->get();
		view()->share('tablist', $all_tabs);
    	return view('tabs');
	}
	public function addtab(Request $request){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		if($request->get('tabname')){
			$success_message = "You have successfully created the tab {$request->get('tabname')}!";
			view()->share('form_alert', $success_message);	
			DB::table('adopts_user_tabs')->insert(
				['uid' => $_SESSION['uid'], 'tab_name' => $request->get('tabname')]
			);
		}
		if($request->get('retabname')){
			$tab = DB::table('adopts_user_tabs')
				->where('uid', $_SESSION['uid'])
				->where('id', $request->get('tabid'))
				->first();
			if($tab){
				DB::table('adopts_user_tabs')
					->where('uid', $_SESSION['uid'])
					->where('id', $request->get('tabid'))
					->update(['tab_name' => $request->get('retabname')]);
				$success_message = "You have successfully renamed the tab to {$request->get('retabname')}!";
				view()->share('form_alert', $success_message);	
			}
		}
		if($request->get('deletetabid')){
			$tab = DB::table('adopts_user_tabs')
				->where('uid', $_SESSION['uid'])
				->where('id', $request->get('deletetabid'))
				->first();
			$move_tab = DB::table('adopts_user_tabs')
				->where('uid', $_SESSION['uid'])
				->where('id', $request->get('movetab'))
				->first();
			if($tab && $move_tab){
				DB::table('adopts_user_tabs')
					->where('uid', $_SESSION['uid'])
					->where('id', $request->get('deletetabid'))
					->delete();
				DB::table('adopts_owned_adoptables')
					->where('owner', $_SESSION['username'])
					->where('party', $request->get('deletetabid'))
					->update(['party' => $request->get('movetab')]);
				$success_message = "You have successfully deleted the tab {$tab->tab_name}, and moved your creatures into {$move_tab->tab_name}!";
				view()->share('form_alert', $success_message);	
			}
		}
		$all_tabs = DB::table('adopts_user_tabs')
			->where('uid', $_SESSION['uid'])
			->orderBy('tab_order', 'asc')
			->get();
		view()->share('tablist', $all_tabs);
		return view('tabs');
	}
	public function edittab(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here  
        $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
		$tab = DB::table('adopts_user_tabs')
			->where('uid', $_SESSION['uid'])
			->where('id', $id)
			->first();
		view()->share('tab_name', $tab->tab_name);
		view()->share('tab_id', $tab->id);
		return view('edittab');
	}
	public function deletetab(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here  
        $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
		$tab = DB::table('adopts_user_tabs')
			->where('uid', $_SESSION['uid'])
			->where('id', $id)
			->first();
		view()->share('tab_name', $tab->tab_name);
		view()->share('tab_id', $tab->id);
		$all_tabs = DB::table('adopts_user_tabs')
			->where('uid', $_SESSION['uid'])
			->where('id', '!=', $tab->id)
			->orderBy('tab_order', 'asc')
			->get();
		view()->share('tablist', $all_tabs);
		return view('deletetab');
	}
	public function hide(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		if($user->hidden == "no"){
			DB::table('adopts_users')
				->where('uid', $user->uid)
				->update(['hidden' => 'yes']);
			view()->share('hideshow', 'Show Adults');
			$success_message = "You unravel the scroll given to you when you joined the Castle, and cast the spell of obfuscaton upon your adult creatures. They now appear hidden to all prying eyes but yours.";
			view()->share('form_alert', $success_message);	
		}
		else{
			DB::table('adopts_users')
				->where('uid', $user->uid)
				->update(['hidden' => 'no']);
			view()->share('hideshow', 'Hide Adults');
			$success_message = "You unravel the scroll once more, and turn it over to its return side. Etched upon its back are wondrous runes, which tell you how to remove the spell from your adult creatures. You cast it, and are certain they appear to everyone- although you can't quite notice a difference.";
			view()->share('form_alert', $success_message);	
		}
		return view('account');
	}
	public function alerts(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$all_alerts = DB::table('adopts_alerts')
			->where('user', $_SESSION['uid'])
			->orderBy('aid', 'desc')
			->limit(100)
			->get();
		view()->share('alertlist', $all_alerts);
		return view('alerts');
	}
	public function editprofile(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user_profile = DB::table('adopts_users_profile')
			->where('username', $_SESSION['username'])
			->where('uid', $_SESSION['uid'])
			->first();
		view()->share('profile', $user_profile);
		$user_options = DB::table('adopts_users_options')
			->where('username', $_SESSION['username'])
			->where('uid', $_SESSION['uid'])
			->first();
		view()->share('user_options', $user_options);
		$user_css = DB::table('adopts_users_profile_css')
			->where('uid', $_SESSION['uid'])
			->first();
		$genderlist = array('Unspecified', 'Agender', 'Androgyne', 'Demigirl', 'Demiboy', 'Female', 'Genderfluid', 'Genderflux', 'Male', 'Non-Binary');
		view()->share('genderlist', $genderlist);
		view()->share('css', $user_css);
		return view('editprofile');
	}
	public function doeditprofile(Request $request){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$genderlist = array('Unspecified', 'Agender', 'Androgyne', 'Demigirl', 'Demiboy', 'Female', 'Genderfluid', 'Genderflux', 'Male', 'Non-Binary');
		DB::table('adopts_users_profile')
			->where('uid', $_SESSION['uid'])
			->update(['avatar' => $request->get('avatar'), 'bio' => $request->get('bio'), 'gender' => $genderlist[$request->get('gender')]]);
		view()->share('avatar', $request->get('avatar'));
		if($request->get('css')){
			DB::table('adopts_users_profile_css')
				->where('uid', $_SESSION['uid'])
				->update(['css' => $request->get('css')]);
		}
		if($request->get('enable')){
			DB::table('adopts_users_options')
				->where('uid', $_SESSION['uid'])
				->update(['profile_css' => 1]);			
		}
		if($request->get('disable')){
			DB::table('adopts_users_options')
				->where('uid', $_SESSION['uid'])
				->update(['profile_css' => 0]);						
		}			
		$user_profile = DB::table('adopts_users_profile')
			->where('username', $_SESSION['username'])
			->where('uid', $_SESSION['uid'])
			->first();
		view()->share('profile', $user_profile);
		$user_options = DB::table('adopts_users_options')
			->where('username', $_SESSION['username'])
			->where('uid', $_SESSION['uid'])
			->first();
		view()->share('user_options', $user_options);
		$user_css = DB::table('adopts_users_profile_css')
			->where('uid', $_SESSION['uid'])
			->first();
		$genderlist = array('Unspecified', 'Agender', 'Androgyne', 'Demigirl', 'Demiboy', 'Female', 'Genderfluid', 'Genderflux', 'Male', 'Non-Binary');
		view()->share('genderlist', $genderlist);
		view()->share('css', $user_css);
		$success_message = "You have successfully edited your profile!";
		view()->share('form_alert', $success_message);	
		return view('editprofile');
	}
	public function credentials(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		return view('editinfo');
	}
	public function docredentials(Request $request){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = DB::table('adopts_users')
			->where('uid', $_SESSION['uid'])
			->where('email', $request->get('pastemail'))
			->first();
		$user_email = DB::table('adopts_users')
			->where('email', $request->get('email'))
			->where('uid', '!=', $_SESSION['uid'])
			->first();	
		$validated = $this->validate($request,
			['email' => 'required|email',
			'password' => 'required|alphaNum|min:3']
		);
		if(!$validated){
			$success_message = "The provided password to change to is invalid, make sure it is alphanumeric and greater than three characters.";
			view()->share('form_alert', $success_message);	
			return view('editinfo');
		}
		if($user_email){
			$success_message = "The provided email to change to is invalid, as there is another user that has this email on record.";
			view()->share('form_alert', $success_message);	
			return view('editinfo');
		}		
		$password = $request->get('pastpassword');
		if(!$user){
			$success_message = "The provided current user information did not match the data currently on record. If you need to retrieve your information, please contact admin@forestofmirrors.x10.mx.";
			view()->share('form_alert', $success_message);	
			return view('editinfo');
		}
		$password .= $user->username;
		$password_compare = password_verify($password, $user->password);
		if(!$password_compare){
			$success_message = "The provided current user information did not match the data currently on record. If you need to retrieve your information, please contact admin@forestofmirrors.x10.mx.";
			view()->share('form_alert', $success_message);	
			return view('editinfo');
		}
		if($request->get('confirmpassword') != $request->get('password')){
			$success_message = "The two passwords entered did not match. Please ensure that you spell it the same both times.";
			view()->share('form_alert', $success_message);	
			return view('editinfo');
		}
		$password = $request->get('password');
		$user = DB::table('adopts_users')
			->where('email', $request->get('pastemail'))
			->first();
		$password .= $user->username;
		$password = password_hash($password, PASSWORD_DEFAULT);
		DB::table('adopts_users')
			->where('uid', $_SESSION['uid'])
			->where('salt', $_SESSION['code'])
			->where('username', $_SESSION['username'])
			->update(['password' => $password, 'email' => $request->get('email')]);				
		$success_message = "Your account information has been successfully changed. Please use this new information to log in again.";
		view()->share('form_alert', $success_message);	
		return view('login');
	}
	public function username(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		return view('username');
	}
	public function dousername(Request $request){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();

		$validated = $this->validate($request,
			['username' => 'required|min:3|max:20']
		);
		if(!$validated){
			$success_message = "The username {$request->get('username')} is either too short or too long.";
			view()->share('form_alert', $success_message);	
			return view('username');
		}
		if($user){
			$success_message = "The username {$request->get('username')} has already been taken by another user.";
			view()->share('form_alert', $success_message);	
			return view('username');
		}
		if($request->get('currentuser') != $_SESSION['username']){
			$success_message = "The confirmation username is not equal to your current username.";
			view()->share('form_alert', $success_message);	
			return view('username');
		}
		$new_money = change_money(1, 1, 500);
		if($new_money){
			$success_message = "You have successfully changed your username to {$request->get('username')}, and now have <img src='http://localhost/laravel/laraveltest/images/icons/orb5.png'></img> {$new_money} Reactor Stones left.";
			view()->share('form_alert', $success_message);
			//Tables that need to update when username is updated:
				//Adopts_users
				
			DB::table('adopts_users')
				->where('uid', $_SESSION['uid'])
				->where('salt', $_SESSION['code'])
				->where('username', $_SESSION['username'])
				->update(['username' => $request->get('username')]);	
			DB::table('adopts_users_contacts')
				->where('username', $_SESSION['username'])
				->update(['username' => $request->get('username')]);	
			DB::table('adopts_users_options')
				->where('username', $_SESSION['username'])
				->update(['username' => $request->get('username')]);	
			DB::table('adopts_users_profile')
				->where('username', $_SESSION['username'])
				->update(['username' => $request->get('username')]);	
			DB::table('adopts_users_status')
				->where('username', $_SESSION['username'])
				->update(['username' => $request->get('username')]);	
			DB::table('adopts_vote_voters')
				->where('username', $_SESSION['username'])
				->update(['username' => $request->get('username')]);	
			DB::table('adopts_trinkets')
				->where('owner', $_SESSION['username'])
				->update(['owner' => $request->get('username')]);	
			DB::table('adopts_tickets')
				->where('owner', $_SESSION['username'])
				->update(['owner' => $request->get('username')]);	
			DB::table('adopts_stock')
				->where('owner', $_SESSION['username'])
				->update(['owner' => $request->get('username')]);	
			DB::table('adopts_slogs')
				->where('user', $_SESSION['username'])
				->update(['user' => $request->get('username')]);	
			DB::table('adopts_achievements')
				->where('owner', $_SESSION['username'])
				->update(['owner' => $request->get('username')]);	
			DB::table('adopts_bank')
				->where('user', $_SESSION['username'])
				->update(['user' => $request->get('username')]);	
			DB::table('adopts_quests')
				->where('user', $_SESSION['username'])
				->update(['user' => $request->get('username')]);	
			DB::table('adopts_enemies')
				->where('owner', $_SESSION['username'])
				->update(['owner' => $request->get('username')]);	
			DB::table('adopts_messages')
				->where('touser', $_SESSION['username'])
				->update(['touser' => $request->get('username')]);	
			DB::table('adopts_messages')
				->where('fromuser', $_SESSION['username'])
				->update(['fromuser' => $request->get('username')]);	
			DB::table('adopts_inventory')
				->where('owner', $_SESSION['username'])
				->update(['owner' => $request->get('username')]);
			DB::table('adopts_owned_adoptables')
				->where('owner', $_SESSION['username'])
				->update(['owner' => $request->get('username')]);
			DB::table('adopts_raffle')
				->where('owner', $_SESSION['username'])
				->update(['owner' => $request->get('username')]);
			return view('login');
		}
		else{
			$success_message = "You do not have <img src='http://localhost/laravel/laraveltest/images/icons/orb5.png'></img> 500 Reactor Stones to complete this action.";
			view()->share('form_alert', $success_message);	
			return view('username');
		}
	}
	public function friends(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();

		$arr = Explode(",", $user->friends);
		$all_friends = DB::select("SELECT * FROM `adopts_users` where uid IN (".implode(',',$arr).")");
		$all_profiles = DB::select("SELECT * FROM `adopts_users_profile` where uid IN (".implode(',',$arr).")");
		view()->share('friendlist', $all_friends);
		view()->share('profilelist', $all_profiles);
		return view('accountfriends');
	}
	public function managefriends(Request $request){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		if(!$request->get('action')){
			$friend = DB::table('adopts_users')
				->where('uid', $request->get('deletefriendid'))
				->first();
			$success_message = "You have successfully removed {$friend->username} from your friends list.";
			view()->share('form_alert', $success_message);	
			$user = user();

			$arr = Explode(",", $user->friends);
			$arr = array_diff($arr, [$friend->uid]);
			$all_friends = DB::select("SELECT * FROM `adopts_users` where uid IN (".implode(',',$arr).")");
			$all_profiles = DB::select("SELECT * FROM `adopts_users_profile` where uid IN (".implode(',',$arr).")");
			$new_array = implode(',',$arr);
			DB::table('adopts_users')
				->where('uid', $_SESSION['uid'])
				->where('salt', $_SESSION['code'])
				->where('username', $_SESSION['username'])
				->update(['friends' => $new_array]);			
			view()->share('friendlist', $all_friends);
			view()->share('profilelist', $all_profiles);
			return view('accountfriends');
		}
		if($request->get('action') == 'deny'){
			DB::table('adopts_friend_requests')
				->where('touser', $_SESSION['username'])
				->where('fid', $request->get('requestid'))
				->update(['status' => 'declined']);
			$success_message = "You have successfully declined this friend request.";
			view()->share('form_alert', $success_message);	
			$user = user();

			$arr = Explode(",", $user->friends);
			$all_friends = DB::select("SELECT * FROM `adopts_users` where uid IN (".implode(',',$arr).")");
			$all_profiles = DB::select("SELECT * FROM `adopts_users_profile` where uid IN (".implode(',',$arr).")");
			view()->share('friendlist', $all_friends);
			view()->share('profilelist', $all_profiles);
			return view('accountfriends');			
		}
		if($request->get('action') == 'accept'){
			DB::table('adopts_friend_requests')
				->where('touser', $_SESSION['username'])
				->where('fid', $request->get('requestid'))
				->update(['status' => 'accepted']);
			$friend_request = DB::table('adopts_friend_requests')
				->where('fid', $request->get('requestid'))
				->first();
			$success_message = "You have successfully accepted this friend request.";
			view()->share('form_alert', $success_message);	
			$user = user();

			$arr = Explode(",", $user->friends);
			$friend = DB::table('adopts_users')
				->where('username', $friend_request->fromuser)
				->first();
			$arr[] = $friend->uid;
			$all_friends = DB::select("SELECT * FROM `adopts_users` where uid IN (".implode(',',$arr).")");
			$all_profiles = DB::select("SELECT * FROM `adopts_users_profile` where uid IN (".implode(',',$arr).")");
			$new_array = implode(',',$arr);
			DB::table('adopts_users')
				->where('uid', $_SESSION['uid'])
				->where('salt', $_SESSION['code'])
				->where('username', $_SESSION['username'])
				->update(['friends' => $new_array]);			
			view()->share('friendlist', $all_friends);
			view()->share('profilelist', $all_profiles);
			return view('accountfriends');			
		}
	}
	public function deletefriend(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        } //this here  
        $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
		$user = DB::table('adopts_users')
			->where('uid', $id)
			->first();	
		view()->share('friend', $user);
		return view('deletefriend');

	}
	public function requestlist(){
		$requests = DB::select("SELECT * FROM `adopts_friend_requests` where status = 'pending' and touser = ?", [$_SESSION['username']]);
		view()->share('requests', $requests);
		return view('requestlist');
	}
}
?>