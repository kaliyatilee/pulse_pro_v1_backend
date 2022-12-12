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

class AppController extends Controller{

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'=>'required'
        ]);

        if ($validator->fails()) {

            $response = ["message" =>$validator->errors() ,"status"=>"error"];

            return response($response, 200);
        }else{

            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    // $accessToken = $user->createToken('authToken')->accessToken;
                    $token = DB::table('subscriptions')->where('user_id',$user->id)->orderBy('id','DESC')->first();
                    if(!is_null($token)){
                        $date_current = date('Y-m-d H:i:s');

                        if($token->expire_date < $date_current){

                            $response = ['user' => $user,'token' => null , 'authToken' => "Yo","status"=>"success"];

                        }else{

                            $response = ['user' => $user,'token' => $token , 'authToken' => "Yo","status"=>"success"];
                        }

                    }
                    else{
                        $response = ['user' => $user,'token' => null , 'authToken' => "Yo","status"=>"success"];
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
            'card_number'=>'required',
            'expiry_date'=>'required',
            'cvv'=>'required'
        ]);

        if ($validator->fails()) {
            $response = ["message" =>$validator->errors() ,"status"=>"error"];
            return response($response, 200);
        }else{

            $dateplus = strtotime("+30 day");
            $date_current = date('Y-m-d H:i:s',$dateplus);

            $userdata = DB::table('users')->where('id',$request->input('user_id'))->first();

            $expiry_date = explode("/", $request->input('expiry_date'));
            
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $customerspayment = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                  'number' => $request->input('card_number'),
                  'exp_month' => $expiry_date[0],
                  'exp_year' => $expiry_date[1],
                  'cvc' => $request->input('cvv'),
                ],
            ]);
            $stripe->paymentMethods->attach(
                $customerspayment->id,
                ['customer' => $userdata->customer_id]
            );

            $response = ["message" =>'card added successful',"status"=>"success"];
            return response($response, 200);

            /* $data = array(
                'token_id'=> 0,
                'user_id'=> $request->input('user_id'),
                'expire_date'=> $date_current,
                'type'=>""
            );

            $subadd = DB::table('subscriptions')->insertGetId($data);

            if(!is_null($subadd)){
                $response = ["message" =>'Subscribe successful',"status"=>"success"];
                return response($response, 200);
            }else{
                $response = ["message" =>'Something went wrong!',"status"=>"error"];
                return response($response, 200);
            } */
        }
    }

    public function subscribe(Request $request){
        $validator =Validator::make($request->all(),[
            'user_id'=>'required',
            'token'=>'required'
        ]);

        if ($validator->fails()) {
            $response = ["message" =>$validator->errors() ,"status"=>"error"];
            return response($response, 200);
        }else{

            $dateplus = strtotime("+30 day");
            $date_current = date('Y-m-d H:i:s',$dateplus);

            $data = array(
                'token_id'=> 0,
                'user_id'=> $request->input('user_id'),
                'expire_date'=> $date_current,
                'type'=>""
            );

            $subadd = DB::table('subscriptions')->insertGetId($data);

            if(!is_null($subadd)){
                $response = ["message" =>'Subscribe successful',"status"=>"success"];
                return response($response, 200);
            }else{
                $response = ["message" =>'Something went wrong!',"status"=>"error"];
                return response($response, 200);
            }
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
                'bmi' => $request->input('bmi'),
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

        $rewards = DB::table('rewards')->get();

        $response = ['rewards' => $rewards, 'authToken' => "Yo","status"=>"success",'user' => $usercoins];
        return response($rewards, 200);

    }

    public function getCoins(Request $request){

        $usercoins = DB::table('users')->where("id",$request->input('user_id'))->select('loyaltpoints')->get();

        return response($usercoins[0]->loyaltpoints, 200);
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

            $newsfeeds = DB::select('SELECT n.*,u.firstname,u.lastname,u.profileurl
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
            if(!empty($newsfeeds)){

                $arr = array();
                foreach($newsfeeds as $val){
                    $d['id'] = $val->id;

                    $d['tot_likes'] = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','1')->count();

                    $check = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','1')->where('user_id','=',$request->input('user_id'))->count();
                    if($check > 0){
                        $d['like_status'] = 'like';
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

                    $d['tot_likes'] = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','1')->count();

                    $check = DB::table('newsfeed_activities')->where('feed_id','=',$val->id)->where('type','=','1')->where('user_id','=',$request->input('user_id'))->count();
                    if($check > 0){
                        $d['like_status'] = 'like';
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
            ->where('user_id',[$user])
            ->orwhere('friend_id',[$user])
            ->get();


        $ttry[] = $user;

        foreach($friends as $key){
            // if($key->user_id != $user || $key->friend_id != $user){
            $ttry[] = $key->user_id;
            $ttry[] = $key->friend_id;
            //}

        }

        //dd($ttry);


        $allusers['data'] = DB::table('users')
            ->select('id','firstname','lastname','profileurl')
            ->where('roleId',"2")
            ->whereNotIn('id',$ttry)
            ->orderBy('firstname','ASC')
            ->get();

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

        $dbdata = array(
            'user_id' => $request->input('user_id'),
            'friend_id' => $request->input('friend_id'),
            'status' => "pending"
        );



        $addfriend = DB::table('friends')->insertGetId($dbdata);

        if(!is_null($addfriend)){

            $response = json_encode(["status"=>"success"]);
            $this->send_one_signal_user($user_token,$msg,$header,$data);
            return response($response, 200);
        }

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
        $dbdata = array(
            'status' => "active"
        );

        $accept_req = DB::table('friends')->where('id',$id)->update($dbdata);

        $response = ['authToken' => "Yo","status"=>"success"];
        return response($response, 200);

    }

    public function reject_friend_request(Request $request){

        $id = $request->input('id');
        $dbdata = array(
            'status' => "reject"
        );

        $accept_req = DB::table('friends')->where('id',$id)->update($dbdata);

        $response = ['authToken' => "Yo","status"=>"success"];
        return response($response, 200);

    }

    public function friend_request(Request $request){

        $userid = $request->input('user_id');

        $friendreq = DB::table('friends')
            ->join('users', 'friends.user_id', '=', 'users.id')
            ->select('friends.id','users.firstname','users.lastname','users.profileurl')
            ->where('friends.friend_id',$userid)
            ->where('friends.status',"pending")
            ->get();
        $response['data'] = $friendreq;

        //dd($friendreq);

        return response($response, 200);





    }

    public function get_friend_list(Request $request){
        $userid = $request->input('user_id');

        $friends = DB::select('SELECT u.id,u.firstname,u.lastname,u.profileurl,u.loyaltpoints FROM friends AS f
JOIN users AS u
ON f.friend_id = u.id OR f.user_id = u.id
WHERE (f.user_id = '.$userid.' OR f.friend_id = '.$userid.')
AND f.status = "active"');

        if (!empty($friends)){
            $respond['data'] = $friends;
            return response($respond, 200);

        }else{
            $respond['data'] = null;
            return response($respond, 200);
        }


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

        $corporates = DB::table('corporates')->get();

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
        ->select('transactions.*','rewards.*','users.name')
        ->where("transactions.user_id",$request->input('user_id'))->get();

        $response = ['data' => $transactions, 'authToken' => "Yo","status"=>"success"];
        return response($response, 200);
    }

    public function getFeedDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'feed_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $feed_id = $request->feed_id;
            if(isset($request->type)){
                $type = $request->type;
                if($type == 'like'){
                    $type = 1;
                }else{
                    $type = 2;
                }

                $comments = DB::table('newsfeed_activities')
                ->join('users', 'newsfeed_activities.user_id', '=', 'users.id')
                ->select('newsfeed_activities.id','newsfeed_activities.comments','newsfeed_activities.user_id','users.name as username','users.firstname','users.lastname','users.profileurl','newsfeed_activities.comment_id','newsfeed_activities.type','newsfeed_activities.created_at')
                ->where('newsfeed_activities.feed_id','=',$feed_id)
                ->where('newsfeed_activities.type','=',$type)->get();

            }else{
                $comments = DB::table('newsfeed_activities')
            ->join('users', 'newsfeed_activities.user_id', '=', 'users.id')
            ->select('newsfeed_activities.id','newsfeed_activities.comments','newsfeed_activities.user_id','users.name as username','users.firstname','users.lastname','users.profileurl','newsfeed_activities.comment_id','newsfeed_activities.type','newsfeed_activities.created_at')
            ->where('newsfeed_activities.feed_id','=',$feed_id)->get();
            }

            $tot_likes = DB::table('newsfeed_activities')->where('feed_id','=',$feed_id)->where('type','=','1')->count();
            $tot_comments = DB::table('newsfeed_activities')->where('feed_id','=',$feed_id)->where('type','=','2')->count();

            

            $arr = array();
            if(!empty($comments)){
                foreach($comments as $val){
                    $d['id'] = $val->id;
                    $d['comments'] = ($val->comments==null)?"":$val->comments;
                    $d['user_id'] = $val->user_id;
                    $d['username'] = $val->username;
                    $d['firstname'] = $val->firstname;
                    $d['lastname'] = $val->lastname;
                    $d['comment_id'] = $val->comment_id;
                    if($val->type == '1'){
                        $d['type'] = 'like';
                    }else{
                        $d['type'] = 'comment';
                    }
                    $d['tot_likes'] = DB::table('newsfeed_comment_activities')->where('comment_id','=',$val->id)->where('type','=','1')->count();
                    $d['tot_comments'] = DB::table('newsfeed_comment_activities')->where('comment_id','=',$val->id)->where('type','=','2')->count();

                    $d['created_at'] = $val->created_at;
                    $profileurl = $val->profileurl;
                    $profileurl = str_ireplace("/core","",$profileurl);
                    $d['profileurl'] = $profileurl;

                    $sub_comments = DB::table('newsfeed_comment_activities')
                    ->join('users', 'newsfeed_comment_activities.user_id', '=', 'users.id')
                    ->select('newsfeed_comment_activities.id','newsfeed_comment_activities.comments','newsfeed_comment_activities.user_id','users.name as username','newsfeed_comment_activities.id','users.profileurl','users.firstname','users.lastname','newsfeed_comment_activities.type','newsfeed_comment_activities.created_at')
                    ->where('newsfeed_comment_activities.comment_id','=',$val->id)
                    ->where('type','=','2')->get();

                    $arr_comm = array();
                    if(!empty($sub_comments)){
                        foreach($sub_comments as $r){
                            $d1['id'] = $r->id;
                            $d1['comments'] = ($r->comments==null)?"":$r->comments;
                            $d1['user_id'] = $r->user_id;
                            $d1['username'] = $r->username;
                            $d1['firstname'] = $r->firstname;
                            $d1['lastname'] = $r->lastname;
                            $d1['created_at'] = $r->created_at;
                            $profileurl1 = $r->profileurl;
                            $profileurl1 = str_ireplace("/core","",$profileurl1);
                            $d1['profileurl'] = $profileurl1;
                            $arr_comm[] = $d1;
                        }
                    }
                    $d['comments_arr'] = $arr_comm;

                    $sub_likes = DB::table('newsfeed_comment_activities')
                    ->join('users', 'newsfeed_comment_activities.user_id', '=', 'users.id')
                    ->select('newsfeed_comment_activities.id','newsfeed_comment_activities.comments','newsfeed_comment_activities.user_id','users.name as username','newsfeed_comment_activities.id','users.profileurl','users.firstname','users.lastname','newsfeed_comment_activities.type','newsfeed_comment_activities.created_at')
                    ->where('newsfeed_comment_activities.comment_id','=',$val->id)
                    ->where('type','=','1')->get();

                    $arr_likes = array();
                    if(!empty($sub_likes)){
                        foreach($sub_likes as $rec){
                            $d2['id'] = $rec->id;
                            $d2['user_id'] = $rec->user_id;
                            $d2['username'] = $rec->username;
                            $d2['firstname'] = $rec->firstname;
                            $d2['lastname'] = $rec->lastname;
                            $d2['created_at'] = $rec->created_at;
                            $profileurl1 = $rec->profileurl;
                            $profileurl1 = str_ireplace("/core","",$profileurl1);
                            $d2['profileurl'] = $profileurl1;
                            $arr_likes[] = $d2;
                        }
                    }
                    $d['likes_arr'] = $arr_likes;

                    $arr[] = $d;
                }
            }

            $response = ['tot_likes' => $tot_likes, 'tot_comments' => $tot_comments, 'data' => $arr, 'authToken' => "Yo","status"=>"success"];
            return response($response, 200);
        }
    }

    public function feedActivities(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required',
            'feed_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = json_encode(array("status" => "false", "message" => "Validation Error!"));
            return response($response, 200);
        } else {
            $user_id = $request->user_id;
            $feed_id = $request->feed_id;
            if($request->type == 'like'){
                $type = '1';
            }else{
                $type = '2';
            }
            $comments = $request->comments;

            if(isset($request->comment_id)){
                $comment_id = $request->comment_id;
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
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['updated_at'] = date("Y-m-d H:i:s");    
                $post = DB::table('newsfeed_comment_activities')->insertGetId($data);
            }

            if (!is_null($post)) {
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

            $wellness_plan_details = DB::table('wellness_plan_details')->where('min_age','<=', $age)->where('max_age','>=', $age)->first();
            $d['plan_name'] = $wellness_plan->plan_name;
            $d['description'] = $wellness_plan_details->description;
            $d['steps'] = $wellness_plan_details->steps;
            $d['daily_distance'] = $wellness_plan_details->daily_distance;
            $d['calories_burnt'] = $wellness_plan_details->calories_burnt;
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

            $wellness_plan = DB::table('user_wellness_plans')->where('status','=', 1)->first();
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
            $friends = DB::table('friends')
                    ->join('users', 'friends.friend_id', '=', 'users.id')
                    ->select('friends.id','friends.user_id','friends.friend_id','users.name as username','users.firstname','users.lastname','users.profileurl','friends.status')
                    ->where('friends.user_id','=',$user_id)->get();

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
}