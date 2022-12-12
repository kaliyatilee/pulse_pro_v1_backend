<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\SUViewsController;
use App\Http\Controllers\PartnerController;

use App\Http\Controllers\MembersController;
use App\Http\Controllers\PartnerMasterGoalsController;
use App\Http\Controllers\PartnerWellnessPlanController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AssignGoalController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\NewsFeedsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CorporateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    return view('index');
});


Route::get('register', function () {
    return view('auth.register');
})->name('register');
Route::get('login', function () {
    return view('auth.login');
})->name('login');



Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('logout', [LogoutController::class, 'logout'])->name('logout');

//Auth::routes();


Route::group(['prefix' => 'client', 'middleware' => ['role:user']], function () {
    Route::get('home', 'App\Http\Controllers\ClientController@home')->name('client');
});


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

Route::get('schools', 'App\Http\Controllers\WebsiteController@schools')->name('schools');
Route::get('insurance','App\Http\Controllers\WebsiteController@insurance')->name('insurance');
Route::get('corporates', 'App\Http\Controllers\WebsiteController@corporates')->name('corporates');
Route::get('webcommunity', 'App\Http\Controllers\WebsiteController@webcommunity')->name('webcommunity');
Route::get('stories','App\Http\Controllers\WebsiteController@stories')->name('stories');
Route::get('ecg', 'App\Http\Controllers\WebsiteController@ecg')->name('ecg');
Route::get('heartrate', 'App\Http\Controllers\WebsiteController@heartrate')->name('heartrate');
Route::get('setup', 'App\Http\Controllers\WebsiteController@setup')->name('setup');
Route::get('challenges', 'App\Http\Controllers\WebsiteController@challenges')->name('challenges');
Route::get('services', 'App\Http\Controllers\WebsiteController@services')->name('services');
Route::get('sleepmonitor', 'App\Http\Controllers\WebsiteController@sleepmonitor')->name('sleepmonitor');
Route::get('wearables', 'App\Http\Controllers\WebsiteController@wearables')->name('wearables');
Route::get('trackers', 'App\Http\Controllers\WebsiteController@trackers')->name('trackers');
Route::get('scales', 'App\Http\Controllers\WebsiteController@scales')->name('scales');
Route::get('websubs', 'App\Http\Controllers\WebsiteController@websubs')->name('websubs');
Route::get('pulsesilver', 'App\Http\Controllers\WebsiteController@pulsesilver')->name('pulsesilver');
Route::get('pulsegold', 'App\Http\Controllers\WebsiteController@pulsegold')->name('pulsegold');
Route::get('pulseplatnum', 'App\Http\Controllers\WebsiteController@pulseplatnum')->name('pulseplatnum');



