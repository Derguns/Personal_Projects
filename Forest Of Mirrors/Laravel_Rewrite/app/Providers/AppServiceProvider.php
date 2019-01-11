<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		$users = DB::table('adopts_online')->count();
		$user = '';
		session_start();
		// not logged in values
		if(empty($_SESSION['logged_in']) || empty($_SESSION['code']) || empty($_SESSION['username']) || empty($_SESSION['uid'])){
			$logged_in = 0;
			view()->share('usercode', 0);			
			view()->share('closeicon', 0);
			view()->share('faction', 'none');
		}
		//check session
		else{
			$user = DB::table('adopts_users')
			->where('email', $_SESSION['email'])
			->where('username', $_SESSION['username'])
			->where('salt', $_SESSION['code'])
			->where('usergroup', $_SESSION['usergroup'])
			->where('uid', $_SESSION['uid'])
			->first();
			//if this user doesnt exist in the DB, session invalid
			if(!$user){
				$_SESSION['logged_in'] = NULL;
			}
			//else provide the template logged in values
			else{
				$now = new \DateTime();
				$time = $now->getTimestamp();
				$interact_pets = DB::table('adopts_attached_companions')
					->join('adopts_owned_adoptables', 'adopts_owned_adoptables.aid', '=', 'adopts_attached_companions.aid')
					->where('time_active', '< ', $time)
					->where('adopts_owned_adoptables.owner', '=', $user->username)
					->count();
				$pickup_scours = DB::table('adopts_new_scours')
					->where('moves_left', '< ', 1)
					->where('uid', '= ', $user->uid)
					->count();
				$interact_scours = DB::table('adopts_new_scours')
					->where('interactive', '=', 1)
					->where('uid', '= ', $user->uid)
					->count();
				$scour_alert = $pickup_scours + $interact_scours;
				$user_profile = DB::table('adopts_users_profile')
					->where('username', $_SESSION['username'])
					->where('uid', $_SESSION['uid'])
					->first();
				$messages = DB::table('adopts_messages')
					->where("touser", $user->username)
					->where("status", 'unread')
					->count();
				view()->share('alchemyDone', 0);
				$ready_brew = DB::table('adopts_current_brews')
					->where('uid', $user->uid)
					->where('time_end', '<=', time())
					->first();
				if($ready_brew){
					view()->share('alchemyDone', $ready_brew->id);
				}
				view()->share('msgs', $messages);
				view()->share('user', $user);
				view()->share('closeicon', $user_profile->navbar);
				view()->share('avatar', $user_profile->avatar);
				view()->share('usercode', $user->salt);
				view()->share('favpet', $user_profile->favpet);
				view()->share('interactPets', $interact_pets);
				view()->share('interactScours', $scour_alert);
				view()->share('username', $user->username);
				view()->share('userClan', $user->clan);
				view()->share('bluestones', $user->money);
				view()->share('reactorstones', $user->reactorstones);
				view()->share('userLvl', $user->lvl);
				$logged_in = $_SESSION['logged_in'];
				view()->share('faction', $user->clan);
				$all_alerts = DB::table('adopts_alerts')
					->where('user', $_SESSION['uid'])
					->where('dismissed', 0)
					->orderBy('aid', 'desc')
					->limit(5)
					->get();
				$alert_count = DB::table('adopts_alerts')
					->where('user', $_SESSION['uid'])
					->where('dismissed', 0)
					->count();
				view()->share('alertping', $all_alerts);
				$alert_count = $alert_count - 5;
				if($alert_count < 0){
					$alert_count = 0;
				}
				view()->share('alert_count', $alert_count);
			}
		}
		$current = new \DateTime;						
		$days = (int)$current->format("d");
		$temp = (int)$current->format("G");

		if ($days >= 1 AND $days <= 7) {
			$seasons = "Spring";
		}
		elseif ($days >= 8 AND $days <= 14) {
			$seasons = "Summer";
		}
		elseif ($days > 14 AND $days <= 21) {
			$seasons = "Fall";
		}
		else {
			$seasons = "Winter";
		}
		
		if ($temp >= 2 AND $temp <= 10) {
			$weather = "Morning";
		}
		elseif ($temp >= 1 AND $temp < 2) {
			$weather = "Dawn";
		}
		elseif ($temp > 10 AND $temp <= 18) {
			$weather = "Afternoon";
		}
		elseif ($temp > 18 AND $temp <= 19) {
			$weather = "Dusk";
        } 
        elseif ($temp > 19 AND $temp <= 24) {
            $weather = "Night";
        } else {
            $weather = "Gilden";
               }
		view()->share('weather', $weather);
		view()->share('season', $seasons);
		view()->share('online', $users);
		view()->share('logged_in', $logged_in);

		view()->share('reportsLeft', 0);
		view()->share('page', 'basic');
		view()->share('page1', 'basic');
		view()->share('form_alert', 1);
		
		$topClan = DB::table('adopts_clans')
			->where("win", '=', 'yes')
			->first();
		
		$clanurl = "images/icons/{$topClan->clan}con.png";
		view()->share('clan', $topClan->clan);
		view()->share('clanurl', $clanurl);
	
		if(Auth::check()){
			view()->share('user_group', $user->name);
		}
		else{
			view()->share('user_group', 'visitor');
		}

	}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
