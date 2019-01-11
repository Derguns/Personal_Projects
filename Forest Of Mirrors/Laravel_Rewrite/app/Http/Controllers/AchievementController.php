<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Redirect;

class AchievementController extends Controller
{
	public function index(){
		$logged = verify_logged_in();
		if(!$logged){
			return view('login');
		}
		$usercount = DB::table('adopts_users')
			->count();
		$uid = request()->query('uid');
		$user = DB::table('adopts_users')
			->where('uid', $uid)
			->first();
		if(!$uid || !$user){
			$uid = $_SESSION['uid'];
		}
		if(session('form_alert')){
			view()->share('form_alert', session('form_alert'));	
		}
			
		if($uid == $_SESSION['uid']){
			$achievement_name_list = check_achievement(1);
			$achievement_name_list .= check_achievement(3);
			$achievement_name_list .= check_achievement(4);
			$achievement_name_list .= check_achievement(5);
			if($achievement_name_list != NULL){
				$success_message = "You have earned the achievement(s) $achievement_name_list and they have been credited to your records book! Don't forget to claim them.";
				view()->share('form_alert', $success_message);	
			}
			$achievement_list = DB::select("SELECT * FROM `adopts_achievement` where id > 0");
			$unlocked_list = DB::select("SELECT what FROM `adopts_achievements` where owner = ?", [$uid]);
			$unlocked_ids = [];
			foreach($unlocked_list as $unlocked){
				$unlocked_ids[] = $unlocked->what;
			}
			view()->share('achievements', $achievement_list);
			view()->share('uid', $uid);
			view()->share('text', "You approach the Castle's registrar administrator and state your name and enrollment year. He quickly shuffles through the alphabetized, $usercount tall pile of books he has behind him, and hands you your tome with all of your achieved 'Out-of-the-Potions-Room' goals. You open the small leather-bound book and view the milestones that you have achieved. Each one that you have gained is marked below. Many achievements come with rewards, clicking claim will delilver these riches to you!");
			view()->share('unlocked_achievements', $unlocked_ids);
			return view('achievement');
		}
		else{
			$achievement_list = DB::select("SELECT * FROM `adopts_achievements` JOIN `adopts_achievement` where adopts_achievements.what = adopts_achievement.id and adopts_achievements.owner = ?", [$uid]);
			$unlocked_list = DB::select("SELECT what FROM `adopts_achievements` where owner = ?", [$uid]);
			$unlocked_ids = [];
			foreach($unlocked_list as $unlocked){
				$unlocked_ids[] = $unlocked->what;
			}
			view()->share('achievements', $achievement_list);
			view()->share('uid', $uid);
			view()->share('text', "Although he's not usually fond of passing these out to other mages, the registrar admits defeat at your begging and hands you $user->username's records book to glance over. You notice that some details have been removed, but for the most part it reads the same. Does this mean there are two books kept on hand for every user? That seems like it would be very inefficient...");
			view()->share('unlocked_achievements', $unlocked_ids);
			return view('achievement');
		}
	}
	public function claim(Request $request){
		
		$achieved = DB::table('adopts_achievements')
			->where('id', $request->get('achievementid'))
			->where('owner', $_SESSION['uid'])
			->where('claimed', 'no')
			->first();
			
		if($achieved){
			
			$achievement = DB::table('adopts_achievement')
				->where('id', $achieved->what)
				->first();
			$reward_message = '';
			
			if($achievement->money == 'yes'){
				change_money(0,0, $achievement->moneyamount);
				$reward_message = "You earned <img src='http://localhost/laravel/laraveltest/images/icons/orb4.png'></img> {$achievement->moneyamount} Blue Stones for completing this achievement.";
			}
			
			if($achievement->egg == 'yes'){
				if($achievement->id == 31 || $achievement->id == 50 || $achievement->id == 44 || $achievement->id == 42 || $achievement->id == 37){
					$adopt = gen_new_egg($achievement->egg_id, 1, 1, 1, 1, 'Achievement');					
				}
				else{
					$adopt = gen_new_egg($achievement->egg_id, 0, 1, 1, 1, 'Achievement');
				}
				if($adopt){
					$reward_message = "{$adopt[2]}<br>You earned a {$adopt[0]} egg for completing this achievement!";
				}
				else{
					$success_message = "There was an error making the egg for this achievement. Make sure you have enough egg slots open!";
					return Redirect::to('achievements')->with('form_alert', $success_message);
				}
			}
			
			$success_message = "You have claimed the achievement {$achievement->name}!<br> {$reward_message}";
			DB::table('adopts_achievements')
			->where('id', $request->get('achievementid'))
			->where('owner', $_SESSION['uid'])
			->update(['claimed' => 'yes']);
			
			return Redirect::to('achievements')->with('form_alert', $success_message);
		}
		else{
			
			$success_message = "There was an error claiming this achievement.";
			return Redirect::to('achievements')->with('form_alert', $success_message);
			
		}

	}
}
?>