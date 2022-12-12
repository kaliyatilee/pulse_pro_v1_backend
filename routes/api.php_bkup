<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SUController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AppController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('login','App\Http\Controllers\AppController@login');
Route::post('registeruser','App\Http\Controllers\AppController@register');
Route::post('createprofile','App\Http\Controllers\AppController@create_profile');
Route::post('addmac','App\Http\Controllers\AppController@add_mac');
Route::get('allrewards','App\Http\Controllers\AppController@getAllRewards');
Route::post('allrewards','App\Http\Controllers\AppController@getAllRewards');
Route::post('allcorporates','App\Http\Controllers\AppController@getAllCorporates');
Route::post('updatepoints','App\Http\Controllers\AppController@addLoyalPoint');
Route::post('addfcmtokken','App\Http\Controllers\AppController@add_fcm_tokken');
Route::post('sendnoti','App\Http\Controllers\AppController@send_notification');
Route::post('allfeeds','App\Http\Controllers\AppController@get_news_feeds');
Route::post('myfeeds','App\Http\Controllers\AppController@get_my_news_feeds');
Route::post('allusers','App\Http\Controllers\AppController@get_all_users');
Route::post('addfriend','App\Http\Controllers\AppController@add_friend_request');
Route::post('friendreq','App\Http\Controllers\AppController@friend_request');
Route::post('friendreqreject','App\Http\Controllers\AppController@reject_friend_request');
Route::post('friendreqaccept','App\Http\Controllers\AppController@accept_friend_request');
Route::post('friendlists','App\Http\Controllers\AppController@get_friend_list');
Route::post('check_sms_forgot','App\Http\Controllers\AppController@forgot_paasword_sms_check');
Route::post('otp_verify','App\Http\Controllers\AppController@otp_verify');
Route::post('check_email_forgot','App\Http\Controllers\AppController@forgot_paasword_email_check');
Route::post('change_passi','App\Http\Controllers\AppController@change_paasword');
Route::post('isa_pic','App\Http\Controllers\AppController@add_profile_pic');
Route::post('addfeed','App\Http\Controllers\AppController@add_new_feed');
Route::post('dailysync','App\Http\Controllers\AppController@dailyreadssync');
Route::post('actsync','App\Http\Controllers\AppController@actsync');
Route::post('transaction_history','App\Http\Controllers\AppController@getAllTransactions');
Route::post('getDisease','App\Http\Controllers\AppController@getDisease');
Route::post('generateWellnessPlan','App\Http\Controllers\AppController@generateWellnessPlan');
Route::post('getMyWellnessPlan','App\Http\Controllers\AppController@getMyWellnessPlan');
Route::post('getFriends','App\Http\Controllers\AppController@getFriends');
Route::post('getMyPlan','App\Http\Controllers\AppController@getMyPlan');
Route::post('deleteFeed','App\Http\Controllers\AppController@deleteFeed');

Route::post('unfriend','App\Http\Controllers\AppController@unfriend');

Route::post('add_feed_activities','App\Http\Controllers\AppController@feedActivities');
Route::post('getfeeddetails','App\Http\Controllers\AppController@getFeedDetails');
Route::post('addcard','App\Http\Controllers\AppController@addcard');
Route::post('subscribe','App\Http\Controllers\AppController@subscribe');
Route::post('cancelSubscribe','App\Http\Controllers\AppController@cancelSubscribe');

Route::post('getsubscriptionplans','App\Http\Controllers\AppController@getSubscriptionPlans');
Route::post('getusersubscriptionplans','App\Http\Controllers\AppController@getUserSubscriptionPlans');
Route::post('createsubscription','App\Http\Controllers\AppController@create_subscription');
Route::post('getsubscription','App\Http\Controllers\AppController@get_subscription');

Route::get('testone','App\Http\Controllers\AppController@send_one_signal');
Route::post('testmail','App\Http\Controllers\AppController@send_email_test');
Route::post('testaws', 'App\Http\Controllers\ImageController@store');
Route::post('testfeeds','App\Http\Controllers\AppController@get_news_feeds_test2');

//Route::get('/', 'App\Http\Controllers\ImageController@create');
//Route::post('/', 'App\Http\Controllers\ImageController@store');
//Route::get('/{image}', 'App\Http\Controllers\ImageController@show');

Route::get('allrewards','App\Http\Controllers\AppController@getAllRewards');
Route::post('allrewards','App\Http\Controllers\AppController@getAllRewards');
Route::post('getcoins','App\Http\Controllers\AppController@getCoins');

Route::post('store/redeem', [StoreController::class, 'redeem']);
Route::post('store/redeem/checkredeemcode', [StoreController::class, 'checkRedeemCode']);

Route::post('redeem','App\Http\Controllers\StoreController@redeemAPI');
Route::post('checkredeemcode','App\Http\Controllers\StoreController@checkRedeemCodeAPI');

Route::post('user/activities/{member_id}', [ActivitiesController::class, 'member']);
Route::post('user/activities/stepcount/{member_id}', [ActivitiesController::class, 'activityStep']);

Route::post('setgoal','App\Http\Controllers\AppController@setgoal');
Route::post('fetchgoal','App\Http\Controllers\AppController@fetchgoal');

/*
 * Ben : Test APIRoutes
 *      TODO: Remove once done testing
 */
Route::post('partner/create', [PartnerController::class, 'store']);
Route::put('partner/update/{id}', [PartnerController::class, 'update']);
Route::delete('partner/delete/{id}', [PartnerController::class, 'destroy']);

Route::post('super/create', [SUController::class, 'store']);
Route::put('super/update/{id}', [SUController::class, 'update']);
Route::delete('super/delete/{id}', [SUController::class, 'destroy']);

Route::get('activewhen', [MembersController::class, 'activewhen']);

/* Added by Piyush */
Route::post('addActivityDetails','App\Http\Controllers\AppController@addActivityDetails');
Route::post('getActivityDetailsLists','App\Http\Controllers\AppController@getActivityDetailsLists');
Route::post('getMyFriendLists','App\Http\Controllers\AppController@getMyFriendLists');
Route::post('getDashboardReport','App\Http\Controllers\AppController@getDashboardReport');
Route::post('getDashboardData','App\Http\Controllers\AppController@getDashboardData');

//Route::post('getDashboardData', [AppController::class, 'getDashboardData']);

Route::post('friendDetails','App\Http\Controllers\AppController@friendDetails');
Route::post('getUserDetails','App\Http\Controllers\AppController@getUserDetails');
Route::get('calCoins','App\Http\Controllers\AppController@calCoins');
/*
 * Ben : END
 *
 */


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
    return response("Cleared",200);
});