/*
|--------------------------------------------------------------------------
| End of Web Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Super User Routes
|--------------------------------------------------------------------------
*/
// Route::group(['prefix' => 'super', 'middleware' => ['role:super']], function () {
    Route::get('dashboard', [SUViewsController::class, 'index'])->name('superAdminDashboard');
    Route::get('newuser', [SUViewsController::class, 'newuser'])->name('newuser');
     /*
       Started Code By : Hima Shah
       Date : 1st November 2022
    */
    Route::get('edituser/{id}', [SUViewsController::class, 'edituser'])->name('edituser');
    Route::post('saveusers', [SUViewsController::class, 'saveusers'])->name('saveusers');
    Route::get('viewusers/{id}', [SUViewsController::class, 'viewusers'])->name('viewusers');
    Route::get('userslist', [SUViewsController::class, 'userslist'])->name('userslist');
    Route::get('userslistexport', [SUViewsController::class, 'userslistexport'])->name('userslistexport');
    Route::post('saveusersFromImport', [SUViewsController::class, 'saveusersFromImport'])->name('saveusersFromImport');
    Route::get('productlistfilter', [MerchantController::class, 'productlistfilter'])->name('productlistfilter');
    

    

    /* End Code By : Hima Shah */
    Route::get('expenditure', [SUViewsController::class, 'expenditure'])->name('expenditure');
    Route::get('expenditurereport', [SUViewsController::class, 'expenditurereport'])->name('expenditurereport');
    Route::get('income', [SUViewsController::class, 'income'])->name('income');
    Route::get('incomereport', [SUViewsController::class, 'income'])->name('incomereport');
    Route::get('additem', [SUViewsController::class, 'additem'])->name('additem');
    Route::get('showitems', [SUViewsController::class, 'showitems'])->name('showitems');
    Route::get('userroles', [SUViewsController::class, 'userroles'])->name('userroles');
    Route::get('partnerslist', [SUViewsController::class, 'partnerslist'])->name('partnerslist');
    Route::get('serviceproviders', [SUViewsController::class, 'serviceproviders'])->name('serviceproviders');
    Route::get('manageservices', [SUViewsController::class, 'manageservices'])->name('manageservices');
    Route::get('loyaltypointsreport', [SUViewsController::class, 'loyaltypointsreport'])->name('loyaltypointsreport');
    Route::get('loyaltypoints', [SUViewsController::class, 'loyaltypoints'])->name('loyaltypoints');
    Route::get('points', [SUViewsController::class, 'points'])->name('points');
    Route::get('income', [SUViewsController::class, 'income'])->name('income');
    Route::get('expenses', [SUViewsController::class, 'expenses'])->name('expenses');
    Route::get('pointsredeemed', [SUViewsController::class, 'pointsredeemed'])->name('pointsredeemed');
    Route::get('subscribedpartners', [SUViewsController::class, 'subscribedpartners'])->name('subscribedpartners');
    Route::get('newsubscriptions', [SUViewsController::class, 'newsubscriptions'])->name('newsubscriptions');
	Route::get('newsfeedreport','App\Http\Controllers\ViewsController@newsfeedreport')->name('newsfeedreport');
    Route::get('addproduct', [MerchantController::class, 'addproduct'])->name('super_addproduct');
    Route::get('productlist', [MerchantController::class, 'productlist'])->name('productlist');
    Route::get('productlistexport', [MerchantController::class, 'productlistexport'])->name('productlistexport');
    Route::get('manageproducts', [MerchantController::class, 'manageproducts'])->name('manageproducts');
    Route::post('saveproduct', [MerchantController::class, 'saveproduct'])->name('saveproduct');
    Route::post('saveproductFromImport', [MerchantController::class, 'saveproductFromImport'])->name('saveproductFromImport');
    Route::get('editproduct/{id}', [MerchantController::class, 'editproduct'])->name('editproduct');
    Route::get('viewproduct/{id}', [MerchantController::class, 'viewproduct'])->name('viewproduct');
    Route::get('productstatus', [MerchantController::class, 'productstatus'])->name('productstatus');
    Route::get('editmanageproduct/{id}', [MerchantController::class, 'editmanageproduct'])->name('editmanageproduct');
    Route::post('savemanageproduct', [MerchantController::class, 'savemanageproduct'])->name('savemanageproduct');
    Route::get('purchasehistory', [MerchantController::class, 'purchasehistory'])->name('purchasehistory');
    
    Route::get('subscribedpartnersreports', [SUViewsController::class, 'subscribedpartnersreports'])->name('subscribedpartnersreports');
    Route::get('newsubsreport', [SUViewsController::class, 'newsubsreport'])->name('newsubsreport');
    
    Route::get('newmerchant', [SUViewsController::class, 'newmerchant'])->name('newmerchant');
    Route::get('editmerchant/{id}', [SUViewsController::class, 'editmerchant'])->name('editmerchant');
    Route::get('merchantlist', [SUViewsController::class, 'merchantlist'])->name('merchantlist');
    Route::get('merchantlistexport', [SUViewsController::class, 'merchantlistexport'])->name('merchantlistexport');
    Route::post('savemerchant', [SUViewsController::class, 'savemerchant'])->name('savemerchant');
    Route::post('savemerchantFromImport', [SUViewsController::class, 'savemerchantFromImport'])->name('savemerchantFromImport');
    Route::get('viewmerchant/{id}', [SUViewsController::class, 'viewmerchant'])->name('viewmerchant');
    
    Route::get('newcorporate', [SUViewsController::class, 'newcorporate'])->name('newcorporate');
    Route::get('editcorporate/{id}', [SUViewsController::class, 'editcorporate'])->name('editcorporate');
    Route::get('corporatelist', [SUViewsController::class, 'corporatelist'])->name('corporatelist');
    Route::get('corporatelistexport', [SUViewsController::class, 'corporatelistexport'])->name('corporatelistexport');
    Route::post('savecorporate', [SUViewsController::class, 'savecorporate'])->name('savecorporate');
    Route::post('savecorporateFromImport', [SUViewsController::class, 'savecorporateFromImport'])->name('savecorporateFromImport');
    Route::get('viewcorporate/{id}', [SUViewsController::class, 'viewcorporate'])->name('viewcorporate');
    Route::get('clients', [SUViewsController::class, 'clients'])->name('clients');
    Route::get('clientsexport', [SUViewsController::class, 'clientsexport'])->name('clientsexport');
    Route::get('editclient/{id}', [SUViewsController::class, 'editclient'])->name('editclient');
    Route::get('viewclient/{id}', [SUViewsController::class, 'viewclient'])->name('viewclient');
    Route::get('memberreportsadmin',[SUViewsController::class, 'memberreportsadmin'])->name('memberreportsadmin');
    Route::get('activityreportsadmin',[SUViewsController::class, 'activityreportsadmin'])->name('activityreportsadmin');
    Route::get('goalreportsadmin',[SUViewsController::class, 'goalreportsadmin'])->name('goalreportsadmin');
    Route::get('newsfeedreportsadmin',[SUViewsController::class, 'newsfeedreportsadmin'])->name('newsfeedreportsadmin');
    Route::get('rewardsreportadmin','App\Http\Controllers\SUViewsController@rewardsreportadmin')->name('rewardsreportadmin');
    Route::get('userstatus', [SUViewsController::class, 'userstatus'])->name('userstatus');
    Route::get('merchantdashboard', [MerchantController::class, 'index'])->name('merchantdashboard');
    
    Route::get('corporatedashboard', [CorporateController::class, 'index'])->name('corporatedashboard');
    Route::get('corponewuser', [CorporateController::class, 'corponewuser'])->name('corponewuser');
    Route::get('corpouserslist', [CorporateController::class, 'corpouserslist'])->name('corpouserslist');
    Route::get('corpouserslistexport', [CorporateController::class, 'corpouserslistexport'])->name('corpouserslistexport');
    Route::post('savecorpouser', [CorporateController::class, 'savecorpouser'])->name('savecorpouser');
    Route::get('editcorpouser/{id}', [CorporateController::class, 'editcorpouser'])->name('editcorpouser');
    Route::get('viewcorpouser/{id}', [CorporateController::class, 'viewcorpouser'])->name('viewcorpouser');
    Route::get('corponewsfeedadd', [CorporateController::class, 'corponewsfeedadd'])->name('corponewsfeedadd');
    Route::get('corponewsfeed', [CorporateController::class, 'corponewsfeed'])->name('corponewsfeed');
    Route::post('savecorponewsfeed', [CorporateController::class, 'savecorponewsfeed'])->name('savecorponewsfeed');
    Route::get('editcorponewsfeed/{id}', [CorporateController::class, 'editcorponewsfeed'])->name('editcorponewsfeed');
    Route::get('viewcorponewsfeed/{id}', [CorporateController::class, 'viewcorponewsfeed'])->name('viewcorponewsfeed');
   
    Route::get('newpartner', [SUViewsController::class, 'newpartner'])->name('newpartner');
    Route::get('editpartner/{id}', [SUViewsController::class, 'editpartner'])->name('editpartner');
    Route::get('partnerlist', [SUViewsController::class, 'partnerlist'])->name('partnerlist');
    Route::get('partnerlistexport', [SUViewsController::class, 'partnerlistexport'])->name('partnerlistexport');
    Route::post('savepartner', [SUViewsController::class, 'savepartner'])->name('savepartner');
    Route::post('savepartnerFromImport', [SUViewsController::class, 'savepartnerFromImport'])->name('savepartnerFromImport');
    Route::get('viewpartner/{id}', [SUViewsController::class, 'viewpartner'])->name('viewpartner');
    

    Route::get('partnerdashboard', [PartnerController::class, 'index'])->name('partnerdashboard');
    Route::get('partnernewuser', [PartnerController::class, 'partnernewuser'])->name('partnernewuser');
    Route::get('partneruserslist', [PartnerController::class, 'partneruserslist'])->name('partneruserslist');
    Route::get('partneruserslistexport', [PartnerController::class, 'partneruserslistexport'])->name('partneruserslistexport');
    Route::post('savepartneruser', [PartnerController::class, 'savepartneruser'])->name('savepartneruser');
    Route::get('editpartneruser/{id}', [PartnerController::class, 'editpartneruser'])->name('editpartneruser');
    Route::get('viewpartneruser/{id}', [PartnerController::class, 'viewpartneruser'])->name('viewpartneruser');
   
    Route::get('newsubscription', [SUViewsController::class, 'newsubscription'])->name('newsubscription');
    Route::get('editsubscription/{id}', [SUViewsController::class, 'editsubscription'])->name('editsubscription');
    Route::get('subscriptionlist', [SUViewsController::class, 'subscriptionlist'])->name('subscriptionlist');
    Route::post('savesubscription', [SUViewsController::class, 'savesubscription'])->name('savesubscription');
    Route::get('viewsubscription/{id}', [SUViewsController::class, 'viewsubscription'])->name('viewsubscription');

    
    Route::get('mysubscription',[PartnerController::class, 'mysubscription'])->name('mysubscription');
    Route::get('userwellness',[SUViewsController::class, 'userwellness'])->name('userwellness');
    Route::get('viewwellness/{id}', [SUViewsController::class, 'viewwellness'])->name('viewwellness');

    Route::get('allsubscription',[SUViewsController::class, 'allsubscription'])->name('allsubscription');
    Route::get('assignsubscription',[SUViewsController::class, 'assignsubscription'])->name('assignsubscription');
    Route::post('saveassignsub', [SUViewsController::class, 'saveassignsub'])->name('saveassignsub');
     
    Route::get('activitylogs',[SUViewsController::class, 'activitylogs'])->name('activitylogs');
    
    Route::get('revenuereport',[SUViewsController::class, 'revenuereport'])->name('revenuereport');
    
    Route::get('allusersubscription',[PartnerController::class, 'allusersubscription'])->name('allusersubscription');
    Route::get('assignusersubscription',[PartnerController::class, 'assignusersubscription'])->name('assignusersubscription');
    Route::post('saveassignusersub', [PartnerController::class, 'saveassignusersub'])->name('saveassignusersub');
    Route::get('revenueuserreport',[PartnerController::class, 'revenueuserreport'])->name('revenueuserreport');
    

    Route::get('changepartnerstatus', [SUViewsController::class, 'changepartnerstatus'])->name('changepartnerstatus');

