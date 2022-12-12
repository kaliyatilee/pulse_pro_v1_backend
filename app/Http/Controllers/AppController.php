<?php


namespace App\Http\Controllers;

use App\Feeds;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use OneSignal;
use Validator;
use Session;
use Hash;
use File;
use Auth;
use App\User;
use App\Likes;
use Illuminate\Support\Facades\Http;
use DB;
use Stripe;
use DateTime;

class AppController extends Controller{

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'=>'required'
        ]);

        /* $logs = array(
            "user_id" => '0',
            "api_name" => 'Login',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else{

            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $blankObj = (object)[];

                    // $accessToken = $user->createToken('authToken')->accessToken;
                    $token = DB::table('subscriptions')->where('user_id',$user->id)->select('*','id as subscriptions_id')->orderBy('id','DESC')->where('type','!=','trial')->first();
                    if(!is_null($token)){
                        $date_current = date('Y-m-d H:i:s');

                        if($token->expire_date < $date_current){
                            
                            $response = ['user' => $user,'token' => $blankObj, 'authToken' => "Yo","status"=>"success"];

                        }else{
                            
                            $status = $token->status;
                            /* if($status == 'cancel'){
                               $token = $blankObj;     
                            } */
                            
                            $response = ['user' => $user,'token' => $token , 'authToken' => "Yo","status"=>"success"];
                        }

                    }
                    else{
                        $response = ['user' => $user,'token' => $blankObj, 'authToken' => "Yo","status"=>"success"];
                    }

                    if (isset($request->fcm_tokken)) {
                        $fcm_token_arr = array(
                        'fcm_tokken' => $request->fcm_tokken,
                        );
                        $datastripeuser = DB::table('users')->where('id', $user->id)->update($fcm_token_arr);
                    }   

                    return response($response, 200);
                } else {
                    $response = ["message" => "Password mismatch","status"=>"error"];
                    return response($response, 200);
                }
            } else {
                $response = ["message" =>'User does not exist',"status"=>"error"];
                return response($response, 200);

            }

        }


    }

    public function addcard(Request $request){
        $validator =Validator::make($request->all(),[
            'user_id'=>'required',
            'source_token'=>'required',
        ]);

        if ($validator->fails()) {
            $response = ["message" =>$validator->errors() ,"status"=>"error"];
            return response($response, 200);
        } else {

            $userdata = DB::table('users')->where('id',$request->input('user_id'))->first();

            try {
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $stripe->customers->createSource(
                    $userdata->customer_id,
                    ['source' => $request->input('source_token')]
                );
                
                $datastripe = array(
                    'card_status' => 1
                );
                $datastripeuser = DB::table('subscriptions')->where('user_id',$request->input('user_id'))->update($datastripe);
                
                DB::table('users')->where('id',$request->input('user_id'))->update($datastripe);
                
                $response = ["message" =>'card added successful',"status"=>"success"];
                return response($response, 200);
            } catch (\Stripe\Exception\RateLimitException $e) {
                // Too many requests made to the API too quickly
                $response = ["message" =>$e->getError()->message,"status"=>"error"];
                return response($response, 200);
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                // Invalid parameters were supplied to Stripe's API
                $response = ["message" =>$e->getError()->message,"status"=>"error"];
                return response($response, 200);
            } catch (\Stripe\Exception\AuthenticationException $e) {
                // Authentication with Stripe's API failed
                $response = ["message" =>$e->getError()->message,"status"=>"error"];
                return response($response, 200);
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                // Network communication with Stripe failed
                $response = ["message" =>$e->getError()->message,"status"=>"error"];
                return response($response, 200);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                // Display a very generic error to the user, and maybe send
                $response = ["message" =>$e->getError()->message,"status"=>"error"];
                return response($response, 200);
            } catch (Exception $e) {
                // Something else happened, completely unrelated to Stripe
                $response = ["message" =>$e->getError()->message,"status"=>"error"];
                return response($response, 200);
            }
        }
    }

    public function subscribe(Request $request){
        $validator =Validator::make($request->all(),[
            'user_id'=>'required'
        ]);

        /* $logs = array(
            "user_id" => $request->input('user_id'),
            "api_name" => 'subscribe',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        if ($validator->fails()) {
            $response = ["message" =>$validator->errors() ,"status"=>"error"];
            return response($response, 200);
        }else{
            $plan_id = $request->input('plan_id');
            $plans = DB::table('subscription_plans')->where('id',$plan_id)->first();
            if (!empty($plans)) {
                $days = $plans->days;
                $price_id = $plans->price_id;
                $dateplus = strtotime("+$days day");
            }else{
                $dateplus = strtotime("+30 day");
                $response = ["message" =>'Something went wrong!',"status"=>"error"];
                return response($response, 200);
            }

            $userdata = DB::table('users')->where('id',$request->input('user_id'))->first();
            $customer_id = $userdata->customer_id;

            $date_current = date('Y-m-d H:i:s',$dateplus);

            try {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $response = \Stripe\Subscription::create([
                    'customer' => $customer_id,
                    'items' => [
                    [
                        'price' => $price_id,
                    ],
                    ]
                ]);

                /* $stripe_log = array(
                    "user_id" => $request->input('user_id'),
                    "api_name" => 'create subscription in stripe',
                    "api_request" => 'NA',
                    "api_response" => json_encode($response),
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                );
                DB::table('api_logs')->insertGetId($stripe_log); */

                $id = $response->id;
                $paid = $response->paid;
                $status = $response->status;

                if (($status == 'succeeded' || $status == 'active' || $status == 'trialing')) {
                    $data = array(
                        'token_id'=> 0,
                        'subscription_id' => $id,
                        'user_id'=> $request->input('user_id'),
                        'plan_id' => $request->input('plan_id'),
                        'expire_date'=> $date_current,
                        'type'=>"",
                        'status'=>"active"
                    );
        
                    $subadd = DB::table('subscriptions')->insertGetId($data);
        
                    if(!is_null($subadd)){
        
                        $token = DB::table('subscriptions')->select('*','id as subscriptions_id')->where('user_id',$request->input('user_id'))->where('type','!=','trial')->orderBy('id','DESC')->first();
                        
                        $response = ["message" =>'Subscribe successful', 'token' => $token, "status"=>"success"];
                        return response($response, 200);
                    }else{
                        $response = ["message" =>'Something went wrong!',"status"=>"error"];
                        return response($response, 200);
                    }
                }

            } catch(Error\Card $e) {
                /* $stripe_log = array(
                    "user_id" => $request->input('user_id'),
                    "api_name" => 'stripe catch',
                    "api_request" => 'NA',
                    "api_response" => json_encode($e),
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                );
                DB::table('api_logs')->insertGetId($stripe_log); */

                $response = ["message" =>'Something went wrong!',"status"=>"error"];
                return response($response, 200);
            }
        }
    }

    public function cancelSubscribe(Request $request){
        $validator =Validator::make($request->all(),[
            'user_id'=>'required',
            'subscriptions_id' => 'required'
        ]);

        /* $logs = array(
            "user_id" => $request->input('user_id'),
            "api_name" => 'cancelSubscribe',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        if ($validator->fails()) {
            $response = ["message" =>$validator->errors() ,"status"=>"error"];
            return response($response, 200);
        }else{

            try {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                
                $subscriptions = DB::table('subscriptions')->where('id',$request->input('subscriptions_id'))->first();
                $subscription_id = $subscriptions->subscription_id;

                $subscription = \Stripe\Subscription::update(
                    $subscription_id,
                    [
                    'cancel_at_period_end' => true,
                    ]
                );

                /* $logs = array(
                    "user_id" => $request->input('user_id'),
                    "api_name" => 'cancelSubscribe',
                    "api_request" => 'NA',
                    "api_response" => json_encode($subscription),
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                );
                DB::table('api_logs')->insertGetId($logs); */

                $datastripe = array(
                    'status' => 'cancel'
                );
                $datastripeuser = DB::table('subscriptions')->where('id',$request->input('subscriptions_id'))->update($datastripe);
                
                if(!is_null($datastripeuser)){
                    $response = ["message" =>'Subscribe cancel successful',"status"=>"success"];
                    return response($response, 200);
                }else{
                    $response = ["message" =>'Something went wrong!',"status"=>"error"];
                    return response($response, 200);
                }

                return (int) '1';
            } catch(\Stripe\Exception\CardException $e) {
                // Since it's a decline, \Stripe\Exception\CardException will be caught
                $error_mesage = $e->getError()->message;
                return (int) '0';
            } catch (\Stripe\Exception\RateLimitException $e) {
                $error_mesage = $e->getError()->message;
                return (int) '0';
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $error_mesage = $e->getError()->message;
                
                return (int) '0';
            } catch (\Stripe\Exception\AuthenticationException $e) {
                $error_mesage = $e->getError()->message;
                
                return (int) '0';
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                $error_mesage = $e->getError()->message;
                
                return (int) '0';
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $error_mesage = $e->getError()->message;
                
                return (int) '0';
            } catch (Exception $e) {
                $error_mesage = $e->getError()->message;
                
                return (int) '0';
            }

            /* $logs = array(
                "user_id" => $request->input('user_id'),
                "api_name" => 'cancelSubscribe-catch',
                "api_request" => $error_mesage,
                "api_response" => 'NA',
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            );
            DB::table('api_logs')->insertGetId($logs); */

            $response = ["message" =>'Something went wrong!',"status"=>"error"];
            return response($response, 200);
        }
    }

    public function register(Request $request){

        $validator =Validator::make($request->all(),[
            'email'=>'email|required|unique:users',
            'password'=>'required',
            'roleId'=>'required',
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else{

            $firstname = $request->input('firstname');
            if(isset($firstname)){
                $firstname = $request->input('firstname');
            }else{
                $firstname = "";
            }

            $data = array(
                'firstname'=>$firstname,
                'email'=>$request->input('email'),
                'password'=>Hash::make($request->input('password')),
                'roleId'=>$request->input('roleId'),
                'is_admin'=>"2",
                'remember_token'=> "123456789",
                'status'=> "new",
                'role' => "user"
            );

            //dd($data);

            $user = User::create($data);
            //$user->assignRole('user');
            //  $addRole = User::find($user->id);
            //   $addRole->addRole('user');
            if ($user){

                $dateplus = strtotime("+30 day");
                $date_current = date('Y-m-d H:i:s',$dateplus);

                $data = array(
                    'token_id'=> 0,
                    'user_id'=> $user->id,
                    'expire_date'=> $date_current ,
                    'type'=>"trial"
                );

                $subadd = DB::table('subscriptions')->insertGetId($data);

                if(!is_null($subadd)){

                    $maildata = ['email' => $request->input('email'), 'name' => ""];
                    try {

                        Mail::send('mail.welcome', ['md' => $maildata], function ($msg) use ($maildata) {
                            $msg->from(env('MAIL_USERNAME'), "Pulse Health");
                            $msg->to($maildata['email']);
                            $msg->subject('Welcome To Pulse Health');
                        });
                    }catch (\Exception $e){

                    }

                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    $customers = $stripe->customers->create([
                        'email' => $request->input('email'),
                    ]);
                    $datastripe = array(
                        'customer_id' => $customers->id,
                    );
                    $datastripeuser = DB::table('users')->where('id',$user->id)->update($datastripe);

                    $response = ["message" =>'Registration successful',"status"=>"success"];
                    return response($response, 200);
                }

            }
            else
            {

                $response = ["message" =>'User already exist',"status"=>"error"];
                return response($response, 200);

            }

        }

    }

    public function create_profile(Request $request){

        $validator =Validator::make($request->all(),[
            'id'=>'required|string',
            'firstname'=>'required|string',
            'lastname'=>'required|string',
            'dob'=>'required|string',
            'gender'=>'required|string',
            'phone'=>'required|string',
            'height'=>'required|string',
            'weight'=>'required|string'
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else {
            $corporate_id = '0';
            if(isset($request->corporate_id)){
                $corporate_id = $request->input('corporate_id');
            }

            $weight = $request->input('weight');
            $height = $request->input('height');

            $height1 = $height/100;

            $bmi = $weight/($height1*$height1);
            $bmi = str_ireplace(",","", number_format($bmi,2));

            $data = array(
                'id' => $request->input('id'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'dob' => $request->input('dob'),
                'gender' => $request->input('gender'),
                'phone' => $request->input('phone'),
                'country' =>$request->input('country'),
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'bmi' => $bmi,
                'corporate_id' => $corporate_id,
                'remember_token' => "android",
                'status' => "active"
            );


            $user = DB::table('users')->where('id',$request->input('id'))->update($data);



            if (!is_null($user)) {

                $userdata = DB::table('users')->where('id',$request->input('id'))->first();

                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $customers = $stripe->customers->update($userdata->customer_id,[
                    'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
                ]);

                $response = ['user' => $userdata, 'authToken' => "Yo","status"=>"success"];
                //$response = ["user"=> json_encode($userdata),"message" => $data, "status" => "success"];
                return response($response, 200);

            }else{
                $response = ["message" =>'Error creating profile , please try again.',"status"=>"error"];
                return response($response, 200);
            }
        }
    }

    
    public function setgoal(Request $request){

        $validator =Validator::make($request->all(),[
            'user_id'=>'required',
            'weight'=>'required',
            'steps'=>'required',
            'calories'=>'required',
            'running_distance'=>'required'
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else {
            
            $goalDate = date("Y-m-d");
            $created_at = date("Y-m-d H:i:s");

            $setgoal = DB::table('setgoal')->where('goalDate',$goalDate)->where('user_id',$request->input('user_id'))->first();

            if(empty($setgoal)){
                $data = array(
                    'user_id' => $request->input('user_id'),
                    'weight' => $request->input('weight'),
                    'steps' => $request->input('steps'),
                    'calories' => $request->input('calories'),
                    'running_distance' => $request->input('running_distance'),
                    'goalDate' => $goalDate,
                    'created_at' => $created_at
                );
                $usersetgoal = DB::table('setgoal')->insert($data);
                // $usersetgoal = Setgoal::create($data);

                if (!is_null($usersetgoal)) {
                    $response = ["message" =>'Goal set successful',"status"=>"success"];
                    return response($response, 200);
                } else {
                    $response = ["message" =>'Error, please try again.',"status"=>"error"];
                    return response($response, 200);
                }
            } else {
                $response = ["message" =>'Goal already set.',"status"=>"error"];
                return response($response, 200);
            }
        }
    }

      
    public function fetchgoal(Request $request){

        $validator =Validator::make($request->all(),[
            'user_id'=>'required'
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        } else {
            
            $goalDate = date("Y-m-d");

            $fetchgoal = DB::table('setgoal')->where('goalDate',$goalDate)->where('user_id',$request->input('user_id'))->first();

            if (!is_null($fetchgoal)) {
                $response = ['data' => $fetchgoal, 'authToken' => "Yo","status"=>"success"];
                return response($response, 200);
            } else{
                $response = ["message" =>'No data set for today.',"status"=>"error"];
                return response($response, 200);
            }
           
        }
    }


    public function create_subscription(Request $request){

        $validator =Validator::make($request->all(),[
            'id'=>'required',
            'plan_id'=>'required',
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else {

            $id = $request->input('id');
            $plan_id = $request->input('plan_id');
            
            $userdata = DB::table('users')->where('id',$id)->first();
            $plandata = DB::table('subscription_plans')->where('id',$plan_id)->first();

            if (!is_null($userdata)) {
               
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $subscriptions = $stripe->subscriptions->create([
                    'customer' => $userdata->customer_id,
                    'items' => [
                      ['price' => $plandata->price_id],
                    ],
                ]);
                
                $current_period_start = date('Y-m-d H:i:s', $subscriptions->current_period_start);
                $current_period_end = date('Y-m-d H:i:s', $subscriptions->current_period_end);
                $status = $subscriptions->status;

                $datastripe = array(
                    'subscription_id' => $subscriptions->id,
                    'plan_id' => $plan_id,
                    'current_period_start' => $current_period_start,
                    'current_period_end' => $current_period_end,
                    'status' => $status,
                );
                $datastripeuser = DB::table('subscriptions')->where('user_id',$userdata->id)->update($datastripe);

                $response = ['subscription' => $subscriptions->id, 'authToken' => "Yo","status"=>"success"];
                return response($response, 200);

            }else{

                $response = ["message" =>'Error subscription , please try again.',"status"=>"error"];
                return response($response, 200);

            }
        }
    }

    public function get_subscription(Request $request){

        $validator =Validator::make($request->all(),[
            'id'=>'required',
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        } else {

            $id = $request->input('id');
            $subscriptiondata = DB::table('subscriptions')
                    ->join('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
                    ->select('subscriptions.subscription_id','subscriptions.current_period_start','subscriptions.current_period_end','subscription_plans.plan_name','subscription_plans.amount')
                    ->where('user_id',$id)
                    ->first();

            if (!is_null($subscriptiondata)) {
                $response = ['data' => $subscriptiondata, 'authToken' => "Yo","status"=>"success"];
                return response($response, 200);
            } else{
                $response = ["message" =>'Error subscription , please try again.',"status"=>"error"];
                return response($response, 200);
            }
        }
    }

    public function add_mac(Request $request){

        $validator =Validator::make($request->all(),[
            'id'=>'required|string',
            'macAddress'=>'required|string',

        ]);


        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else {

            $data = array(
                'macAddress' => $request->input('macAddress'),
            );


            $user = DB::table('users')->where('id',$request->input('id'))->update($data);



            if (!is_null($user)) {

                $response = ['authToken' => "Yo","status"=>"success"];
                return response($response, 200);
            }else{
                $response = ['authToken' => "Yo","status"=>"error"];
                return response($response, 200);
            }

        }

    }

    public function getAllRewards(Request $request){



        $usercoins = DB::table('users')->where("id",$request->input('user_id'))->select('loyaltpoints')->get();

        //dd($usercoins[0]->loyaltpoints);

        $rewards = DB::table('rewards')->where('status','approved')->get();

        $response = ['rewards' => $rewards, 'authToken' => "Yo","status"=>"success",'user' => $usercoins];
        return response($rewards, 200);

    }

    public function getCoins(Request $request){

        $usercoins = DB::table('users')->where("id",$request->input('user_id'))->select('coins')->get();

        return response($usercoins[0]->coins, 200);
    }

    public function addLoyalPoint(Request $request){

        $validator =Validator::make($request->all(),[
            'id'=>'required|string',
            'points'=>'required|string',

        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else {

            $data = array(
                'loyaltpoints' => $request->input('points'),
            );


            $user = DB::table('users')->where('id',$request->input('id'))->update($data);

            if (!is_null($user)) {

                $response = ['authToken' => "Yo","status"=>"success"];
                return response($response, 200);
            }else{
                $response = ['authToken' => "Yo","status"=>"error"];
                return response($response, 200);
            }

        }

    }

    public function add_fcm_tokken(Request $request){
        $validator =Validator::make($request->all(),[
            'id'=>'required|string',
            'fcm_tokken'=>'required|string',

        ]);

        /* $logs = array(
            "user_id" => $request->input('id'),
            "api_name" => 'add_fcm_tokken',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else {

            $data = array(
                'fcm_tokken' => $request->input('fcm_tokken'),
            );


            $user = DB::table('users')->where('id',$request->input('id'))->update($data);

            if (!is_null($user)) {

                $response = ['authToken' => "Yo","status"=>"success"];
                return response($response, 200);
            }else{
                $response = ['authToken' => "Yo","status"=>"error"];
                return response($response, 200);
            }

        }
    }

    public function get_news_feeds(Request $request){

        /* $logs = array(
            "user_id" => $request->input('user_id'),
            "api_name" => 'get_news_feeds',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        //Getting the page number which is to be displayed
        $page = $request->input('page');

        //Initially we show the data from 1st row that means the 0th row
        $start = 0;

        //Limit is 2 that means we will show 2 items at once
        $limit = 10;

        $total = count(DB::table('newsfeeds')->get());

        //We can go atmost to page number total/limit
        $page_limit = $total/$limit;

        //If the page number is more than the limit we cannot show anything
        //if($page<=$page_limit){
        if($page != 0){
            //Calculating start for every given page number
            $start = ($page - 1) * $limit;

            //dd($start);

            //$newsfeeds = DB::table('newsfeeds')->get();
            $user_id = $request->input('user_id');
            if(isset($user_id)){
                $user = DB::table('users')->select('corporate_id')->where('id',$user_id)->first();
                $corporate_id = $user->corporate_id;
                if(empty($corporate_id)){
                    $corporate_id = $user_id;
                }
            }else{
                $corporate_id = $user_id;
            }

            $newsfeeds = DB::select('SELECT n.*,u.firstname,u.lastname,u.profileurl, u.points, u.coins
                                FROM newsfeeds AS n
                                INNER JOIN friends AS f
                                    ON (n.postedby = f.friend_id AND f.user_id = '.$request->input('user_id').' AND f.status = "active") OR (n.postedby = f.user_id AND f.friend_id = '.$request->input('user_id').' AND f.status = "active")
                                JOIN users AS u
                                  ON n.postedby = u.id
                                UNION ALL
                                SELECT n.*,u.firstname,u.lastname,u.profileurl, u.points, u.coins
                                FROM newsfeeds AS n
                                JOIN users AS u
                                  ON n.postedby = u.id
                                WHERE (n.postedby = '.$request->input('user_id').' OR n.postedby = '.$corporate_id.')
                                AND n.viewstatus<>"me"
                                ORDER BY `created_at` DESC
                                LIMIT '.$limit.' OFFSET '.$start.' ');
            
            if(!empty($newsfeeds)){

                $arr = array();
                foreach($newsfeeds as $val){
                    $d['id'] = $val->id;
                	$d['points'] = $val->points;
                	$d['coins'] = $val->coins;

                    $tot_likes = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','1')->count('user_id');
                    $tot_unlikes = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','3')->count('user_id');
                    $tot_likescount = $tot_likes - $tot_unlikes;
                    
                    if ($tot_likescount < 0) {
                        $d['tot_likes'] = 0; 
                    }else{
                        $d['tot_likes'] = $tot_likescount;
                    }

                    $d['tot_comment_count'] = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','2')->count('user_id');
                    
                    $check = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('user_id','=',$request->input('user_id'))->where('type','!=','2')->orderBy('id','DESC')->first();
                    if(!empty($check)){
                        $type = $check->type;
                        if($type == 1){
                            $d['like_status'] = 'like';
                        }else{
                            $d['like_status'] = 'unlike';
                        }
                    }else{
                        $d['like_status'] = '';
                    }

                    $d['postedby'] = $val->postedby;
                    $d['category'] = $val->category;
                    $d['headline'] = $val->headline;
                    $d['post'] = $val->post;
                    $imageurl = $val->imageurl;
                    $imageurl = str_ireplace("/core","",$imageurl);
                    //$imageurl = str_replace("pulse-wellness.tech/","jedaidevbed.in/pluse-wellness/",$imageurl);
                    $d['imageurl'] = $imageurl;
                    $d['partnerid'] = $val->partnerid;
                    $d['type'] = $val->type;
                    $d['created_at'] = $val->created_at;
                    $d['viewstatus'] = $val->viewstatus;
                    $d['updated_at'] = $val->updated_at;

                    //$user = DB::table('users')->select('corporate_id')->where('id',$val->postedby)->first();

                    $d['firstname'] = $val->firstname;
                    $d['lastname'] = $val->lastname;
                    $d['profileurl'] = $val->profileurl;
                    $arr[] = $d;
                }

                $res['status'] = "true";
                $res['data'] = $arr;
                
                return response($res, 200);

            }else{

                $newsfeeds['data'] = DB::table('newsfeeds')
                    ->join('users', 'newsfeeds.postedby', '=', 'users.id')
                    ->select('newsfeeds.id','newsfeeds.postedby','newsfeeds.category','newsfeeds.headline','newsfeeds.post','newsfeeds.imageurl','newsfeeds.partnerid','newsfeeds.type','newsfeeds.created_at','newsfeeds.viewstatus','users.firstname','users.lastname','users.profileurl')
                    ->where('newsfeeds.viewstatus' ,'public')
                    ->skip($start)
                    ->take($limit)
                    ->orderBy('newsfeeds.created_at','DESC')
                    ->get();
                $newsfeeds['status'] = "true";
                return response($newsfeeds, 200);

            }


        }else{
            $newsfeeds['status'] = "false";
            return response($newsfeeds, 200);
        }


    }

    public function get_my_news_feeds(Request $request){


        //Getting the page number which is to be displayed
        $page = $request->input('page');

        //Initially we show the data from 1st row that means the 0th row
        $start = 0;

        //Limit is 2 that means we will show 2 items at once
        $limit = 10;

        $total = count(DB::table('newsfeeds')->get());

        //We can go atmost to page number total/limit
        $page_limit = $total/$limit;

        //If the page number is more than the limit we cannot show anything
        //if($page<=$page_limit){
        if($page != 0){
            //Calculating start for every given page number
            $start = ($page - 1) * $limit;

            //dd($start);

            //$newsfeeds = DB::table('newsfeeds')->get();

            /* $newsfeeds = DB::select('SELECT n.*,u.firstname,u.lastname,u.profileurl
                                FROM newsfeeds AS n
                                INNER JOIN friends AS f
                                    ON (n.postedby = f.friend_id) OR (n.postedby = f.user_id)
                                JOIN users AS u
                                  ON n.postedby = u.id
                                UNION ALL
                                SELECT n.*,u.firstname,u.lastname,u.profileurl
                                FROM newsfeeds AS n
                                JOIN users AS u
                                  ON n.postedby = u.id
                                WHERE n.postedby = '.$request->input('user_id').'
                                AND n.viewstatus<>"me"
                                ORDER BY `created_at` DESC
                                LIMIT '.$limit.' OFFSET '.$start.' '); */

            $newsfeeds = DB::table('newsfeeds')
                    ->join('users', 'newsfeeds.postedby', '=', 'users.id')
                    ->select('newsfeeds.*','newsfeeds.id','newsfeeds.postedby','newsfeeds.category','newsfeeds.headline','newsfeeds.post','newsfeeds.imageurl','newsfeeds.partnerid','newsfeeds.type','newsfeeds.created_at','newsfeeds.viewstatus','users.firstname','users.lastname','users.profileurl')
                    ->where('newsfeeds.viewstatus', '!=' ,'me')
                    ->where('newsfeeds.postedby', '=' ,$request->input('user_id'))
                    ->skip($start)
                    ->take($limit)
                    ->orderBy('newsfeeds.created_at','DESC')
                    ->get();

            if(!empty($newsfeeds)){

                $arr = array();
                foreach($newsfeeds as $val){
                    $d['id'] = $val->id;

                    $tot_likes = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','1')->count('user_id');
                    $tot_unlikes = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','3')->count('user_id');
                    $tot_likescount = $tot_likes - $tot_unlikes;
                    
                    if ($tot_likescount < 0) {
                        $d['tot_likes'] = 0; 
                    }else{
                        $d['tot_likes'] = $tot_likescount;
                    }

                    $d['tot_comment_count'] = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','2')->count('user_id');

                    
                    $check = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('user_id','=',$request->input('user_id'))->orderBy('id','DESC')->first();
                    if(!empty($check)){
                        $type = $check->type;
                        if($type == 1){
                            $d['like_status'] = 'like';
                        }else{
                            $d['like_status'] = 'unlike';
                        }
                    }else{
                        $d['like_status'] = '';
                    }

                    $d['postedby'] = $val->postedby;
                    $d['category'] = $val->category;
                    $d['headline'] = $val->headline;
                    $d['post'] = $val->post;
                    $imageurl = $val->imageurl;
                    $imageurl = str_ireplace("/core","",$imageurl);
                    $d['imageurl'] = $imageurl;
                    $d['partnerid'] = $val->partnerid;
                    $d['type'] = $val->type;
                    $d['created_at'] = $val->created_at;
                    $d['viewstatus'] = $val->viewstatus;
                    $d['updated_at'] = $val->updated_at;
                    $d['firstname'] = $val->firstname;
                    $d['lastname'] = $val->lastname;
                    $d['profileurl'] = $val->profileurl;
                    $arr[] = $d;
                }

                $res['status'] = "true";
                $res['data'] = $arr;
                
                return response($res, 200);

            }else{

                $newsfeeds['data'] = DB::table('newsfeeds')
                    ->join('users', 'newsfeeds.postedby', '=', 'users.id')
                    ->select('newsfeeds.id','newsfeeds.postedby','newsfeeds.category','newsfeeds.headline','newsfeeds.post','newsfeeds.imageurl','newsfeeds.partnerid','newsfeeds.type','newsfeeds.created_at','newsfeeds.viewstatus','users.firstname','users.lastname','users.profileurl')
                    ->where('newsfeeds.viewstatus' ,'public')
                    ->skip($start)
                    ->take($limit)
                    ->orderBy('newsfeeds.created_at','DESC')
                    ->get();
                $newsfeeds['status'] = "true";
                return response($newsfeeds, 200);

            }


        }else{
            $newsfeeds['status'] = "false";
            return response($newsfeeds, 200);
        }


    }

    public function get_all_users(Request $request){
        $user = $request->input('user_id');
        $friends = DB::table('friends')
            ->select('user_id','friend_id')
            ->where('status','!=','reject')
            ->whereRaw("(user_id = '".$user."' OR friend_id = '".$user."')")
            ->get();


        $ttry1[] = $user;
        $ttry2[] = $user;
        foreach($friends as $key){
            $ttry1[] = $key->user_id;
            $ttry2[] = $key->friend_id;
        }

        $ttry = array_merge($ttry1,$ttry2);
        //print_r($ttry);
        //dd($ttry);

        if (!empty($ttry)) {
            $allusers['data'] = DB::table('users')
            ->select('id', 'firstname', 'lastname', 'profileurl')
            ->where('roleId', "3")
            ->whereNotIn('id', $ttry)
            ->orderBy('firstname', 'ASC')
            ->get();
        }else{
            $allusers['data'] = DB::table('users')
            ->select('id', 'firstname', 'lastname', 'profileurl')
            ->where('roleId', "3")
            ->orderBy('firstname', 'ASC')
            ->get();
        }

        //$allusers['data'] = [];
        //dd($allusers);

        return response($allusers, 200);
    }

    public function send_notification (Request $request)
    {
        $message = array("message" => " FCM PUSH NOTIFICATION TEST MESSAGE");
        $tokens = $request->input('tokken');
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' =>  array($tokens),
            'data' => $message
        );

        $headers = array(
            'Authorization:key = AAAA-MWEEcY:APA91bHqeBOzuzAoT9Al6uhfG5GirTZWGvE9VaFRSeqpbSrcCOcY15z9guuIQ9zlWwbD-LUNmlDcXWUe_ABkOwuzWBi_19Z9i3u5ctPNEkm6lNReMe-tQD_faDn5SpxQWpKNtMc21F9H',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function add_friend_request(Request $request){

        $user = DB::table('users')->select('firstname','lastname')->where('id',$request->input('user_id'))->get();

        $username = $user[0]->firstname." ".$user[0]->lastname;

        //dd($username);

        $friend_token = DB::table('users')->select('fcm_tokken')->where('id',$request->input('friend_id'))->get();


        $user_token = $friend_token[0]->fcm_tokken;
        $header = "Friend Request";
        $msg = "You have new friend request from ".$username;
        $data = ["intent"=> "friendrequest"];

        //dd($friend_token[0]->fcm_tokken);

        $date_current = date('Y-m-d H:i:s');

        $dbdata = array(
            'user_id' => $request->input('user_id'),
            'friend_id' => $request->input('friend_id'),
            'status' => "pending",
            'created_at' => $date_current
        );

        $addfriend = DB::table('friends')->insertGetId($dbdata);

        if(!is_null($addfriend)){

            $response = json_encode(["status"=>"success"]);
            if (!empty($user_token)) {
                //$this->send_one_signal_user($user_token, $msg, $header, $data);
                $this->sendPuchNotification("Android", $user_token, $msg,'0',"", "Pulse", "");
            }
            return response($response, 200);
        }
    }

    public function sendPuchNotification($deviceType="Android", $deviceToken, $notificationText,$totalNotifications='0',$pushMessageText="", $title="Pulse", $imageName="") {
        $fields = "notificationId";
        $devicetoken[] = $deviceToken;
        $desc = $notificationText;

        $type = 'api';
        if(!empty($pushMessageText)){
            $type = $pushMessageText;
        }

        // Set POST variables 
        $url = 'https://fcm.googleapis.com/fcm/send';
        $message = array("message" => $desc, 'title' => $title, 'click_action' => "FLUTTER_NOTIFICATION_CLICK", 'status' => 'done');
        
        $notificationArray = array(
            'badge' => $totalNotifications,
            'body' => $desc,
            'sound' => 'default',
            'title' => $title,
        );

        if ($deviceType == 'Iphone') {
            $fieldsJson =  '{"to":"'.$deviceToken.'","content_available": true,"mutable_content":true,"priority":"high","data":{"body":"'.$notificationText.'","sound":true,"title":"'.$title.'","click_action":"FLUTTER_NOTIFICATION_CLICK","priority":"high"},"notification":{"body":"'.$notificationText.'","sound":true,"title":"'.$title.'","click_action":"FLUTTER_NOTIFICATION_CLICK","priority":"high"}}';
        }else{
            $fieldsJson =  '{"to":"'.$deviceToken.'","content_available": true,"mutable_content":true,"priority":"high","data":{"body":"'.$notificationText.'","sound":true,"title":"'.$title.'","click_action":"FLUTTER_NOTIFICATION_CLICK","priority":"high"}}';
        }
        
        $headers = array(
            'Authorization: key='.env('GOOGLE_API_KEY'),
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsJson);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        /* echo $fieldsJson; 
        echo "<br>";
        echo $result;
        exit; */
        
        return $result;
    }

    public function forgot_paasword_sms_check(Request $request){

        $validator =Validator::make($request->all(),[
            'phone'=>'required|string',
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else{

            $user = User::where('phone', $request->phone)->first();
            if (!empty($user)) {

                $phone = $request->phone;
                $code = rand ( 111111 , 999999 );
                $message = "Your verification code is ".$code;

                $smsbaseurl = "http://portal.bulksmsweb.com/index.php?app=ws&u=astrocredit&h=6b46a270fc77b3bc63c9ed6863e4635e&op=pv&" ."to=".urlencode(str_replace("+","",$phone))."&msg=".$message;
                $getOtp = Http::post($smsbaseurl)->body();

                $dbdata = array(
                    'otp' =>$code
                );
                User::where('id', $user['id'])->update($dbdata);

                $response = ["data"=> $user['id'],"status"=>"success"];
                return response($response, 200);


            }else{
                $response = ["message" =>'User does not exist',"status"=>"error"];
                return response($response, 200);
            }
        }

    }

    public function otp_verify(Request $request){
        $validator =Validator::make($request->all(),[
            'user_id'=>'required',
            'otp' => 'required',
        ]);
        
        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else{
            $user = User::where('id', $request->user_id)->where('otp', $request->otp)->first();
            if (empty($user)) {
                $response = ["message" =>'OTP does not match! Please try again!',"status"=>"error"];
                return response($response, 200);
            } else {
                $response = ["id"=> $user['id'],"status"=>"success"];
                return response($response, 200);
            }
        }
    }

    public function forgot_paasword_email_check(Request $request){

        $validator =Validator::make($request->all(),[
            'email'=>'required|string',
        ]);

        /* $logs = array(
            "user_id" => '0',
            "api_name" => 'forgot_paasword_email_check',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else{

            $user = User::where('email', $request->email)->first();
            if (!empty($user)) {

                $response = ["data"=> $user->id,"status"=>"success"];

                $code = rand ( 111111 , 999999 );

                $maildata = ['email' => $request->input('email'), 'name' => $user->firstname." ".$user->lastname,'code'=> $code];

//                $dbdata = array(
//                    'password' => bcrypt($request->password)
//                );
//
//
//                $user = User::where('id', $request->user_id)->update($dbdata);
                $dbdata = array(
                    'otp' =>$code
                );
                $user = User::where('id', $user['id'])->update($dbdata);

                Mail::send('mail.resetpassword', ['md' => $maildata], function ($msg) use ($maildata) {
                    $msg->from(env('MAIL_USERNAME'), "Pulse Health");
                    $msg->to($maildata['email']);
                    $msg->subject('Password Reset');
                });

                return response($response, 200);


            }else{
                $response = ["message" =>'User does not exist',"status"=>"error"];
                return response($response, 200);
            }
        }

    }

    public function change_paasword(Request $request){
        $validator =Validator::make($request->all(),[
            'user_id'=>'required|string',
            'password'=>'required|string',
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else{

            $dbdata = array(
                'password' => bcrypt($request->password)
            );


            $user = User::where('id', $request->user_id)->update($dbdata);
            if (!is_null($user)) {

                $response = ["status"=>"success"];
                return response($response, 200);


            }else{
                $response = ["message" =>'Failed to change password',"status"=>"error"];
                return response($response, 200);
            }
        }
    }

    public function accept_friend_request(Request $request){

        $id = $request->input('id');
        $date_current = date('Y-m-d H:i:s');
        $dbdata = array(
            'status' => "active",
            'updated_at' => $date_current
        );

        $accept_req = DB::table('friends')->where('id',$id)->update($dbdata);

        $result = DB::table('friends')->where('id',$id)->first();
        $user_id = $result->user_id;
        $friend_id = $result->friend_id;

        $friend = User::where('id', $friend_id)->first();
        $friend_name = $friend->firstname.' '.$friend->firstname;
        
        $user = User::where('id', $user_id)->first();
        $fcm_tokken = $user->fcm_tokken;
        
        $msg = $friend_name. " accept your friend request.";
        $this->sendPuchNotification("Android", $fcm_tokken, $msg,'0',"", "Pulse", "");

        $response = ['authToken' => "Yo","status"=>"success","message"=>"Request accept successfully!"];
        return response($response, 200);

    }

    public function reject_friend_request(Request $request){

        $id = $request->input('id');
        $date_current = date('Y-m-d H:i:s');
        $dbdata = array(
            'status' => "reject",
            'updated_at' => $date_current
        );

        $accept_req = DB::table('friends')->where('id',$id)->update($dbdata);

        $response = ['authToken' => "Yo","status"=>"success","message"=>"Request reject successfully!"];
        return response($response, 200);

    }

    public function friend_request(Request $request){

        $userid = $request->input('user_id');

        $friendreq = DB::table('friends')
            ->join('users', 'friends.user_id', '=', 'users.id')
            ->select('friends.id','friends.created_at','friends.updated_at','users.firstname','users.lastname','users.profileurl')
            ->where('friends.friend_id',$userid)
            ->where('friends.status',"pending")
            ->get();
        $response['data'] = $friendreq;

        //dd($friendreq);

        //return response($response, 200);
        $response = ['authToken' => "Yo","status"=>"success","message"=>"list of data","data"=>$friendreq];
        return response($response, 200);




    }

    public function get_friend_list(Request $request){
        $userid = $request->input('user_id');

        //Getting the page number which is to be displayed
        $page = $request->input('page');

        //Initially we show the data from 1st row that means the 0th row
        $start = 0;

        //Limit is 2 that means we will show 2 items at once
        $limit = 10;

        $total = count(DB::select('SELECT u.id,u.firstname,u.lastname,u.profileurl,u.loyaltpoints FROM friends AS f
        JOIN users AS u
        ON f.friend_id = u.id OR f.user_id = u.id
        WHERE (f.user_id = '.$userid.' OR f.friend_id = '.$userid.')
        AND f.status = "active"'));

        //We can go atmost to page number total/limit
        $page_limit = $total/$limit;

        //if($page != 0){
            /* $friends = DB::select('SELECT u.id,u.firstname,u.lastname,u.profileurl,u.loyaltpoints FROM friends AS f
            JOIN users AS u
            ON f.friend_id = u.id OR f.user_id = u.id
            WHERE (f.user_id = '.$userid.' OR f.friend_id = '.$userid.')
            AND f.status = "active"'); */

            $friends = DB::select('SELECT u.id,u.firstname,u.lastname,u.profileurl,u.loyaltpoints FROM friends AS f
            JOIN users AS u
            ON f.friend_id = u.id OR f.user_id = u.id
            WHERE (f.user_id = '.$userid.' OR f.friend_id = '.$userid.') AND f.status = "active"');
            
            if (!empty($friends)){
                $respond['data'] = $friends;
                return response($respond, 200);

            }else{
                $respond['data'] = null;
                return response($respond, 200);
            }
        /* }else{
            $newsfeeds['status'] = "false";
            return response($newsfeeds, 200);
        } */


    }

    public function send_one_signal(){

        $data = ["intent"=> "specailthanks"];
        //
        //770d2e1c-4da5-4927-aec9-c96567ebe3fb Trynos

        //d167823c-3260-4cdd-8e19-ee0248f795cc Daina
        $this->send_one_signal_user("770d2e1c-4da5-4927-aec9-c96567ebe3fb","Your Highness , thank you for using Pulse Health App.","Special Thanks",$data);

        return response("Ndatumira", 200);
    }

    public function send_one_signal_user($id,$msg,$heaeder,$data){
        // OneSignal::sendNotificationToAll(
        //     "Test Test Notification",
        //     $url = null,
        //     $data = null,
        //     $buttons = null,
        //     $schedule = null
        // );

        // OneSignal::sendNotificationToExternalUser(
        //     "Trynos Test Notification",
        //     "770d2e1c-4da5-4927-aec9-c96567ebe3fb",
        //     $url = null,
        //     $data = null,
        //     $buttons = null,
        //     $schedule = null
        // );

        $userId = $id;
        $params = [];
        $params['include_player_ids'] = [$userId];
        $contents = [
            "en" => $msg
        ];
        $params['headings'] = [
            "en" => $heaeder
        ];
        $params['contents'] = $contents;
        $params['data'] = $data;
        $params['small_icon'] = 'logo_now'; // icon res name specified in your app
        $params['android_accent_color'] = '7CBE31';
        //$params['delayed_option'] = "timezone"; // Will deliver on user's timezone
        // $params['delivery_time_of_day'] = "3:30PM"; // Delivery time

        //dd($userId);
        if (!is_null($userId)){
            OneSignal::sendNotificationCustom($params);
            return true;
        }else{
            return true;
        }






    }


    public function send_email_test(Request $request){
        $code = rand ( 000000 , 999999 );

        $maildata = ['email' => $request->input('email'), 'name' => $request->name,'code'=> $code];
//        try {

        $res =   Mail::send('mail.welcome', ['md' => $maildata], function ($msg) use ($maildata) {
            $msg->from(env('MAIL_USERNAME'), "Pulse Health");
            $msg->to($maildata['email']);
            $msg->subject('Password Reset');
        });

//        }catch (\Exception $e){
//            $res = false;
//        }

        //n3fBFC3spWsAUM9
        return response(["response"=>$res],200);
    }


    public function add_profile_pic(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'uploaded_file' => 'required|max:15360|mimes:png,jpg,jpeg'
        ]);


        if ($validator->fails()) {

            $response = json_encode(array("status" => "false", "message" => "Failed!"));

            return response($response, 200);
        } else {

            if ($request->hasFile('uploaded_file')) {
                $path = $request->file('uploaded_file')->store('pulsehealth/images', 's3');
                
                Storage::disk('s3')->setVisibility($path, 'public');

                $fullpath = Storage::disk('s3')->url($path);
                $fullpath = str_ireplace("/core","", $fullpath);

                $image = [
                    'filename' => basename($path),
                    'url' => $fullpath
                ];

                //$res = json_encode(array( "status" => "true","message" => "Successfully file added!" , "data" => $image) );

                //return response($res, 200);
                $data = array(
                    'profileurl' => $fullpath,
                );


                $user = DB::table('users')->where('id',$request->input('user_id'))->update($data);


                if (!is_null($user)) {

                    $response = json_encode(array("status" => "true", "message" => "Successfully file added!", "data" => $image,"url" => $fullpath));

                    return response($response, 200);
                }else{
                    $response = json_encode(array("status" => "false", "message" => "Failed!"));
                    return response($response, 200);
                }
            } else {
                //return response(["status"=> "error"], 200);
                $response = json_encode(array("status" => "false", "message" => "Failed!"));
                return response($response, 200);
            }


        }

    }

    public function add_new_feed(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'post_type' => 'required|string',
            'uploaded_file' => 'max:153600|mimes:png,jpg,jpeg,mp4,3gp,mkv'
        ]);

    	$logs = array(
            "user_id" => '0',
            "api_name" => 'add_new_feed',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs);
    
        if ($validator->fails()) {

            $response = json_encode(array("status" => "false", "message" => "Failed!"));

            return response($response, 200);
        } else {

            $date_current = date('Y-m-d H:i:s');

            if ($request->hasFile('uploaded_file')) {
                $path = $request->file('uploaded_file')->store('pulsehealth/images', 's3');

                Storage::disk('s3')->setVisibility($path, 'public');

                $data = array(
                    'postedby'=> $request->user_id,
                    'type'=> $request->post_type,
                    'post'=> $request->post_desc ,
                    'imageurl'=> Storage::disk('s3')->url($path) ,
                    'created_at' =>$date_current,
                    'headline'=> $request->post_category,
                    'category' => $request->post_category,
                    'viewstatus' =>$request->post_privacy

                );

                $post = DB::table('newsfeeds')->insertGetId($data);

                if (!is_null($post)) {

                    $response = json_encode(array("status" => "true", "message" => "Successfully created feed", "data" => $request->all()));

                    return response($response, 200);

                }else{

                    $response = json_encode(array("status" => "false", "message" => "Failed!"));

                    return response($response, 200);
                }

            }else{

                $data = array(
                    'postedby'=> $request->user_id,
                    'type'=> $request->post_type,
                    'post'=> $request->post_desc ,
                    'created_at' =>$date_current,
                    'headline'=> $request->post_category,
                    'category' => $request->post_category,
                    'viewstatus' =>$request->post_privacy

                );

                $post = DB::table('newsfeeds')->insertGetId($data);

                if (!is_null($post)) {

                    $response = json_encode(array("status" => "true", "message" => "Successfully created feed", "data" => $request->all()));

                    return response($response, 200);

                }else{

                    $response = json_encode(array("status" => "false", "message" => "Failed!"));

                    return response($response, 200);
                }

            }

        }

    }

    public function get_news_feeds_test2(Request $request){

        $page = $request->input('page');

        //Initially we show the data from 1st row that means the 0th row
        $start = 0;

        //Limit is 2 that means we will show 2 items at once
        $limit = 5;

        $total = count(DB::table('newsfeeds')->get());

        //We can go atmost to page number total/limit
        $page_limit = $total/$limit;

        //If the page number is more than the limit we cannot show anything


        //Calculating start for every given page number
        $start = ($page - 1) * $limit;

        $posts = DB::select('SELECT n.*,u.firstname,u.lastname,u.profileurl
                                FROM newsfeeds AS n
                                INNER JOIN friends AS f
                                    ON (n.postedby = f.friend_id AND f.user_id = '.$request->input('user_id').') OR (n.postedby = f.user_id AND f.friend_id = '.$request->input('user_id').')
                                JOIN users AS u
                                  ON n.postedby = u.id
                                UNION ALL
                                SELECT n.*,u.firstname,u.lastname,u.profileurl
                                FROM newsfeeds AS n
                                JOIN users AS u
                                  ON n.postedby = u.id
                                WHERE n.postedby = '.$request->input('user_id').'
                                AND n.viewstatus<>"me"
                                ORDER BY `created_at` DESC
                                ');
        dd($posts);

        foreach($posts as $post) {
            //get user of post
            dd($post->likes);
            //$post->user;
            //comments count
            // $post['commentsCount'] = count($post->comments);
            //likes count
            $post['likesCount'] = count($post->likes);
            //check if users liked his own post
            $post['selfLike'] = false;
            foreach ($post->likes as $like) {
                if ($like->user_id == 1) {
                    $post['selfLike'] = true;
                }
            }

        }




    }

    public function get_news_feeds_test(Request $request){


        //Getting the page number which is to be displayed
        $page = $request->input('page');

        //Initially we show the data from 1st row that means the 0th row
        $start = 0;

        //Limit is 2 that means we will show 2 items at once
        $limit = 5;

        $total = count(DB::table('newsfeeds')->get());

        //We can go atmost to page number total/limit
        $page_limit = $total/$limit;

        //If the page number is more than the limit we cannot show anything
        if($page<=$page_limit){

            //Calculating start for every given page number
            $start = ($page - 1) * $limit;

            //dd($start);

            //$newsfeeds = DB::table('newsfeeds')->get();

            $newsfeeds['data'] = DB::select('SELECT n.*,u.firstname,u.lastname,u.profileurl
                                FROM newsfeeds AS n
                                INNER JOIN friends AS f
                                    ON (n.postedby = f.friend_id AND f.user_id = '.$request->input('user_id').') OR (n.postedby = f.user_id AND f.friend_id = '.$request->input('user_id').')
                                JOIN users AS u
                                  ON n.postedby = u.id
                                UNION ALL
                                SELECT n.*,u.firstname,u.lastname,u.profileurl
                                FROM newsfeeds AS n
                                JOIN users AS u
                                  ON n.postedby = u.id
                                WHERE n.postedby = '.$request->input('user_id').'
                                AND n.viewstatus<>"me"
                                ORDER BY `created_at` DESC
                                LIMIT '.$limit.' OFFSET '.$start.' ');
            if(!empty($newsfeeds['data'])){

                $newsfeeds['status'] = "true";
                return response($newsfeeds, 200);

            }else{

                $newsfeeds['data'] = DB::table('newsfeeds')
                    ->join('users', 'newsfeeds.postedby', '=', 'users.id')
                    ->select('newsfeeds.id','newsfeeds.postedby','newsfeeds.category','newsfeeds.headline','newsfeeds.post','newsfeeds.imageurl','newsfeeds.partnerid','newsfeeds.type','newsfeeds.created_at','newsfeeds.viewstatus','users.firstname','users.lastname','users.profileurl')
                    ->where('newsfeeds.viewstatus' ,'public')
                    ->skip($start)
                    ->take($limit)
                    ->orderBy('newsfeeds.created_at','DESC')
                    ->get();
                $newsfeeds['status'] = "true";
                return response($newsfeeds, 200);

            }







        }else{
            $newsfeeds['status'] = "false";
            return response($newsfeeds, 200);
        }


    }

    public function dailyreadssync(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
        ]);

        /* $logs = array(
            "user_id" => $request->input('user_id'),
            "api_name" => 'dailyreadssync',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */


        if ($validator->fails()) {

            $response = json_encode(array("status" => "false", "message" => "Failed!"));

            return response($response, 200);
        } else {

            $checkdate = DB::table('dailystepcount')->where('date',$request->input('date'))->where('userid',$request->input('user_id'))->first();
          
            if (!is_null($checkdate)){

                if ($checkdate->loyalpoints < floor($request->input('points'))){
                    $points = $checkdate->loyalpoints + 0;
                    $newpoints = floor(floor($request->input('points')) - $checkdate->loyalpoints);

                }else{

                    $points = floor($request->input('points') );

                    $newpoints = floor(floor($request->input('points')) - $checkdate->loyalpoints);

                }

                $data = array(

                    "userid" => $request->input('user_id'),
                    "steps" => $request->input('steps'),
                    "distance" => $request->input('distance'),
                    "calories" => $request->input('kcal'),
                    "updated_at" => date("Y-m-d H:i:s"),

                );


                $updatereads = DB::table('dailystepcount')->where('date',$request->input('date'))->where('userid',$request->input('user_id'))->update($data);

                DB::table('dailystepcount')->where('date',$request->input('date'))->where('userid',$request->input('user_id'))->increment("loyalpoints",$newpoints);

                if (!is_null($updatereads)) {

                    User::where('id', $request->user_id)->increment("loyaltpoints",$newpoints);

                    $response = json_encode(array("status" => "true", "message" => $newpoints));

                    return response($response, 200);
                }else{
                    $response = json_encode(array("status" => "false", "message" => $points));

                    return response($response, 200);
                }


                $response = json_encode(array("status" => "true", "message" => $points));

                return response($response, 200);

            }else{

                $user = User::where('id', $request->user_id)->first();

                $insertdata = array(
                    "userid" => $request->input('user_id'),
                    "steps" => $request->input('steps'),
                    "distance" => $request->input('distance'),
                    "calories" => $request->input('kcal'),
                    "loyalpoints" => floor($request->input('points')),
                    "date" => $request->input('date'),
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),

                );

                $poi = floor($request->input('points'));
                //                $updata = array(
                //                    "loyaltpoints" => $poi
                //                );

                User::where('id', $request->user_id)->increment("loyaltpoints",$poi);
                //$updatepoints = DB::table('users')->where('id', $request->user_id)->update($updata);


                $daily = DB::table('dailystepcount')->insertGetId($insertdata);

                if (!is_null($daily)) {

                    $response = json_encode(array("status" => "true", "message" => "Successfully", "data" => $request->all()));

                    return response($response, 200);

                }else{

                    $response = json_encode(array("status" => "false", "message" => "Failed!"));

                    return response($response, 200);
                }

            }


        }

    }

    public function actsync(Request $request){

        // return response(json_encode($request->all()),200);

        $checkact = DB::table('activities')->where('date',$request->input('date'))->where('user_id',$request->input('user_id'))->first();
        if (!is_null($checkact)){
            return response(json_encode(["me"=> 90]),200);
        }else{

            $user = User::where('id',$request->input('user_id'))->first();
            $insertdata = array(
                "user_id" => $request->input('user_id'),
                "partner_id" => $user->partner_id,
                "steps" => $request->input('steps'),
                "distance" => $request->input('distance'),
                "calories" => $request->input('kcal'),
                "duration" => $request->input('duration'),
                "pace" => $request->input('pace'),
                "activity" => $request->input('type'),
                "route" => $request->input('route'),
                "map_image_url" => $request->input('map_pic'),
                "user_image_url" => $request->input('pic'),
                "date" => $request->input('date'),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),

            );

            $act_now = DB::table('activities')->insertGetId($insertdata);
            return response(json_encode(["me" => $insertdata]), 200);



            if (!is_null($act_now)) {

                return response(json_encode(["me" => $insertdata]), 200);
            }
        }

    }

    public function getAllCorporates(Request $request){

        //$usercoins = DB::table('users')->where("id",$request->input('user_id'))->select('loyaltpoints')->get();

        //dd($usercoins[0]->loyaltpoints);

        $corporates = DB::table('users')->select('id','name','registrationNumber','directorName')->where('role','corporate')->where('status','active')->get();

        /* $response = ['corporates' => $corporates, 'authToken' => "Yo","status"=>"success"];
        return response($corporates, 200); */

        $response = json_encode(array("status" => "true", "message" => "Successfully", "data"=>$corporates));
        return response($response, 200);

    }

    public function getAllTransactions(Request $request){

        //$usercoins = DB::table('users')->where("id",$request->input('user_id'))->select('loyaltpoints')->get();

        //dd($usercoins[0]->loyaltpoints);

        $transactions = DB::table('transactions')
        ->join('users', 'transactions.user_id', '=', 'users.id')
        ->join('rewards', 'transactions.reward_id', '=', 'rewards.id')
        ->select('transactions.*','rewards.id','rewards.partner_id','rewards.reward_name','rewards.amount','rewards.pulse_points','rewards.description','rewards.imageurl','users.name')
        ->where("transactions.user_id",$request->input('user_id'))->orderBy('transactions.id','DESC')->get()->toArray();
        
        // foreach ($transactions as $transaction){ 
        //     print_r($transaction)
        // }

        $response = ['data' => $transactions, 'authToken' => "Yo","status"=>"success"];
        return response($response, 200);
    }

    public function getFeedDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'feed_id' => 'required'
        ]);

        /* $logs = array(
            "user_id" => $request->input('user_id'),
            "api_name" => 'getFeedDetails',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */
        
        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $feed_id = $request->feed_id;
            if (isset($request->user_id)) {
                $user_id = $request->user_id;
            }else{
                $user_id = 0;
            }

            if(isset($request->type)){
                $type = $request->type;
                if($type == 'like'){
                    $type = 1;
                }else if($type == 'unlike'){
                    $type = 3;
                }else{
                    $type = 2;
                }

                if($type == 2){
                    $comments = DB::table('newsfeed_activities')
                    ->join('users', 'newsfeed_activities.user_id', '=', 'users.id')
                    ->select('newsfeed_activities.id', 'newsfeed_activities.comments', 'newsfeed_activities.user_id', 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl', 'newsfeed_activities.comment_id', 'newsfeed_activities.type', 'newsfeed_activities.created_at', DB::raw("(SELECT type FROM newsfeed_activities ORDER BY id DESC LIMIT 1) as last_type"))
                    ->where('newsfeed_activities.feed_id', '=', $feed_id)
                    ->where('newsfeed_activities.type', '=', $type)
                    /* ->having('last_type', '=', 1) */
                    //->groupBy('newsfeed_activities.type','newsfeed_activities.user_id')
                    ->get();
                }else{
                    $comments = DB::table('newsfeed_activities')
                    ->join('users', 'newsfeed_activities.user_id', '=', 'users.id')
                    ->select('newsfeed_activities.id', 'newsfeed_activities.comments', 'newsfeed_activities.user_id', 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl', 'newsfeed_activities.comment_id', 'newsfeed_activities.type', 'newsfeed_activities.created_at', DB::raw("(SELECT type FROM newsfeed_activities ORDER BY id DESC LIMIT 1) as last_type"))
                    ->where('newsfeed_activities.feed_id', '=', $feed_id)
                    ->where('newsfeed_activities.type', '=', $type)
                    ->whereRaw("newsfeed_activities.id IN (SELECT MAX(id) FROM newsfeed_activities GROUP BY user_id)")
                    /* ->having('last_type', '=', 1) */
                    //->groupBy('newsfeed_activities.type','newsfeed_activities.user_id')
                    ->get();
                    if($comments->isEmpty()){
                        $comments = DB::table('newsfeed_activities')
                        ->join('users', 'newsfeed_activities.user_id', '=', 'users.id')
                        ->select('newsfeed_activities.id', 'newsfeed_activities.comments', 'newsfeed_activities.user_id', 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl', 'newsfeed_activities.comment_id', 'newsfeed_activities.type', 'newsfeed_activities.created_at', DB::raw("(SELECT type FROM newsfeed_activities ORDER BY id DESC LIMIT 1) as last_type"))
                        ->where('newsfeed_activities.feed_id', '=', $feed_id)
                        ->where('newsfeed_activities.type', '=', $type)
                        ->get();
                    }
                }

                /* print_r($comments);
                exit; */
                
            }else{
                $comments = DB::table('newsfeed_activities')
                ->join('users', 'newsfeed_activities.user_id', '=', 'users.id')
                ->select('newsfeed_activities.id','newsfeed_activities.comments','newsfeed_activities.user_id','users.name as username','users.firstname','users.lastname','users.profileurl','newsfeed_activities.comment_id','newsfeed_activities.type','newsfeed_activities.created_at', DB::raw("(SELECT type FROM newsfeed_activities ORDER BY id DESC LIMIT 1) as last_type"))
                ->where('newsfeed_activities.feed_id','=',$feed_id)->get();
            }

            $tot_unlikes = DB::table('newsfeed_activities')->where('feed_id','=',$feed_id)->where('type','=','3')->count();
            $tot_likes = DB::table('newsfeed_activities')->where('feed_id','=',$feed_id)->where('type','=','1')->count();
            $tot_comments = DB::table('newsfeed_activities')->where('feed_id','=',$feed_id)->where('type','=','2')->count();
            
            //$tot_likescount = $tot_likes - $tot_unlikes;
            $tot_likescount = $tot_likes - $tot_unlikes;
            $tot_likes = ($tot_likescount < 0) ? 0 : $tot_likescount;
            
            $arr = array();
            if(!empty($comments)){
                foreach($comments as $val){

                    /* $lastactivityRecord = DB::table('newsfeed_activities')
                    ->select('newsfeed_activities.id', 'newsfeed_activities.type')
                    ->where('newsfeed_activities.feed_id', '=', $feed_id)
                    ->where('newsfeed_activities.user_id', '=', $val->user_id)
                    ->orderBy('newsfeed_activities.id','DESC')
                    ->first();

                    if($lastactivityRecord->type == 1){ */
                        
                        $d['id'] = $val->id;
                        $d['comments'] = ($val->comments==null)?"":$val->comments;
                        $d['user_id'] = $val->user_id;
                        $d['username'] = $val->username;
                        $d['firstname'] = $val->firstname;
                        $d['lastname'] = $val->lastname;
                        $d['comment_id'] = $val->comment_id;
                        if ($val->type == '1') {
                            $d['type'] = 'like';
                        } elseif ($val->type == '3') {
                            $d['type'] = 'unlike';
                        } else {
                            $d['type'] = 'comment';
                        }

                        $tot_likes_count = DB::table('newsfeed_comment_activities')->where('comment_id', '=', $val->id)->where('type', '=', '1')->where('feed_id', $feed_id)->count('id');
                        $tot_unlikes_count = DB::table('newsfeed_comment_activities')->where('comment_id', '=', $val->id)->where('type', '=', '3')->where('feed_id', $feed_id)->count('id');

                        $tot_l = $tot_likes_count -  $tot_unlikes_count;
                        //$tot_likes_d = ($tot_likes_count < 0) ? 0 : $tot_unlikes_count;
                        if ($tot_l < 0) {
                            $tot_likes_d = 0;
                        } else {
                            $tot_likes_d = $tot_l;
                        }

                        $d['tot_likes'] = $tot_likes_d;
                        $d['tot_unlikes'] = DB::table('newsfeed_comment_activities')->where('comment_id', '=', $val->id)->where('type', '=', '3')->where('feed_id', $feed_id)->count('id');
                        $d['tot_comments'] = DB::table('newsfeed_comment_activities')->where('comment_id', '=', $val->id)->where('type', '=', '2')->where('feed_id', $feed_id)->count('id');

                        $d['created_at'] = $val->created_at;
                        $profileurl = $val->profileurl;
                        $profileurl = str_ireplace("/core", "", $profileurl);
                        $d['profileurl'] = $profileurl;

                        $sub_comments = DB::table('newsfeed_comment_activities')
                        ->join('users', 'newsfeed_comment_activities.user_id', '=', 'users.id')
                        ->select('newsfeed_comment_activities.id', 'newsfeed_comment_activities.comments', 'newsfeed_comment_activities.user_id', 'users.name as username', 'newsfeed_comment_activities.id', 'users.profileurl', 'users.firstname', 'users.lastname', 'newsfeed_comment_activities.type', 'newsfeed_comment_activities.created_at')
                        /* ->where('newsfeed_comment_activities.root_comment_id','=',$val->id) */
                        ->whereRaw("(newsfeed_comment_activities.comment_id = '".$val->id."' OR newsfeed_comment_activities.root_comment_id = '".$val->id."')")
                        ->where('newsfeed_comment_activities.comments', '!=', '')
                        ->where('type', '=', '2')->get();

                        $arr_comm = array();
                        if (!empty($sub_comments)) {
                            foreach ($sub_comments as $r) {
                                $d1['id'] = $r->id;
                                $d1['comments'] = ($r->comments==null)?"":$r->comments;
                                $d1['user_id'] = $r->user_id;
                                $d1['username'] = $r->username;
                                $d1['firstname'] = $r->firstname;
                                $d1['lastname'] = $r->lastname;
                                $d1['created_at'] = $r->created_at;
                                $profileurl1 = $r->profileurl;
                                $profileurl1 = str_ireplace("/core", "", $profileurl1);
                                $d1['profileurl'] = $profileurl1;

                                $tot_likes1 = DB::table('newsfeed_comment_activities')->where('comment_id', '=', $r->id)->where('type', '=', '1')->where('feed_id', $feed_id)->count('id');
                                $tot_unlikes1 = DB::table('newsfeed_comment_activities')->where('comment_id', '=', $r->id)->where('type', '=', '3')->where('feed_id', $feed_id)->count('id');
                                
                                $tot_likes1_c = $tot_likes1 - $tot_unlikes1;

                                if ($tot_likes1_c < 0) {
                                    $tot_likes1_c1 = 0;
                                } else {
                                    $tot_likes1_c1 = $tot_likes1_c;
                                }
                                //$tot_likes1_c1 = ($tot_likes1_c < 0) ? 0 : $tot_likes1_c;

                                $d1['tot_likes1'] = $tot_likes1;
                                $d1['tot_likes'] = $tot_likes1_c1;
                                $d1['tot_unlikes'] = $tot_unlikes1;
                                $d1['tot_comments'] = DB::table('newsfeed_comment_activities')->where('comment_id', '=', $r->id)->where('type', '=', '2')->where('feed_id', $feed_id)->count('id');

                                $user_id = $request->input('user_id');
                                if (isset($user_id) && !empty($user_id)) {
                                    $check = DB::table('newsfeed_comment_activities')->where('comment_id', '=', $r->id)->where('user_id', '=', $request->input('user_id'))->orderBy('newsfeed_comment_activities.id','DESC')->first();
                                    if (!empty($check)) {
                                        $type = $check->type;
                                        if ($type == 1) {
                                            $d1['like_status'] = 'Yes';
                                        } else {
                                            $d1['like_status'] = 'No';
                                        }
                                    } else {
                                        $d1['like_status'] = 'No';
                                    }
                                } else {
                                    $d1['like_status'] = 'No';
                                }

                                $arr_comm[] = $d1;
                            }
                        }
                        $d['comments_arr'] = $arr_comm;

                        $sub_likes = DB::table('newsfeed_comment_activities')
                        ->join('users', 'newsfeed_comment_activities.user_id', '=', 'users.id')
                        ->select('newsfeed_comment_activities.id', 'newsfeed_comment_activities.comments', 'newsfeed_comment_activities.user_id', 'users.name as username', 'newsfeed_comment_activities.id', 'users.profileurl', 'users.firstname', 'users.lastname', 'newsfeed_comment_activities.type', 'newsfeed_comment_activities.created_at')
                        ->where('newsfeed_comment_activities.comment_id', '=', $val->id)
                        ->where('type', '=', '1')->get();

                        $like_status = 'No';
                        $arr_likes = array();
                        if (!empty($sub_likes)) {
                            foreach ($sub_likes as $rec) {
                                $d2['id'] = $rec->id;
                                $d2['user_id'] = $rec->user_id;
                                $d2['username'] = $rec->username;
                                $d2['firstname'] = $rec->firstname;
                                $d2['lastname'] = $rec->lastname;
                                $d2['created_at'] = $rec->created_at;
                                $profileurl1 = $rec->profileurl;
                                $profileurl1 = str_ireplace("/core", "", $profileurl1);
                                $d2['profileurl'] = $profileurl1;
                                $d2['like_status'] = '';
                                $arr_likes[] = $d2;
                            }
                        }

                        $checkLastActivity = DB::table('newsfeed_comment_activities')
                        ->join('users', 'newsfeed_comment_activities.user_id', '=', 'users.id')
                        ->select('newsfeed_comment_activities.id', 'newsfeed_comment_activities.comments', 'newsfeed_comment_activities.user_id', 'users.name as username', 'newsfeed_comment_activities.id', 'users.profileurl', 'users.firstname', 'users.lastname', 'newsfeed_comment_activities.type', 'newsfeed_comment_activities.created_at')
                        ->where('newsfeed_comment_activities.comment_id', '=', $val->id)
                        ->where('newsfeed_comment_activities.user_id', '=', $user_id)
                        ->orderBy('newsfeed_comment_activities.id', 'DESC')
                        ->first();

                        $like_status = 'No';
                        if (!empty($checkLastActivity)) {
                            if ($user_id == $checkLastActivity->user_id) {
                                $type = $checkLastActivity->type;
                                if ($type == 1) {
                                    $like_status = 'Yes';
                                } elseif ($type == 3) {
                                    $like_status = 'No';
                                }
                            }
                        }
                        $d['like_status'] = $like_status;

                        if (isset($request->type)) {
                            if ($val->type == 1) {
                                $like_status = 'Yes';
                            } elseif ($val->type == 3) {
                                $like_status = 'No';
                            }
                            $d['like_status'] = $like_status;
                        }

                        $d['likes_arr'] = $arr_likes;

                        $arr[] = $d;
                    //}
                }
            }

            $response = ['tot_likes' => $tot_likes, 'tot_unlikes'=>$tot_unlikes, 'tot_comments' => $tot_comments, 'data' => $arr, 'authToken' => "Yo","status"=>"success"];
            return response($response, 200);
        }
    }

    public function feedActivities(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required',
            'feed_id' => 'required'
        ]);

        /* $logs = array(
            "user_id" => $request->input('user_id'),
            "api_name" => 'feedActivities',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $feed_id = $request->feed_id;
            if ($request->type == 'like') {
                $type = '1';
            }elseif($request->type == 'unlike'){
                $type = '3';
            }else{
                $type = '2';
            }
            $comments = $request->comments;

            if(isset($request->comment_id)){
                $comment_id = $request->comment_id;
                $root_comment_id = $request->root_comment_id;
            }

            if(!isset($request->comment_id) && empty($request->comment_id)){
                $data['user_id'] = $user_id;
                $data['feed_id'] = $feed_id;
                $data['type'] = $type;
                if(isset($comments)){
                    $data['comments'] = $comments;
                }
                if(isset($request->comment_id)){
                    $data['comment_id'] = $comment_id;
                }
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['updated_at'] = date("Y-m-d H:i:s");    
                $post = DB::table('newsfeed_activities')->insertGetId($data);
            }else{
                $data['user_id'] = $user_id;
                $data['feed_id'] = $feed_id;
                $data['type'] = $type;
                if(isset($comments)){
                    $data['comments'] = $comments;
                }
                $data['comment_id'] = $comment_id;
                $data['root_comment_id'] = $root_comment_id;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['updated_at'] = date("Y-m-d H:i:s");    
                $post = DB::table('newsfeed_comment_activities')->insertGetId($data);
            }

            if (!is_null($post)) {
                $user = User::where('id', $user_id)->first();
                $username = $user->name;
                $post_title = DB::table('newsfeeds')->where('id',$feed_id)->first();
                $post_name = $post_title->post;
                //$fcm_tokken = 'eVFU2_hHQ2yS98BoABQYpM:APA91bHnL8KKx3KRIu9fl9IkwENx0xNUxFfckCcLeOBgEnJTLnZ07Qxxa-vSe2bdaZOE7sB6mmPTBESg03AUYX5zra-fSrcB-BPLoB76BCUbxPHPfknVSK1X7NQo6tySWurhbshZYWzT';//$user->fcm_tokken;
                $user->fcm_tokken = 'dbSz9_FHR1mdjeodOQLmOI:APA91bFOCTExyM5GDiTRuhc4SUDPELyouaM0u8sRRlFb6854wTNHGEgAJadWCIIb8oo8chiZH3F2Qbmsn67BZwYOmn8-_dmdd8efPeet1RH9UT5LhxS1vMh9HSIq-dMN1RsKZ16v4bBl';
                $fcm_tokken =$user->fcm_tokken;
                $msg = $username." Has Commented On Your Post - ".$post_name;
                $this->sendPuchNotification("Android", $fcm_tokken, $msg,'0',"", "Pulse", "");
                $response = json_encode(array("status" => "true", "message" => "Successfully addded $request->type"));
                return response($response, 200);
            }else{
                $response = json_encode(array("status" => "false", "message" => "Failed!"));
                return response($response, 200);
            }
        }
    }

    public function getSubscriptionPlans(Request $request){

        //$usercoins = DB::table('users')->where("id",$request->input('user_id'))->select('loyaltpoints')->get();

        //dd($usercoins[0]->loyaltpoints);

        $corporates = DB::table('subscription_plans')->get();

        //$response = ['data' => $corporates, 'authToken' => "Yo","status"=>"true"];
        $response = json_encode(array("status" => "true", "message" => "Successfully", "data"=>$corporates));
        return response($response, 200);
        //return response($corporates, 200);
    }

    public function getUserSubscriptionPlans(Request $request){

        $sub = DB::table('subscriptions')->where("user_id",$request->input('user_id'))->where('type','!=','trial')->orderBy('id','DESC')->first();
        if(!empty($sub)){
            $plan_id = $sub->plan_id;
            $status = $sub->status;
            /* if ($status != 'cancel') { */
                if (!empty($plan_id)) {
                    $corporates = DB::table('subscription_plans')->where('id', $plan_id)->get();
                    if (!empty($corporates)) {
                        $corporates[0]->expiry_date = date("d M Y", strtotime($sub->expire_date));
                        $corporates[0]->subscriptions_id = $sub->id;
                    }
                } else {
                    $corporates = array();
                }
            /* }else{
                $corporates = array();
            } */
        }else{
            $corporates = array();
        }
        
        $response = json_encode(array("status" => "true", "message" => "Successfully", "data"=>$corporates));
        return response($response, 200);
    }

    public function getDisease(Request $request){
        $disease = DB::table('disease')->get();
        $response = json_encode(array("status" => "true", "message" => "Successfully", "data"=>$disease));
        return response($response, 200);
    }

    public function getMyPlan(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $disease =  $token = DB::table('subscriptions')->where('user_id',$user_id)->orderBy('id','DESC')->first();
            
            $response = json_encode(array("status" => "true", "message" => "Successfully", "data"=>$disease));
            return response($response, 200);
        }
        
    }

    public function generateWellnessPlan(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        /* $logs = array(
            "user_id" => $request->input('user_id'),
            "api_name" => 'generateWellnessPlan',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $disease_id = $request->disease_id;

            $users = DB::table('users')->where('id','=', $user_id)->first();
            if(empty($users)){
                $response = json_encode(array("status" => "false", "message" => "You have select wrong user!"));
                return response($response, 200);
            }

            $dateOfBirth = date("d-m-Y", strtotime($users->dob));
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            //echo 'Your age is '.$diff->format('%y'); exit;

            $age = $diff->format('%y');
            $height = $users->height;
            $weight = $users->weight;
            $bmi = $users->bmi;

            $avg = $weight / ($height*$height);
            $avg = round($avg);

            if(isset($disease_id) && !empty($disease_id)){

                $disease_id = implode(",", $disease_id);
                
                if (count($request->disease_id) > 1) {
                    
                    $disease_wellness_plans = DB::table('disease_wellness_plans')->where('min_bmi', '<=', $bmi)->where('max_bmi', '>=', $bmi)->where('disease_id', $disease_id)->first();
                    //$wellness_plan_id = $disease_wellness_plans->wellness_plan_id;
                    if (!empty($disease_wellness_plans)) {
                        $wellness_plan_id = $disease_wellness_plans->wellness_plan_id;
                    }else{
                        $wellness_plan = DB::table('wellness_plans')->where('avg_weight_height_min', '<=', $bmi)->where('avg_weight_height_max', '>=', $bmi)->first();
                        $wellness_plan_id = $wellness_plan->id;
                    }
                    //$wellness_plan = DB::table('wellness_plans')->where('id', '=', $wellness_plan_id)->first();
                }else{
                    
                    $disease_wellness_plans = DB::table('disease_wellness_plans')->where('min_bmi', '<=', $bmi)->where('max_bmi', '>=', $bmi)->where('min_age', '<=', $age)->where('max_age', '>=', $age)->where('disease_id', $disease_id)->first();
                    if (!empty($disease_wellness_plans)) {
                        $wellness_plan_id = $disease_wellness_plans->wellness_plan_id;
                    }else{
                        $wellness_plan = DB::table('wellness_plans')->where('avg_weight_height_min', '<=', $bmi)->where('avg_weight_height_max', '>=', $bmi)->first();
                        $wellness_plan_id = $wellness_plan->id;
                    }

                    //$wellness_plan = DB::table('wellness_plans')->where('avg_weight_height_min', '<=', $bmi)->where('avg_weight_height_max', '>=', $bmi)->where('id', '=', $wellness_plan_id)->first();
                }
                
                $wellness_plan = DB::table('wellness_plans')->where('id', '=', $wellness_plan_id)->first();
                

            }else{
                //echo $bmi;
                $wellness_plan = DB::table('wellness_plans')->where('avg_weight_height_min', '<=', $bmi)->where('avg_weight_height_max', '>=', $bmi)->first();
                $wellness_plan_id = $wellness_plan->id;
            }
            
            $wellness_plan_details = DB::table('wellness_plan_details')->where('min_age','<=', $age)->where('max_age','>', $age)->where('wellness_plan_id',$wellness_plan_id)->first();
            
            $d['id'] = $wellness_plan_details->id;
            $d['plan_name'] = $wellness_plan->plan_name;
            $d['description'] = $wellness_plan_details->description;
            $d['steps'] = $wellness_plan_details->steps;
            $d['daily_distance'] = $wellness_plan_details->daily_distance;
            $d['calories_burnt'] = $wellness_plan_details->calories_burnt;
            $d['calories_burnt_calculation'] = $wellness_plan_details->calories_burnt_calculation;
            $d['frequency_of_activity'] = $wellness_plan_details->frequency_of_activity;
            $d['daily_calorie_intake'] = $wellness_plan_details->daily_calorie_intake;
            $d['daily_reminder'] = $wellness_plan_details->daily_reminder;
            $d['duration_of_exercise'] = $wellness_plan_details->duration_of_exercise;
            $d['participation_in_rigorous_school_sport'] = $wellness_plan_details->participation_in_rigorous_school_sport;
            $d['recommended_calorie_deficit'] = $wellness_plan_details->recommended_calorie_deficit;
            //$ = $d;
            
            $dataq = array(
                'status' => '0',
            );
            DB::table('user_wellness_plans')->where('user_id',$user_id)->update($dataq);

            $data['plan_data'] = json_encode($d);
            $data['status'] = '1';
            $data['user_id'] = $user_id;
            //$data['wellness_plan_id'] = $wellness_plan_id;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");  
            DB::table('user_wellness_plans')->insertGetId($data);
            
            $response = json_encode(array("status" => "true", "message" => "Plan Created Successfully."));
            return response($response, 200);
        }
    }

    public function getMyWellnessPlan(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $users = DB::table('users')->where('id','=', $user_id)->first();
            if(empty($users)){
                $response = json_encode(array("status" => "false", "message" => "You have select wrong user!"));
                return response($response, 200);
            }

            $age = $users->age;
            $height = $users->height;
            $weight = $users->weight;

            $avg = $weight / ($height*$height);
            $avg = round($avg);


            $wellness_plan = DB::table('wellness_plans')->where('avg_weight_height_min','<=', $avg)->where('avg_weight_height_max','>=', $avg)->first();
            $wellness_plan_id = $wellness_plan->id;

            $wellness_plan = DB::table('user_wellness_plans')->where('user_id','=', $user_id)->where('status','=', 1)->orderBy('id','DESC')->first();
            $plan_data = json_decode($wellness_plan->plan_data,true);
            
            $response = json_encode(array("status" => "true", "message" => "Successfully.","data"=>$plan_data));
            return response($response, 200);
        }
    }

    public function getFriends(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $search_text = $request->search_text;
            if(!empty($search_text)){
                $search = '%' . $request->get('search_text') . '%';
                $friends = DB::table('friends')
                    ->join('users', 'friends.friend_id', '=', 'users.id')
                    ->select('friends.id','friends.user_id','friends.friend_id','users.name as username','users.firstname','users.lastname','users.profileurl','friends.status')
                    ->where('friends.user_id','=',$user_id)->whereRaw("(users.name like " . "'" . $search . "' OR users.firstname like " . "'" . $search . "' OR users.lastname like " . "'" . $search . "')")->get();
            }else{
                $friends = DB::table('friends')
                ->join('users', 'friends.friend_id', '=', 'users.id')
                ->select('friends.id','friends.user_id','friends.friend_id','users.name as username','users.firstname','users.lastname','users.profileurl','friends.status')
                ->where('friends.user_id','=',$user_id)->get();
            }
            

            $response = json_encode(array("status" => "true", "message" => "Lists.", "data"=>$friends));
            return response($response, 200);
        }
    }

    

    public function deleteFeed(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'feed_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $feed_id = $request->feed_id;

            DB::table('newsfeeds')->where('postedby', '=', $user_id)->where('id', '=', $feed_id)->delete();
            $response = json_encode(array("status" => "true", "message" => "Feed deleted Successfully."));
            return response($response, 200);
        }
    }

    public function unfriend(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'friend_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $friend_id = $request->friend_id;

            //DB::table('friends')->where('user_id', '=', $friend_id)->orWhere('friend_id', '=', $user_id)->delete();
            
            DB::table('friends')
            ->whereRaw("(user_id = '".$user_id."' AND friend_id = '".$friend_id."') OR (user_id = '".$friend_id."' AND friend_id = '".$user_id."')")
            ->delete();

            $response = json_encode(array("status" => "true", "message" => "You have remove this friend to your contact."));
            return response($response, 200);
        }
    }

    public function addActivityDetails(Request $request){

        $validator =Validator::make($request->all(),[
            'user_id'=>'required',
            'act_id'=>'required',
            'steps'=>'required',
            'distance'=>'required',
            'kcals'=>'required',
            'avarage_heart_rate'=>'required',
            'avg_pace'=>'required',
            "activity" => 'required',
            'camera_file'=>'required'
        ]);


        /* $logs = array(
            "user_id" => $request->input('user_id'),
            "api_name" => 'addActivityDetails',
            "api_request" => json_encode($request->all()),
            "api_response" => 'NA',
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        );
        DB::table('api_logs')->insertGetId($logs); */

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else {
            
            $created_at = date("Y-m-d H:i:s");
            $updated_at = date("Y-m-d H:i:s");

            if ($request->get('camera_file')) {

                $file = $request->get('camera_file');
                $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$file));

                $pos  = strpos($file, ';');
                $type = explode(':', substr($file, 0, $pos))[1];
                $image_ext = explode('/', $type)[1];

                $document_file_name = rand('11111','99999').time() . '.'.$image_ext;
                $filePath = "pulsehealth/images/".$document_file_name;
                Storage::disk('s3')->put($filePath, $image);
                $fullpath = str_ireplace("/core","", $filePath);
            }else{
                $fullpath = "";
            }

            //$setgoal = DB::table('setgoal')->where('goalDate',$goalDate)->where('user_id',$request->input('user_id'))->first();

            /* if(empty($setgoal)){ */
                $data = array(
                    'user_id' => $request->input('user_id'),
                    'act_id' => $request->input('act_id'),
                    'steps' => $request->input('steps'),
                    'distance' => $request->input('distance'),
                    'kcals' => $request->input('kcals'),
                    'avarage_heart_rate' => $request->input('avarage_heart_rate'),
                    'avg_pace' => $request->input('avg_pace'),
                    'camera_file' => $fullpath,
                    'activity' => $request->input('activity'),
                    'duration' => $request->input('duration'),
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                );
                $insert = DB::table('activity_details')->insert($data);
                
                if (!is_null($insert)) {
                    $response = ["message" =>'Activity added successful',"status"=>"success"];
                    return response($response, 200);
                } else {
                    $response = ["message" =>'Error, please try again.',"status"=>"error"];
                    return response($response, 200);
                }
            /* } else {
                $response = ["message" =>'Goal already set.',"status"=>"error"];
                return response($response, 200);
            } */
        }
    }

    public function getActivityDetailsLists(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $date = date("Y-m-d");
            if (isset($request->activity)) {
                $activity = $request->activity;

                $friends = DB::table('activity_details')
                ->join('users', 'activity_details.user_id', '=', 'users.id')
                ->select('activity_details.*', 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl')
                ->where('activity_details.user_id', '=', $user_id)
                ->where('activity_details.activity', '=', $activity)
                ->whereRaw("DATE_FORMAT(activity_details.created_at, '%Y-%m-%d') = '".$date."'")
                ->orderBy('id', 'DESC')->get();
            }else{
                $friends = DB::table('activity_details')
                ->join('users', 'activity_details.user_id', '=', 'users.id')
                ->select('activity_details.*', 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl')
                ->where('activity_details.user_id', '=', $user_id)
                ->whereRaw("DATE_FORMAT(activity_details.created_at, '%Y-%m-%d') = '".$date."'")
                ->orderBy('id', 'DESC')->get();
            }

            $wellness_plan = DB::table('dailystepcount')
            ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'), DB::raw('SUM(loyalpoints) AS sum_of_loyalpoints'))
            ->where('userid', '=', $user_id)
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$date."'")
            ->whereNotNull('distance')
            ->first();
            
            if (!empty($wellness_plan)) {
                $distance = number_format($wellness_plan->sum_of_distance,2);
                $steps = number_format($wellness_plan->sum_of_steps,2);
                $calories = number_format($wellness_plan->sum_of_calories,2);
                $loyalpoints = number_format($wellness_plan->sum_of_loyalpoints,2);
            }else{
                $distance = "0.00";
                $steps = "0.00";
                $calories = "0.00";
                $loyalpoints = "0.00";
            }
            
            $wellness_plan_json['distance'] = (string)$distance;
            $wellness_plan_json['steps'] = (string)$steps;
            $wellness_plan_json['calories'] = (string)$calories;
            $wellness_plan_json['loyalpoints'] = (string)$loyalpoints;
            
            $response = json_encode(array("status" => "true", "message" => "Lists.", "data"=>$friends, "wellness_plan_data"=>$wellness_plan_json));
            return response($response, 200);
        }
    }

    /**
     * Get my friend list
     * Order by score
    */
    public function getMyFriendLists(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $date = date("Y-m-d");

            $friendlists = DB::table('friends')
            ->select('friends.friend_id','friends.user_id')
            ->whereRaw("(friends.user_id = '".$user_id."' OR friends.friend_id = '".$user_id."') AND friends.status = 'active'")
            ->get()->toArray();
            
            //print_r($friendlists);
            
            $fid = array();
            if (!empty($friendlists)) {
                foreach ($friendlists as $val) {
                    if($val->friend_id != $user_id){
                        $fid[] = $val->friend_id;
                    }else{
                        $fid[] = $val->user_id;
                    }
                }
            }
            /* print_r($fid);
            exit; */
            //print_r($fid);

            /* $friends = DB::table('friends')
                ->select('friends.friend_id','friends.user_id','dailystepcount.steps', DB::raw('SUM(dailystepcount.steps) AS sum_of_steps'))
                ->join('dailystepcount', 'friends.friend_id', '=', 'dailystepcount.userid')
                ->whereIn('friends.user_id', $fid)                
                ->whereRaw("DATE_FORMAT(dailystepcount.created_at, '%Y-%m-%d') = '".$date."'")
                ->orderBy('dailystepcount.steps', 'DESC')->groupBy('dailystepcount.userid')->get()->toArray(); */
            
            $arr = DB::table('users')
                ->join('dailystepcount', 'users.id', '=', 'dailystepcount.userid')
                ->select('users.id as user_id', 'dailystepcount.userid as friend_id', 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl', DB::raw('IF(SUM(dailystepcount.calories) IS NULL, 0,SUM(dailystepcount.calories)) AS steps'))
                ->whereIn('users.id', $fid)          
                ->whereRaw("DATE_FORMAT(dailystepcount.created_at, '%Y-%m-%d') = '".$date."'")
                ->orderBy('dailystepcount.steps', 'DESC')->groupBy('users.id')->get()->toArray();
            /* if(empty($arr)){
                $arr = DB::table('users')
                ->join('dailystepcount', 'users.id', '=', 'dailystepcount.userid')
                ->select('users.id as user_id', 'dailystepcount.userid as friend_id', 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl', DB::raw("0 as steps"))
                ->whereIn('users.id', $fid)          
                ->orderBy('dailystepcount.steps', 'DESC')->groupBy('users.id')->limit(4)->get()->toArray();
            } */
            
            /* print_r($arr);
            exit; */

            /* $arr = array();
            if(!empty($friends)){
                foreach($friends as $val){
                    $friend_id = $val->friend_id;
                    $d['friend_id'] = $friend_id;
                    $d['user_id'] = $val->user_id;
                    //$d['steps'] = $val->steps;
                    $d['steps'] = $val->sum_of_steps;
                    $user = DB::table('users')->where('id','=', $friend_id)->first();
                    $d['firstname'] = $user->firstname;
                    $d['lastname'] = $user->lastname;
                    $d['profileurl'] = $user->profileurl;

                    $arr[] = $d;
                }
            } */
            /* print_r($arr);
            exit; */

            $users = DB::table('users')
                ->join('dailystepcount', 'users.id', '=', 'dailystepcount.userid')
                ->select('users.id as user_id', DB::raw("'$user_id' as friend_id"), 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl', DB::raw('IF(SUM(dailystepcount.calories) IS NULL, 0,SUM(dailystepcount.calories)) AS steps'))
                ->where('users.id', '=', $user_id)      
                ->whereRaw("DATE_FORMAT(dailystepcount.created_at, '%Y-%m-%d') = '".$date."'")
                ->orderBy('dailystepcount.steps', 'DESC')->limit(1)->get()->toArray();
            /* print_r($users);
            exit; */
            if(empty($users[0]->user_id)){
                $users = DB::table('users')
                ->select('users.id as user_id', DB::raw("'$user_id' as friend_id"), 'users.name as username', 'users.firstname', 'users.lastname', 'users.profileurl', DB::raw("0 as steps"))
                ->where('users.id', '=', $user_id)
                ->limit(1)->get()->toArray();
            }

            if (!empty($arr) && !empty($users)) {
                $json_response = array_merge($arr, $users);
            }else if(!empty($arr) && empty($users)){
                $json_response = $arr;
            }else if(empty($arr) && !empty($users)){
                $json_response = $users;
            }else{
                $json_response = $users;
            }

            $json_encode = json_encode($json_response);
            $json_decode = json_decode($json_encode, true);
            
            $json = $this->asortReverse($json_decode, 'steps');
                
            $response = json_encode(array("status" => "true", "message" => "Lists.", "data"=>$json));
            return response($response, 200);
        }
    }

    /* Report API */
    public function getDashboardReport(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $report_type = 'daily';
            if(isset($request->report_type) && !empty($request->report_type)){
                $report_type = $request->report_type;
            }

            $date = date("d-M-Y");

            $users = DB::table('users')->where('id','=', $user_id)->first();
            if(empty($users)){
                $response = json_encode(array("status" => "false", "message" => "You have select wrong user!"));
                return response($response, 200);
            }

            $age = $users->age;
            $height = $users->height;
            $weight = $users->weight;

            $avg = $weight / ($height*$height);
            $avg = round($avg);

            //$wellness_plan_details = DB::table('wellness_plan_details')->where('min_age','<=', $age)->where('max_age','>=', $age)->first();
            $wellness_plan = DB::table('user_wellness_plans')->where('user_id','=', $user_id)->where('status','=', 1)->orderBy('id','DESC')->first();
            if (!empty($wellness_plan)) {
                $plan_data = json_decode($wellness_plan->plan_data, true);
                
                /* Current plan details for selected user */
                $steps = $plan_data['steps'];
                $daily_distance = $plan_data['daily_distance'];
                $daily_distance = str_replace("km", "", $daily_distance);

                //$calories_burnt = $plan_data['calories_burnt_calculation'];
                if(isset($plan_data['calories_burnt_calculation'])){
                    $calories_burnt = $plan_data['calories_burnt_calculation'];
                }else{
                    $calories_burnt = $plan_data['calories_burnt'];
                }

                $today = date("Y-m-d");
                
                $wellness_plan = DB::table('dailystepcount')
                ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                ->where('userid', '=', $user_id)
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$today."'")
                ->whereNotNull('distance')
                ->first();
                
                $sum_of_distance = $wellness_plan->sum_of_distance;
                $sum_of_steps = $wellness_plan->sum_of_steps;
                $sum_of_calories = $wellness_plan->sum_of_calories;

                if ($sum_of_distance > 0) {
                    $per_of_distance = $sum_of_distance*100/$daily_distance;
                } else {
                    $per_of_distance = 0;
                }

                if ($sum_of_steps > 0) {
                    $per_of_steps = $sum_of_steps*100/$steps;
                } else {
                    $per_of_steps = 0;
                }

                if ($sum_of_calories > 0) {
                    $per_of_calories = $sum_of_calories*100/$calories_burnt;
                } else {
                    $per_of_calories = 0;
                }
                
                $json_data['distance'] = (string)$daily_distance;
                $json_data['steps'] = (string)$steps;
                $json_data['calories'] = (string)$calories_burnt;
                $json_data['sum_of_distance'] = (string)$sum_of_distance;
                $json_data['sum_of_steps'] = (string)$sum_of_steps;
                $json_data['sum_of_calories'] = (string)$sum_of_calories;
                $json_data['per_of_distance'] = (string)number_format($per_of_distance,2);
                $json_data['per_of_steps'] = (string)number_format($per_of_steps,2);
                $json_data['per_of_calories'] = (string)number_format($per_of_calories,2);
                
                $json_data['final_per'] = (string) number_format($per_of_distance+$per_of_steps+$per_of_calories/3, 2);

                /* $currentdatetime = date("Y-m-d H:i:s");
                $todaydatetime = date("Y-m-d")."00:00:00";

                $end = new DateTime( $currentdatetime );
                $begin   = new DateTime( $todaydatetime );
                
                for($i = $begin; $i <= $end; $i->modify('+1 hours')){
                    echo $i->format("Y-m-d H:i:s")."\n";
                } */

                $today = date('Y-m-d');
                /* Weekly Activity Graph */
                if($report_type == 'weekly'){                    
                    $lastdate = date('Y-m-d', strtotime('-6 days'));
                    $begin = new DateTime( $lastdate );
                    $end   = new DateTime( $today );

                    $daily_arr = array();
                    for($i = $begin; $i <= $end; $i->modify('+1 day')){
                        $selected_date = $i->format("Y-m-d");

                        $wellness_plan = DB::table('dailystepcount')
                        ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                        ->where('userid', '=', $user_id)
                        ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$selected_date."'")
                        ->whereNotNull('distance')
                        ->first();
                        
                        $sum_of_distance = $wellness_plan->sum_of_distance;
                        $sum_of_steps = $wellness_plan->sum_of_steps;
                        $sum_of_calories = $wellness_plan->sum_of_calories;

                        $d1['label'] = (string)$selected_date;
                        if(!empty($sum_of_distance)){
                            $d1['distance'] = (string)number_format($sum_of_distance,2);
                        }else{
                            $d1['distance'] = "0.00";
                        }

                        if(!empty($sum_of_steps)){
                            $d1['steps'] = (string)$sum_of_steps;
                        }else{
                            $d1['steps'] = "0";
                        }

                        if(!empty($sum_of_calories)){
                            $d1['calories'] = (string)number_format($sum_of_calories,2);
                        }else{
                            $d1['calories'] = "0.00";
                        }

                        $daily_arr[] = $d1;
                    }
                    //$weekly_graph_arr = $this->asortReverse($daily_arr, 'label');
                    $graph_arr = $daily_arr;
                }else if($report_type == 'monthly'){

                    /* Monthly Activity Graph */
                    $last30day = date('Y-m-d', strtotime('-29 days'));
                    $begin = new DateTime( $last30day );
                    $end   = new DateTime( $today );

                    $monthly_arr = array();
                    for($i = $begin; $i <= $end; $i->modify('+1 day')){
                        $selected_date = $i->format("Y-m-d");

                        $wellness_plan = DB::table('dailystepcount')
                        ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                        ->where('userid', '=', $user_id)
                        ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$selected_date."'")
                        ->whereNotNull('distance')
                        ->first();
                        
                        $sum_of_distance = $wellness_plan->sum_of_distance;
                        $sum_of_steps = $wellness_plan->sum_of_steps;
                        $sum_of_calories = $wellness_plan->sum_of_calories;

                        $d1['label'] = (string)$selected_date;
                        if(!empty($sum_of_distance)){
                            $d1['distance'] = (string)number_format($sum_of_distance,2);
                        }else{
                            $d1['distance'] = "0.00";
                        }

                        if(!empty($sum_of_steps)){
                            $d1['steps'] = (string)$sum_of_steps;
                        }else{
                            $d1['steps'] = "0";
                        }

                        if(!empty($sum_of_calories)){
                            $d1['calories'] = (string)number_format($sum_of_calories,2);
                        }else{
                            $d1['calories'] = "0.00";
                        }

                        $monthly_arr[] = $d1;
                    }
                    //$monthly_graph_arr = $this->asortReverse($monthly_arr, 'label');
                    $graph_arr = $monthly_arr;
                }else{
                    $currentdatetime = date("Y-m-d H:i:s");
                    $todaydatetime = date("Y-m-d")."00:00:00";
    
                    $end = new DateTime( $currentdatetime );
                    $begin   = new DateTime( $todaydatetime );
                    
                    $daily_arr = array();
                    for($i = $begin; $i <= $end; $i->modify('+1 hours')){
                        $selected_date = $i->format("Y-m-d H");

                        $wellness_plan = DB::table('dailystepcount')
                        ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                        ->where('userid', '=', $user_id)
                        ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H') = '".$selected_date."'")
                        ->whereNotNull('distance')
                        ->first();
                        
                        $sum_of_distance = $wellness_plan->sum_of_distance;
                        $sum_of_steps = $wellness_plan->sum_of_steps;
                        $sum_of_calories = $wellness_plan->sum_of_calories;

                        $d1['label'] = (string)$i->format("Y-m-d H:i:s");
                        if(!empty($sum_of_distance)){
                            $d1['distance'] = (string)number_format($sum_of_distance,2);
                        }else{
                            $d1['distance'] = "0.00";
                        }

                        if(!empty($sum_of_steps)){
                            $d1['steps'] = (string)$sum_of_steps;
                        }else{
                            $d1['steps'] = "0";
                        }

                        if(!empty($sum_of_calories)){
                            $d1['calories'] = (string)number_format($sum_of_calories,2);
                        }else{
                            $d1['calories'] = "0.00";
                        }

                        $daily_arr[] = $d1;
                    }
                    //$daily_graph_arr = $this->asortReverse($daily_arr, 'label');
                    $graph_arr = $daily_arr;
                }
            }else{
                $json_data = array();
            }

            $response = json_encode(array("status" => "true", "message" => "Successfully.","data"=>$json_data,'graph_arr'=>$graph_arr));
            return response($response, 200);
        }
    }

    /* Dashboard data */
    public function getDashboardData(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $report_type = 'daily';
            if(isset($request->report_type) && !empty($request->report_type)){
                $report_type = $request->report_type;
            }

            $date = date("d-M-Y");

            $users = DB::table('users')->where('id','=', $user_id)->first();
            if(empty($users)){
                $response = json_encode(array("status" => "false", "message" => "You have select wrong user!"));
                return response($response, 200);
            }

            $age = $users->age;
            $height = $users->height;
            $weight = $users->weight;
            $bmi = $users->bmi;

            $avg = $weight / ($height*$height);
            $avg = round($avg);
            $today = date("Y-m-d");

            $wellness_plan = DB::table('user_wellness_plans')->where('user_id','=', $user_id)->where('status','=', 1)->orderBy('id','DESC')->first();
            if (!empty($wellness_plan)) {

                $plan_data = json_decode($wellness_plan->plan_data, true);
                
                /* Current plan details for selected user */
                $steps = $plan_data['steps'];
                $daily_distance = $plan_data['daily_distance'];
                $daily_distance = str_replace("km", "", $daily_distance);
                $calories_burnt = $plan_data['calories_burnt'];

                if(isset($plan_data['calories_burnt_calculation'])){
                    $calories_burnt_calculation = $plan_data['calories_burnt_calculation'];
                }else{
                    $calories_burnt_calculation = $plan_data['calories_burnt'];
                }
                
                $wellness_plan = DB::table('dailystepcount')
                ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                ->where('userid', '=', $user_id)
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$today."'")
                ->whereNotNull('distance')
                ->first();
                
                $sum_of_distance = $wellness_plan->sum_of_distance;
                if(empty($sum_of_distance)){
                    $sum_of_distance = "0";
                }

                $sum_of_steps = $wellness_plan->sum_of_steps;
                if(empty($sum_of_steps)){
                    $sum_of_steps = "0";
                }

                $sum_of_calories = $wellness_plan->sum_of_calories;
                if(empty($sum_of_calories)){
                    $sum_of_calories = "0";
                }

                $d['wellness_plan_distance'] = (string)$daily_distance;
                $d['wellness_plan_steps'] = (string)$steps;
                $d['wellness_plan_calories'] = (string)$calories_burnt;
                $d['sum_of_distance_for_day'] = (string)$sum_of_distance;
                $d['sum_of_steps_for_day'] = (string)$sum_of_steps;
                $d['sum_of_calories_for_day'] = (string)$sum_of_calories;                
                $d['calories_burnt_calculation'] = (string)$calories_burnt_calculation;
                
                $previous_week = strtotime("-1 week +1 day");
                $start_week = strtotime("last monday midnight");
                $end_week = strtotime("next sunday");
                $start_week = date("Y-m-d",$start_week);
                $end_week = date("Y-m-d",$end_week);

                /* My Plan Data for weekly */
                $wellness_plan_for_week = DB::table('dailystepcount')
                ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                ->where('userid', '=', $user_id)
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') BETWEEN '".$start_week."' AND '".$end_week."'")
                ->whereNotNull('distance')
                ->first();

                $sum_of_distance_for_week = $wellness_plan_for_week->sum_of_distance;
                if(empty($sum_of_distance_for_week)){
                    $sum_of_distance_for_week = "0";
                }

                $sum_of_steps_for_week = $wellness_plan_for_week->sum_of_steps;
                if(empty($sum_of_steps_for_week)){
                    $sum_of_steps_for_week = "0";
                }

                $sum_of_calories_for_week = $wellness_plan_for_week->sum_of_calories;
                if(empty($sum_of_calories_for_week)){
                    $sum_of_calories_for_week = "0";
                }

                $d['sum_of_distance_for_week'] = (string)str_replace(",","",number_format($sum_of_distance_for_week,2));
                $d['sum_of_steps_for_week'] = (string)$sum_of_steps_for_week;
                $d['sum_of_calories_for_week'] = (string)str_replace(",","",number_format($sum_of_calories_for_week,2));
                $arr[] = $d;
                $json_data['wellness_calulate_data'] = $arr;

            }else{
                $json_data = array();
                $json_data['wellness_calulate_data'] = [];
            }

	        	$setgoal = DB::table('setgoal')
                ->where('user_id','=', $user_id)
                ->whereRaw("goalDate = '".$today."'")
                ->orderBy('id','DESC')->first();

                //echo "<pre>";print_r($setgoal);exit;
                $issetgoal = 'No';
                $setgoal_arr = array();
                if(!empty($setgoal)){
                    $issetgoal = 'Yes';
                    $d1['setgoal_weight'] = str_replace(",","",number_format($setgoal->weight,2));
                    $d1['setgoal_steps'] = $setgoal->steps;
                    $d1['setgoal_calories'] = str_replace(",","",number_format($setgoal->calories,2));
                    $d1['setgoal_running_distance'] = str_replace(",","",number_format($setgoal->running_distance,2));

                    $d1['sum_of_weight_for_day'] = (string)str_replace(",","",number_format(($sum_of_calories*0.00013), 2));
                    $d1['sum_of_distance_for_day'] = (string)$sum_of_distance;
                    $d1['sum_of_steps_for_day'] = (string)$sum_of_steps;
                    $d1['sum_of_calories_for_day'] = (string)str_replace(",","",number_format($sum_of_calories,2));
                    $setgoal_arr[] = $d1;
                }

                $json_data['bmi'] = str_replace(",","",number_format($bmi,2));


               $newweight = (($height/100) * ($height/100)) * 21.5;
               //echo "---";
               //echo $weight;exit;
               $fbmi = $weight - $newweight;
               $bbmi = (int) $fbmi;//number_format((float)$fbmi, 2, '.', '');

                if($weight < $newweight)
                {
                    $bmi_text = "You have to gain ".$bbmi."KG";
                }
                else if($weight > $newweight)
                {
                    $bmi_text = "You have to loss ".$bbmi."KG";
                }
                else{
                    $bmi_text = "";
                }
               /* if ($bmi < 21.5) {
                    $bmi_text = "You have to gain 1KG";
                } else if ($bmi > 18 && $bmi < 24) {
                    $bmi_text = "";
                } else if ($bmi > 25 && $bmi < 29) {
                    $bmi_text = "You have to loss 1KG";
                } else if ($bmi > 30 && $bmi < 34) {
                    $bmi_text = "You have to loss 2KG";
                } else if ($bmi > 35) {
                    $bmi_text = "You have to loss 3KG";
                }else{
                    $bmi_text = "";
                }*/

                $json_data['bmi_text'] = $bmi_text;
                $json_data['issetgoal'] = $issetgoal;
                $json_data['setgoal_data'] = $setgoal_arr;
        	
        
            $response = json_encode(array("status" => "true", "message" => "Successfully.","data"=>$json_data));
            return response($response, 200);
        }
    }

    public function friendDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $report_type = 'daily';
            if(isset($request->report_type) && !empty($request->report_type)){
                $report_type = $request->report_type;
            }

            $date = date("d-M-Y");
            $today = date("Y-m-d");

            $users = DB::table('users')->select('id','firstname','lastname','profileurl','bmi','dob','height','weight','loyaltpoints')->where('id','=', $user_id)->first();

            if(empty($users)){
                $response = json_encode(array("status" => "false", "message" => "You have select wrong user!"));
                return response($response, 200);
            }
            
            $wellness_plan = DB::table('dailystepcount')
                ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                ->where('userid', '=', $user_id)
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$today."'")
                ->whereNotNull('distance')
                ->first();

            $sum_of_distance = $wellness_plan->sum_of_distance;
            if(empty($sum_of_distance)){
                $sum_of_distance = "0";
            }

            $sum_of_steps = $wellness_plan->sum_of_steps;
            if(empty($sum_of_steps)){
                $sum_of_steps = "0";
            }

            $sum_of_calories = $wellness_plan->sum_of_calories;
            if(empty($sum_of_calories)){
                $sum_of_calories = "0";
            }

            $users->distance = (string)str_replace(",","",number_format($sum_of_distance,2));
            $users->steps = (string)str_replace(",","",number_format($sum_of_steps,2));
            $users->calories = (string)str_replace(",","",number_format($sum_of_calories,2));

            $currentdatetime = date("Y-m-d H:i:s");
            $todaydatetime = date("Y-m-d")."00:00:00";

            $end = new DateTime( $currentdatetime );
            $begin   = new DateTime( $todaydatetime );
            
            $daily_arr = array();
            for($i = $begin; $i <= $end; $i->modify('+1 hours')){
                $selected_date = $i->format("Y-m-d H");

                $wellness_plan = DB::table('dailystepcount')
                ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                ->where('userid', '=', $user_id)
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H') = '".$selected_date."'")
                ->whereNotNull('distance')
                ->first();
                
                $sum_of_distance = $wellness_plan->sum_of_distance;
                $sum_of_steps = $wellness_plan->sum_of_steps;
                $sum_of_calories = $wellness_plan->sum_of_calories;

                $d1['label'] = (string)$i->format("Y-m-d H:i:s");
                if(!empty($sum_of_distance)){
                    $d1['distance'] = (string)number_format($sum_of_distance,2);
                }else{
                    $d1['distance'] = "0.00";
                }

                if(!empty($sum_of_steps)){
                    $d1['steps'] = (string)$sum_of_steps;
                }else{
                    $d1['steps'] = "0";
                }

                if(!empty($sum_of_calories)){
                    $d1['calories'] = (string)number_format($sum_of_calories,2);
                }else{
                    $d1['calories'] = "0.00";
                }

                $daily_arr[] = $d1;
            }
            
            $json = array();
            $json['users'] = $users;
            $json['daily_arr'] = $daily_arr;
            
            //$json[] = $d;

            $response = json_encode(array("status" => "true", "message" => "Lists.", "data"=>$json));
            return response($response, 200);
        }
    }

    public function getUserDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;

            $users = DB::table('users')
            ->select('users.name as username','users.firstname','users.lastname','users.profileurl','dob','dob','gender','country','created_at')
            ->where('id','=',$user_id)->first();

            $response = json_encode(array("status" => "true", "message" => "Lists.", "data"=>$users));
            return response($response, 200);
        }
    }

	public function calCoins(){
        $date = date("Y-m-d");
        $users = DB::table('users')->selectRaw('id,coins')->get();
        
        $arr = array();
        foreach($users as $v){
            $id = $v->id;
            $oldcoins = $v->coins;

            $d['id'] = $id;
            
            $find_activity = DB::table('activity_details')
            ->selectRaw('id,user_id,kcals, count(DISTINCT activity) as total_activity, SUM(kcals) as total_kcals')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$date."'")
            ->where('user_id', $id)
            ->first();

            $total_activity = $find_activity->total_activity;
            $total_kcals = $find_activity->total_kcals;

            if ($total_activity > 0) {
                $avg_kcals = $total_kcals/$total_activity;

                $points = $avg_kcals / 10;

                $coins = $points/100;    
            }else{
                $avg_kcals = 0;
                $points = 0;
                $coins = 0;
            }

            $new_coins = $oldcoins+$coins;
            $dataq = array(
                'coins' => $new_coins,
            	'points' => $points
            );
            DB::table('users')->where('id',$id)->update($dataq);
        }
    }

    # SORT ARRAY BY KEY
    public function aasort($array, $key) 
    {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=array_values($ret);
        return $array;
    }	
    
    # SORT ARRAY BY KEY DESC
    public function asortReverse($array, $key) 
    {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        arsort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=array_values($ret);
        return $array;
    }


    public function goalAchieveCronJob(){
        
            $allusers = DB::table('users')->where('status','=', 'active')->orwhere('status','=', 'new')->get();
            foreach($allusers as $users){
                
                $user_id = $users->id;
                $report_type = 'daily';
                $date = date("d-M-Y");
                //$users = DB::table('users')->where('id','=', $user_id)->first();
                $age = $users->age;
                //if($users->height > 0){$height = $users->height;} else {$height = "0";}
                //if($users->weight  > 0){$weight = $users->weight;} else {$weight = "0";}
                //if($users->bmi  > 0){$bmi = $users->bmi;} else {$bmi = "0";}
                //$weight = $users->weight;
               // $bmi = $users->bmi;
                //$avg = $weight / ($height*$height);
                //$avg = round($avg);
                $today = date("Y-m-d");

                
                $wellness_plan = DB::table('dailystepcount')
                ->select(DB::raw('SUM(distance) AS sum_of_distance'), DB::raw('SUM(steps) AS sum_of_steps'), DB::raw('SUM(calories) AS sum_of_calories'))
                ->where('userid', '=', $user_id)
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '".$today."'")
                ->whereNotNull('distance')
                ->first();
                
                $sum_of_distance = str_replace(",","",number_format($wellness_plan->sum_of_distance,2));
                if(empty($sum_of_distance)){
                    $sum_of_distance = "0.00";
                }

                $sum_of_steps = $wellness_plan->sum_of_steps;
                if(empty($sum_of_steps)){
                    $sum_of_steps = "0";
                }

                $sum_of_calories = $wellness_plan->sum_of_calories;
                if(empty($sum_of_calories)){
                    $sum_of_calories = "0";
                }
                
                
	        	$setgoal = DB::table('setgoal')
                ->where('user_id','=', $user_id)
                ->whereRaw("goalDate = '".$today."'")
                ->orderBy('id','DESC')->first();

                if($setgoal)
                {
                    $setgoal_weight = str_replace(",","",number_format($setgoal->weight,2));
                    $setgoal_steps = $setgoal->steps;
                    $setgoal_calories = str_replace(",","",number_format($setgoal->calories,2));
                    $setgoal_running_distance = str_replace(",","",number_format($setgoal->running_distance,2));
                }
                else{
                    $setgoal_weight = "0.00";
                    $setgoal_steps = "0";
                    $setgoal_calories = "0.00";
                    $setgoal_running_distance = "0.00";

                }
                

                $sum_of_weight_for_day = (string)str_replace(",","",number_format(($sum_of_calories*0.00013), 2));
                $sum_of_distance_for_day = (string)$sum_of_distance;
                $sum_of_steps_for_day = (string)$sum_of_steps;
                $sum_of_calories_for_day = (string)str_replace(",","",number_format($sum_of_calories,2));

                if($sum_of_distance_for_day >=$setgoal_running_distance && $sum_of_steps_for_day >= $setgoal_steps && $sum_of_calories_for_day >= $setgoal_calories && $sum_of_weight_for_day >= $setgoal_weight)
                {
                    //$fcm_tokken = 'dbSz9_FHR1mdjeodOQLmOI:APA91bFOCTExyM5GDiTRuhc4SUDPELyouaM0u8sRRlFb6854wTNHGEgAJadWCIIb8oo8chiZH3F2Qbmsn67BZwYOmn8-_dmdd8efPeet1RH9UT5LhxS1vMh9HSIq-dMN1RsKZ16v4bBl';
                    $fcm_tokken =$users->fcm_tokken;
                    $msg = "Great ! You Achieved Your Today's Goal!!";
                    $result = $this->sendPuchNotification("Android", $fcm_tokken, $msg,'0',"", "Pulse", "");
                    $res = json_decode($result);
                   // echo $res['success'];
                   echo "user_id=".$users->id;
                   echo "<br>";
                    
                }
            
            }
            
                /*echo $sum_of_distance_for_day ."---".$setgoal_running_distance;
                echo "<br>============";
                echo $sum_of_steps_for_day ."---".$setgoal_steps;
                echo "<br>============";
                echo $sum_of_calories_for_day ."---".$setgoal_calories;
                echo "<br>============";
                echo $sum_of_weight_for_day ."---".$setgoal_weight;
                echo "<br>============";*/
             
        
    }
}