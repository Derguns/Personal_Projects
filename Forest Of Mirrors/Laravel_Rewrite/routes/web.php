<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::pattern('aid', '[0-9a-zA-Z]+');
Route::pattern('usecode', '[0-9a-zA-Z]+\.[a-zA-Z]+');
Route::pattern('item_id', '[0-9]+');
Route::pattern('location', '[0-9]+');


Route::get('/', 'PagesController@index')->name('index');
Route::get('/index', 'PagesController@index')->name('index');
Route::get('/login', 'PagesController@login')->name('login');
Route::post('/login', 'PagesController@dologin')->name('login');
Route::get('/resetpass', 'PagesController@resetpass')->name('resetpass');
Route::post('/resetpass', 'PagesController@doresetpass')->name('resetpass');
Route::get('/image/{aid}', 'PagesController@image')->name('image');
Route::get('/item/image/{item_id}', 'PagesController@itemimage')->name('itemimage');
Route::get('/companion/image/{item_id}', 'PagesController@companionimage')->name('companionimage');
Route::get('/image/{aid}.png', 'PagesController@image')->name('image');
Route::get('/drink/{usecode}', 'PagesController@drink')->name('drink');
Route::get('/account', 'AccountController@account')->name('account');
Route::get('/account/tabs', 'AccountController@tabs')->name('tabs');
Route::post('/account/tabs', 'AccountController@addtab')->name('addtab');
Route::get('/edittab/{item_id}', 'AccountController@edittab')->name('edittab');
Route::get('/deletetab/{item_id}', 'AccountController@deletetab')->name('deletetab');
Route::get('/deletealert/{usecode}', 'AccountController@deletealert')->name('deletealert');
Route::get('/account/hide', 'AccountController@hide')->name('hide');
Route::get('/account/alerts', 'AccountController@alerts')->name('alerts');
Route::get('/account/profile', 'AccountController@editprofile')->name('editprofile');
Route::post('/account/profile', 'AccountController@doeditprofile')->name('editprofile');
Route::get('/account/credentials', 'AccountController@credentials')->name('editinfo');
Route::post('/account/credentials', 'AccountController@docredentials')->name('editinfo');
Route::get('/account/username', 'AccountController@username')->name('username');
Route::post('/account/username', 'AccountController@dousername')->name('username');
Route::get('/account/friends', 'AccountController@friends')->name('friends');
Route::post('/account/friends', 'AccountController@managefriends')->name('friends');
Route::get('/deletefriend/{item_id}', 'AccountController@deletefriend')->name('deletefriend');
Route::get('/requestlist', 'AccountController@requestlist')->name('requestlist');
Route::get('/achievements', 'AchievementController@index')->name('achievements');
Route::post('/achievements', 'AchievementController@claim')->name('achievements');
Route::get('/alchemy', 'AlchemyController@index')->name('alchemy');
Route::post('/alchemy', 'AlchemyController@submit')->name('alchemy');
Route::get('/smelt_creature', 'AlchemyController@smelt_creature')->name('smelt_creature');
Route::get('/smelt_companion', 'AlchemyController@smelt_companion')->name('smelt_companion');
Route::get('/smelt_battle', 'AlchemyController@smelt_battle')->name('smelt_battle');
Route::get('/admin/adopt', 'AdminController@create_adopt')->name('adminAdopt');
Route::post('/admin/adopt', 'AdminController@make_adopt')->name('adminAdopt');
Route::get('/bank', 'BankController@index')->name('bank');
Route::get('/bank_deposit', 'BankController@deposit')->name('deposit');
Route::get('/bank_withdrawl', 'BankController@withdrawl')->name('withdrawl');
Route::get('/bank_transfer', 'BankController@transfer')->name('transfer');
Route::post('/bank', 'BankController@submit')->name('bank');
Route::get('/battle/{location}/{item_id}', 'BattleController@initiate_the_starting_battle_now')->name('battle');
Route::get('/battle/{location}', 'BattleController@index')->name('battle_location');
Route::get('/battle_hub', 'BattleController@hub')->name('battlehub');
Route::post('/battle_hub', 'BattleController@hubsub')->name('battlehub');
Route::get('/battle_heal', 'BattleController@heal')->name('battleheal');
Route::get('/battle_train', 'BattleController@train')->name('battletrain');
Route::get('/battle_ticket', 'BattleController@ticket')->name('battleticket');
Route::get('/battle_stones', 'BattleController@stones')->name('battlestones');
Route::get('/battle_buddy', 'BattleController@buddy')->name('battlebuddy');