// });

/*
|--------------------------------------------------------------------------
| End of Super User Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Partner Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function () {
//Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
    /**
     *
     *      Partner VIEWS
     *       Start
     *
     */
    Route::get('dashboard', [ViewsController::class, 'partnerIndex'])->name('dashboard');
    Route::get('addmember',[ViewsController::class, 'addmember'])->name('addmember');
    Route::get('feeds',[ViewsController::class, 'feeds'])->name('feeds');
    Route::get('newsfeedreports',[ViewsController::class, 'newsfeedreports'])->name('newsfeedreports');
    Route::get('general',[ViewsController::class, 'general'])->name('general');
    Route::get('roles',[ViewsController::class, 'roles'])->name('roles');
    Route::get('integrate',[ViewsController::class, 'integrate'])->name('integrate');
    Route::get('addplan',[ViewsController::class, 'addplan'])->name('addplan');
    Route::get('showmembers',[ViewsController::class, 'showmembers'])->name('showmembers');
    Route::get('showproducts',[ViewsController::class, 'showproducts'])->name('showproducts');
    Route::get('memberprofile',[ViewsController::class, 'memberprofile'])->name('memberprofile');
    Route::get('addmastergoals',[ViewsController::class, 'addmastergoals'])->name('addmastergoals');
    Route::get('memberreports',[ViewsController::class, 'memberreports'])->name('memberreports');
    Route::get('goalreports',[ViewsController::class, 'goalreports'])->name('goalreports');
    Route::get('assigngoals',[ViewsController::class, 'assigngoals'])->name('assigngoals');
    Route::get('membergoals',[ViewsController::class, 'membergoals'])->name('membergoals');
    Route::get('addmastergoals',[ViewsController::class, 'addmastergoals'])->name('addmastergoals');
    Route::get('showgoals',[ViewsController::class, 'showgoals'])->name('showgoals');
    Route::get('showplans',[ViewsController::class, 'showplans'])->name('showplans');
    Route::get('dailyactivities',[ViewsController::class, 'dailyactivities'])->name('dailyactivities');
    Route::get('activityreports',[ViewsController::class, 'activityreports'])->name('activityreports');
    Route::get('addreward',[ViewsController::class, 'addreward'])->name('addreward');
    Route::get('addproduct',[ViewsController::class, 'addproduct'])->name('addproduct');
    Route::get('showrewards',[ViewsController::class, 'showrewards'])->name('showrewards');
    Route::get('showproduct',[ViewsController::class, 'showrewards'])->name('showproduct');
    Route::get('rewardsallocation',[ViewsController::class, 'rewardsallocation'])->name('rewardsallocation');
    Route::get('activitylog',[ViewsController::class, 'activitylog'])->name('activitylog');
    Route::get('subscriptions',[ViewsController::class, 'subscriptions'])->name('subscriptions');
    Route::get('subscribedusers',[ViewsController::class, 'subscribedusers'])->name('subscribedusers');
    Route::get('store',[ViewsController::class, 'store'])->name('store');
    Route::get('adduser',[ViewsController::class, 'adduser'])->name('adduser');
    Route::get('users',[ViewsController::class, 'users'])->name('users');
    Route::get('newmembers',[ViewsController::class, 'newmembers'])->name('newmembers');
    //Route::get('dailyactivities','App\Http\Controllers\ViewsController@activityreports')->name('dailyactivities');
    Route::get('activitytracker','App\Http\Controllers\ViewsController@activitytracker')->name('activitytracker');
    Route::get('newsfeedreports','App\Http\Controllers\ViewsController@newsfeedreport')->name('newsfeedreports');
    Route::get('runningreport','App\Http\Controllers\ViewsController@runningreport')->name('runningreport');
    Route::get('walkingreport','App\Http\Controllers\ViewsController@walkingreport')->name('walkingreport');
    Route::get('cyclingreport','App\Http\Controllers\ViewsController@cyclingreport')->name('cyclingreport');
    Route::get('activityreport','App\Http\Controllers\ViewsController@activityreport')->name('activityreport');
    Route::get('goalsreport','App\Http\Controllers\ViewsController@goalsreport')->name('goalsreport');
    Route::get('treademillreport','App\Http\Controllers\ViewsController@treademillreport')->name('treademillreport');
    Route::get('newsfeed','App\Http\Controllers\ViewsController@newsfeed')->name('newsfeed');
    Route::get('rewardsreport','App\Http\Controllers\ViewsController@rewardsreport')->name('rewardsreport');
    Route::get('compose','App\Http\Controllers\ViewsController@compose_mail')->name('compose');
    Route::get('sms','App\Http\Controllers\ViewsController@compose_sms')->name('sms');
    Route::get('addpost','App\Http\Controllers\ViewsController@addpost')->name('addpost');
    Route::post('newpost','App\Http\Controllers\ViewsController@newpost')->name('newpost');
    Route::get('showposts','App\Http\Controllers\ViewsController@showposts')->name('showposts');
    Route::get('newsfeedreport','App\Http\Controllers\ViewsController@newsfeedreport')->name('newsfeedreport');
    Route::get('active_members','App\Http\Controllers\ViewsController@activemembers')->name('active_members');
    Route::get('dailyusers','App\Http\Controllers\ViewsController@dailyusers')->name('dailyusers');
    Route::get('totalcalories','App\Http\Controllers\ViewsController@totalcalories')->name('totalcalories');
    Route::get('stepscount','App\Http\Controllers\ViewsController@stepscount')->name('stepscount');
    Route::get('redeemed_rewards','App\Http\Controllers\ViewsController@redeemedrewards')->name('redeemed_rewards');
    Route::get('wellnessprofile','App\Http\Controllers\ViewsController@wellness_profile')->name('wellnessprofile');
    Route::get('activewalkers','App\Http\Controllers\ViewsController@activewalkers')->name('activewalkers');
    Route::get('activerunners','App\Http\Controllers\ViewsController@activerunners')->name('activerunners');
    Route::get('activezumba','App\Http\Controllers\ViewsController@activezumba')->name('activezumba');
    Route::get('activecyclers','App\Http\Controllers\ViewsController@activecyclers')->name('activecyclers');
    Route::get('redeemed_rewards','App\Http\Controllers\ViewsController@redeemedrewards')->name('redeemed_rewards');
    Route::post('wellnessdata','App\Http\Controllers\ViewsController@wellnessdata')->name('wellnessdata');
 


    /**
     *
     *      Partner VIEWS
     *       End
     *
     */


    /**
     * WELLNESS PARAMETERS
     */
    Route::get('wellness/parameters/','App\Http\Controllers\WellnessParameterController@index');
    Route::get('wellness/parameters/{id}','App\Http\Controllers\WellnessParameterController@show');
    Route::post('wellness/parameters/add',[PartnerWellnessPlanController::class, 'store']);
    Route::put('wellness/parameters/update/{id}','App\Http\Controllers\WellnessParameterController@update');
    Route::delete('wellness/parameters/delete/{id}','App\Http\Controllers\WellnessParameterController@destroy');
    /**
     *
     * USER GOALS
     *
     */
    Route::get('user/wellness/goals/','App\Http\Controllers\UserWellnessGoalController@index');
    Route::get('user/wellness/goals/{id}','App\Http\Controllers\UserWellnessGoalController@show');
    Route::post('user/wellness/goals/add','App\Http\Controllers\UserWellnessGoalController@store');
    Route::put('user/wellness/goals/update/{id}','App\Http\Controllers\UserWellnessGoalController@update');
    Route::delete('user/wellness/goals/delete/{id}','App\Http\Controllers\UserWellnessGoalController@destroy');
    /**
     *
     * USER WELLNESS LOG
     *
     */
    Route::get('user/wellness/logs/','App\Http\Controllers\UserWellnessLogController@index');
    Route::get('user/wellness/logs/{id}','App\Http\Controllers\UserWellnessLogController@show');
    Route::post('user/wellness/logs/add','App\Http\Controllers\UserWellnessLogController@store');
    Route::put('user/wellness/logs/update/{id}','App\Http\Controllers\UserWellnessLogController@update');
    Route::delete('user/wellness/logs/delete/{id}','App\Http\Controllers\UserWellnessLogController@destroy');
    /**
     *
     * USER
     */
    Route::post('users/', [UserController::class, 'store']);
    Route::put('users/update/', [UserController::class, 'update']);
    Route::delete('users/delete/{id}', [UserController::class, 'destroy']);
    /**
     *
     * User Subscription Plans
     */
    Route::post('subscription/plans/create/{partner_id}', [UserSubscriptionPlanController::class, 'store']);
    Route::put('subscription/plans/update/{id}', [UserSubscriptionPlanController::class, 'update']);
    Route::delete('subscription/plans/delete/{id}', [UserSubscriptionPlanController::class, 'destroy']);
    /**
     *
     * PARTNER
     */
    Route::post('partner/create', [PartnerController::class, 'store']);
    Route::post('partner/update', [PartnerController::class, 'update'])->name('update_partner');
    Route::delete('partner/delete/{id}', [PartnerController::class, 'destroy']);
    /**
     *
     * MEMBERS
     */
    Route::post('members/create', [MembersController::class, 'store'])->name('create_member');
    Route::post('members/{id}', [MembersController::class, 'fetch'])->name('fetch_member');
    Route::post('members/update/{id}', [MembersController::class, 'update'])->name('update_member');
    Route::post('members/delete/{id}', [MembersController::class, 'destroy'])->name('destroy_member');
    Route::get('members/with-bmi-info', [MembersController::class, 'fetchWithBMI'])->name('fetch_member_with_bmi_info');

    /**
     *
     * MASTER GOALS
     */
    Route::post('mastergoals/create', [PartnerMasterGoalsController::class, 'store'])->name('create_master_goals');
    Route::post('mastergoals/update/{id}', [PartnerMasterGoalsController::class, 'update'])->name('update_master_goals');
    Route::post('mastergoals/delete/{id}', [PartnerMasterGoalsController::class, 'destroy'])->name('destroy_master_goals');
    /**
     *
     * REWARDS
     */
    Route::post('rewards/create', [RewardController::class, 'store'])->name('create_rewards');
    Route::post('rewards/update/{id}', [RewardController::class, 'update'])->name('update_rewards');
    Route::post('rewards/delete/{id}', [RewardController::class, 'destroy'])->name('destroy_rewards');
    /**
     * PARTNER WELLNESS PLANS
     */
    Route::get('partner/wellness/plans/{id}',[PartnerWellnessPlanController::class, 'index'])->name('fetch_partner_wellness_plan');
    Route::post('partner/wellness/plans/add',[PartnerWellnessPlanController::class, 'store'])->name('create_partner_wellness_plan');
    Route::post('partner/wellness/plans/update/{id}',[PartnerWellnessPlanController::class, 'update'])->name('update_partner_wellness_plan');
    Route::post('partner/wellness/plans/delete/{id}',[PartnerWellnessPlanController::class, 'destroy'])->name('destroy_partner_wellness_plan');
    /**
     * ACTIVITIES
     */
    Route::get('activities', [ActivitiesController::class, 'index'])->name('fetch_activities');
    Route::get('member/activities/{member_id}', [ActivitiesController::class, 'member'])->name('fetch_member_activities');
    Route::post('member/activities/range/{partner_id}/{startDate}/{endDate}/{activities}/{weight}', [ActivitiesController::class, 'activityRange'])->name('fetch_range_activities');
    /**
     * ASSIGN GOALS
     */
    Route::post('assign/goals', [AssignGoalController::class, 'store'])->name('assign_goal');
    Route::post('overwrite/goals', [AssignGoalController::class, 'overwrite'])->name('overwrite_goal');
    /**
     * PARTNER GOALS
     */

    Route::get('partner/wellness/goals/','App\Http\Controllers\PartnerGoalController@index');
    Route::get('partner/wellness/goals/{id}','App\Http\Controllers\PartnerGoalController@show');
    Route::post('partner/wellness/goals/add','App\Http\Controllers\PartnerGoalController@store');
    Route::post('partner/wellness/goals/update/{id}','App\Http\Controllers\PartnerGoalController@update');
    Route::post('partner/wellness/goals/delete/{id}','App\Http\Controllers\PartnerGoalController@destroy');
    /**
     * CREATE POST
     */
    Route::post('newsfeed/post', [NewsFeedsController::class, 'store'])->name('create_post');
    Route::get('newsfeed/post/update_msb_indicators', [NewsFeedsController::class, 'update_msb_indictaors'])->name('update_msb_indictaors');
    /**
     * CREATE POST
     */

    /**
     *
     * PARTNER WELLNESS LOG
     *
     */
    Route::get('partner/wellness/logs/','App\Http\Controllers\PartnerWellnessLogController@index');
    Route::get('partner/wellness/logs/{id}','App\Http\Controllers\PartnerWellnessLogController@show');
    Route::post('partner/wellness/logs/add','App\Http\Controllers\PartnerWellnessLogController@store');
    Route::post('partner/wellness/logs/update/{id}','App\Http\Controllers\PartnerWellnessLogController@update');
    Route::post('partner/wellness/logs/delete/{id}','App\Http\Controllers\PartnerWellnessLogController@destroy');

    /**
     *
     * PARTNER GOAL CONSTRAINS
     *
     */
    Route::get('partner/goals/constraints','App\Http\Controllers\PartnerGoalConstraintController@index');
    Route::get('partner/goals/constraints/{id}','App\Http\Controllers\PartnerGoalConstraintController@show');
    Route::post('partner/goals/constraints/add','App\Http\Controllers\PartnerGoalConstraintController@store');
    Route::put('partner/goals/constraints/update/{id}','App\Http\Controllers\PartnerGoalConstraintController@update');
    Route::delete('partner/goals/constraints/delete/{id}','App\Http\Controllers\PartnerGoalConstraintController@destroy');
    /**
     *
     */
});

/*
|--------------------------------------------------------------------------
| End of Partner Routes
|--------------------------------------------------------------------------
*/
Route::get('manager/home', 'App\Http\Controllers\HomeController@managerHome')->name('home.manager')->middleware('is_admin');

