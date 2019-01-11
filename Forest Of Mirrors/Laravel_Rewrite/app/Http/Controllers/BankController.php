<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Redirect;

class BankController extends Controller
{
	public function index(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		$bank_account = DB::table('adopts_bank')
			->where('user', $user->uid)
			->first();
		if($bank_account){
		    view()->share('bank_blue', $bank_account->blue);
		    view()->share('bank_reactor', $bank_account->reactor);
		}
		else{
		    view()->share('bank_blue', 0);
		    view()->share('bank_reactor', 0);
		}
		if(session('form_alert')){
			view()->share('form_alert', session('form_alert'));	
		}		
		view()->share('alert', "");
		return view('bank');
	}
	public function deposit(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		$bank_account = DB::table('adopts_bank')
			->where('user', $user->uid)
			->first();
		if($bank_account){
		    view()->share('bank_blue', $bank_account->blue);
		    view()->share('bank_reactor', $bank_account->reactor);
		}
		else{
		    view()->share('bank_blue', 0);
		    view()->share('bank_reactor', 0);
		}
		return view('bankdeposit');
	}
	public function submit(Request $request){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		$bank_account = DB::table('adopts_bank')
			->where('user', $user->uid)
			->first();
		$blue = 0;
		$reactor = 0;
		if($bank_account){
			$blue = $bank_account->blue;
			$reactor = $bank_account->reactor;
		}
		$success_message = "There was an error with managing your bank account.";	
		$success_blue = "";
		$success_reactor = "";
		if(!$request->get('username')){
			$success_message = "We have successfully processed your bank transaction! Please note the details below.";
			//The user has added blue stones into their bank account.
			if($request->get('bluestones') > $blue){
				$bank_difference = $request->get('bluestones') - $blue;
				
				$blue_bank_account = DB::table('adopts_bank')
					->where('user', $user->uid)
					->first();
				// User has a bank account and can change money to that.
				if(change_money(0, 1, $bank_difference) && $blue_bank_account){
					DB::table('adopts_bank')
						->where('user', $user->uid)
						->update(['blue' => $request->get('bluestones')]);
					$success_blue = "You have successfully deposited <img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'></img> {$bank_difference} blue stones into your account.";
				}
				else if(change_money(0, 1, $bank_difference) && !$blue_bank_account){
					DB::table('adopts_bank')->insert(['user' => $user->uid, 'blue' => $request->get('bluestones'), 'reactor' => 0]);
					$success_blue = "You have successfully deposited <img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'></img> {$bank_difference} blue stones into your account.";
				}
				else{
				    $success_blue = "You were unable to make your bluestone deposit.";
				}
			}
			//The user has withdrawn blue stones from their bank account.
			if($request->get('bluestones') < $blue && $request->get('bluestones') >= 0){
				$bank_difference = $blue - $request->get('bluestones');
				$blue_bank_account = DB::table('adopts_bank')
					->where('user', $user->uid)
					->first();
				// User has a bank account and can change money to that.
				if(change_money(0, 0, $bank_difference) && $blue_bank_account){
					DB::table('adopts_bank')
						->where('user', $user->uid)
						->update(['blue' => $request->get('bluestones')]);
					$success_blue = "You have successfully withdrawn <img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'></img> {$bank_difference} blue stones into your satchel.";
				}
				// Else no accoun then cannot withdraw
				else{
				    $success_blue = "You were unable to make your blue stone withdraw.";
				}
			}
			//The user has added reactor stones into their bank account.
			if($request->get('reactorstones') > $reactor){
				$bank_difference = $request->get('reactorstones') - $reactor;
				$reactor_bank_account = DB::table('adopts_bank')
					->where('user', $user->uid)
					->first();
				// User has a bank account and can change money to that.
				if(change_money(1, 1, $bank_difference) && $reactor_bank_account){
					DB::table('adopts_bank')
						->where('user', $user->uid)
						->update(['reactor' => $request->get('reactorstones')]);
					$success_reactor = "You have successfully deposited <img src='http://localhost/laravel/laraveltest/images/icons/orb5.png'></img> {$bank_difference} reactor stones into your account.";
				}
				else if(change_money(1, 1, $bank_difference) && !$reactor_bank_account){
					DB::table('adopts_bank')->insert(['user' => $user->uid, 'blue' => 0, 'reactor' => $request->get('reactorstones')]);
					$success_reactor = "You have successfully deposited <img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'></img> {$bank_difference} reactor stones into your account.";
				}
				else{
				    $success_reactor = "You were unable to make your reactor stone deposit.";
				}
			}
			//The user has withdrawn reactor stones from their bank account.
			if($request->get('reactorstones') < $reactor && $request->get('reactorstones') >= 0){
				$bank_difference = $reactor - $request->get('reactorstones');
				$reactor_bank_account = DB::table('adopts_bank')
					->where('user', $user->uid)
					->first();
				// User has a bank account and can change money to that.
				if(change_money(1, 0, $bank_difference) && $reactor_bank_account){
					DB::table('adopts_bank')
						->where('user', $user->uid)
						->update(['reactor' => $request->get('reactorstones')]);
					$success_reactor = "You have successfully withdrawn <img src='http://localhost/laravel/laraveltest/images/icons/orb5.png'></img> {$bank_difference} reactor stones into your satchel.";
				}
				// Else no accoun then cannot withdraw
				else{
				    $success_reactor = "You were unable to make your reactor stone withdraw.";
				}
			}
		}
		else{
			$send_user = user($request->get('username'));
			if($send_user && ($send_user->uid != $user->uid) && check_block($send_user->uid)){
				//User sending more than 
				$success_message = "You have successfully sent a transfer to the user {$send_user->username} (#{$send_user->uid})! Please notice the transaction reciept below.";
				if($request->get('bluestones') > 0 || $request->get('reactorstones') > 0){
					//Check the user has enough money to send to the user.
					if(change_money(0,1, $request->get('bluestones')) && change_money(0,1, $request->get('reactorstones'))){
						//Change the recieving user's blue stones. 
						change_money(0,0, $request->get('bluestones'), $send_user->uid);
						//Change the recieving user's reactor stones. 
						change_money(1,0, $request->get('reactorstones'), $send_user->uid);
						
						$alert_message = "{$user->username} (#{$user->uid}) has sent you a currency transfer of <img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'></img> {$request->get('bluestones')} and <img src='http://localhost/laravel/laraveltest/images/icons/orb5.png'></img> {$request->get('reactorstones')}.";
						//Send the user an alert.
						generate_alert($send_user->uid,  $alert_message);
						
						//Generate a bank transaction for both users. 
						generate_transaction($user->uid, "Transfer to {$send_user->username} (#{$send_user->uid}).", (-1 * $request->get('bluestones')), (-1 * $request->get('reactorstones')));
						generate_transaction($send_user->uid, "Transfer from {$user->username} (#{$user->uid}).", ($request->get('bluestones')), ($request->get('reactorstones')));
						$success_reactor = "You have successfully sent <img src='http://localhost/laravel/laraveltest/images/icons/orb5.png'></img> {$request->get('reactorstones')} reactor stones.";
						$success_blue = "You have successfully sent <img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'></img> {$request->get('bluestones')} blue stones.";
					}
					else{
						$success_message = "You were unable to send a transfer to this user. Confirm that you have enough money to send this transfer!";
						return Redirect::to('bank')->with('form_alert', $success_message);
					}
				}
				else{
					$success_message = "You were unable to send a transfer to this user. It looks like the transfer is empty!";
					return Redirect::to('bank')->with('form_alert', $success_message);
				}
			}
			else{
				$success_message = "You were unable to send a transfer to this user. Confirm that you have entered the username or user id correctly!";
				return Redirect::to('bank')->with('form_alert', $success_message);
			}
		}
		$success_message = "{$success_message}<br>{$success_blue}<br>{$success_reactor}";
		return Redirect::to('bank')->with('form_alert', $success_message);
	}
	public function transfer(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$user = user();
		return view('banktransfer');
	}
}
?>