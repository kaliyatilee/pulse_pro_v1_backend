<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Activities;
use App\Models\Activitydetails;
use App\Models\Setgoal;
use App\Models\Newsfeed;
use App\Models\AssignGoal;
use App\Models\DailyStepCount;
use App\Models\Reward;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Merchant;
use App\Repositories\MerchantRepository;
use App\Models\Subscriptionplans;
use App\Repositories\SubscriptionplansRepository;
use App\Models\Userwellnessplans;
use App\Repositories\UserwellnessplansRepository;
use App\Models\Corporate;
use App\Repositories\CorporateRepository;
use App\Models\Subscriptions;
use App\Repositories\SubscriptionsRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Activitylog;
use App\Repositories\ActivitylogRepository;
use App\Models\NewPosts;
use App\Models\Post;
use App\Models\Transaction;

use App\Models\Members;
use App\Models\PartnerWellnessPlan;
use App\Models\PartnerMasterGoals;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Imports\CorporateImport;
use App\Imports\MerchantImport;
use App\Imports\NewUsersImport;

class SUViewsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $merchantRepository;
    protected $corporateRepository;
    protected $userRepository;
    protected $subscriptionplansRepository;
    protected $userwellnessplansRepository;
    protected $subscriptionsRepository;
    protected $transactionRepository;
    protected $activitylogRepository;
    public function __construct(MerchantRepository $merchantRepository, CorporateRepository $corporateRepository, UserRepository $userRepository, SubscriptionplansRepository $subscriptionplansRepository, UserwellnessplansRepository $userwellnessplansRepository, SubscriptionsRepository $subscriptionsRepository, ActivitylogRepository $activitylogRepository, TransactionRepository $transactionRepository)
    {
        $this->middleware('auth');
        $this->merchantRepository = $merchantRepository;
        $this->corporateRepository = $corporateRepository;
        $this->userRepository = $userRepository;
        $this->subscriptionplansRepository = $subscriptionplansRepository;
        $this->userwellnessplansRepository = $userwellnessplansRepository;
        $this->subscriptionsRepository = $subscriptionsRepository;
        $this->activitylogRepository = $activitylogRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        // dd('index');
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color ? $partner->sec_color : "#8cc640",
        );
        $totalmember = [];
        $data = array(
            "totalmembers" => 0,
            "submembers" => 0,
            "newMembers" => 0,
            "activemembers" => 0,
            "rewardslist" => 0,
            "rewardsallocated" => 0,
            "rewardsnew" => 0,
            "newrewards" => 0,
            "wellnessplans" => 0,
            "newsfeed" => 0,
            "wellnessgoals" => 0,
        );

        $activeMembers = Members::where('partner_id', $userdata->partner_id)->where('status', 'active')->count();
        $inactiveMembers = Members::where('partner_id', $userdata->partner_id)->where('status', 'inactive')->count();
        $subMembers = Members::where('partner_id', $userdata->partner_id)->count();
        $newMembers = Members::where('partner_id', $userdata->partner_id)->whereDay('created_at', '=', date('d'))
            ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();

        $newMembersList = Members::where('partner_id', $userdata->partner_id)->whereDay('created_at', '=', date('d'))
            ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->get();
        $wellnessplans = PartnerWellnessPlan::where('partner_id', $partner->id)->count();
        $wellnessgoals = PartnerMasterGoals::where('partner_id', $partner->id)->count();


        $coinsreddmed = Transaction::where('status', 'paid')->sum('price');
        $totalrevenue = Subscriptions::all()->sum(function($t){ 
            return $t->numlicence * $t->amount; 
        });

       // $revenuechart =Subscriptions::where('created_at',date('Y-m-d'))->sum(function($t){ 
          //  return $t->numlicence * $t->amount; 
        //});

        

        /*$params = array();
        $params['select'] = [\DB::raw('subscriptions.*,subscription_plans.plan_name,sum(subscriptions.numlicence * subscriptions.amount) as totalamt')];
        $params['where'] = ['subscriptions.status'=>'active','subscriptions.created_at'=>'2011-11-07'];
        $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id'];
        $params['group_by'] = ['subscriptions.plan_id'];
        $subscriptions = $this->subscriptionsRepository->getByParams($params);*/
        
        $subscriptions = Subscriptions::select(DB::raw('sum(numlicence * amount) as totalamt'),'plan_id')->where('status', 'active')->where('plan_id','!=','0')->whereDay('created_at', '=', date('d'))
        ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->groupBy('plan_id')->get();

        $i=0;$dailylabel = '';$dailyseries ='';
        //echo "<pre>";
        //print_r($subscriptions);exit;
        foreach($subscriptions as $subscr)
        {
            $planname = Subscriptionplans::select('plan_name')->where('id',$subscr['plan_id'])->first();
            
            $dailylabel = $dailylabel . "'". $planname['plan_name'] ."',";
            //$dailyseries = $dailyseries .  "{meta: 'Revenue', value: ".$subscr['totalamt']."},";
            $dailyseries = $dailyseries .  "'".$subscr['totalamt']."',";
            
            //$dailyrev[$i]['plan_name'] = $subscr['plan_name'];
            //$dailyrev[$i]['amount'] = $subscr['totalamt'];
            //$i++;
        }
       
        $data['dailylabel'] = rtrim($dailylabel,',');
        $data['dailyseries'] = rtrim($dailyseries,',');


        $to = date('Y-m-d', strtotime('1 days'));
        $from =   date('Y-m-d', strtotime('-7 days'));
        $subscriptionsw = Subscriptions::select(DB::raw('sum(numlicence * amount) as totalamt'),'plan_id')->where('status', 'active')->where('plan_id','!=','0')->whereBetween('created_at', [$from, $to])->groupBy('plan_id')->get();

        $i=0;$dailylabelw = '';$dailyseriesw ='';
        //echo "<pre>";
        //print_r($subscriptionsw);exit;
        foreach($subscriptionsw as $subscr)
        {
            $planname = Subscriptionplans::select('plan_name')->where('id',$subscr['plan_id'])->first();
            
            $dailylabelw = $dailylabelw . "'". $planname['plan_name'] ."',";
            //$dailyseriesw = $dailyseriesw . "{meta: 'Revenue', value: ".$subscr['totalamt']."},";
            $dailyseriesw = $dailyseriesw . "'".$subscr['totalamt']."',";
            //$dailyrev[$i]['plan_name'] = $subscr['plan_name'];
            //$dailyrev[$i]['amount'] = $subscr['totalamt'];
            //$i++;
        }
       
        $data['dailylabelw'] = rtrim($dailylabelw,',');
        $data['dailyseriesw'] = rtrim($dailyseriesw,',');


        
        $subscriptionsm = Subscriptions::select(DB::raw('sum(numlicence * amount) as totalamt'),'plan_id')->where('status', 'active')->where('plan_id','!=','0')->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->groupBy('plan_id')->get();

        $i=0;$dailylabelm = '';$dailyseriesm ='';
        //echo "<pre>";
        //print_r($subscriptions);exit;
        foreach($subscriptionsm as $subscr)
        {
            $planname = Subscriptionplans::select('plan_name')->where('id',$subscr['plan_id'])->first();
            
            $dailylabelm = $dailylabelm . "'". $planname['plan_name'] ."',";
            //$dailyseriesm = $dailyseriesm . "{meta: 'Revenue', value: ".$subscr['totalamt']."},";
            $dailyseriesm = $dailyseriesm . "'".$subscr['totalamt']."',";
            //$dailyrev[$i]['plan_name'] = $subscr['plan_name'];
            //$dailyrev[$i]['amount'] = $subscr['totalamt'];
            //$i++;
        }
       
        $data['dailylabelm'] = rtrim($dailylabelm,',');
        $data['dailyseriesm'] = rtrim($dailyseriesm,',');


        /*$params1['select'] = ['transactions.*', 'rewards.reward_name',DB::raw('sum(transactions.price) as totalamt')];
        
        $params1['join'] = ['rewards,transactions.reward_id,=,rewards.id'];
        $params1['where'] = ['transactions.status'=>'paid'];
        $params1['group_by'] = ['transactions.reward_id'];
        $subscriptionsr = $this->transactionRepository->getByParams($params1);*/



        $ttlreedems = Transaction::select(DB::raw('sum(transactions.price) as totalamt'),'reward_id')->where('status','paid')->whereDay('created_at', '=', date('d'))
        ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->groupBy('reward_id')->get();
        $i=0;$dailylabelr = '';$dailyseriesr ='';
        foreach($ttlreedems as $subscr)
        {
           // echo "<pre>";print_r($subscr);exit;
           $product = Reward::select('reward_name')->where('id', $subscr['reward_id'])->first();
           if($product['reward_name'] != '' && $product['reward_name'] != null){
                 $dailylabelr = $dailylabelr . "'". $product['reward_name'] ."',";
                 //$dailyseriesr = $dailyseriesr . "{meta: 'Total Redemmed', value: ".$subscr['totalamt']."},";
                 $dailyseriesr = $dailyseriesr . "'".$subscr['totalamt']."',";
           }
            //$dailyrev[$i]['plan_name'] = $subscr['plan_name'];
            //$dailyrev[$i]['amount'] = $subscr['totalamt'];
            //$i++;
        }
        $data['dailylabelr'] = rtrim($dailylabelr,',');
        $data['dailyseriesr'] = rtrim($dailyseriesr,',');

        $ttlreedemsw = Transaction::select(DB::raw('sum(transactions.price) as totalamt'),'reward_id')->where('status','paid')->whereBetween('created_at', [$from, $to])->groupBy('reward_id')->get();
        
        $i=0;$dailylabelrw = '';$dailyseriesrw ='';
        foreach($ttlreedemsw as $subscr)
        {
           // echo "<pre>";print_r($subscr);exit;
           $product = Reward::select('reward_name')->where('id', $subscr['reward_id'])->first();
           if($product['reward_name'] != '' && $product['reward_name'] != null){
                 $dailylabelrw = $dailylabelrw . "'". $product['reward_name'] ."',";
                 //$dailyseriesrw = $dailyseriesrw . "{meta: 'Total Redemmed', value: ".$subscr['totalamt']."},";
                 $dailyseriesrw = $dailyseriesrw . "'".$subscr['totalamt']."',";
           }
           
        }
        $data['dailylabelrw'] = rtrim($dailylabelrw,',');
        $data['dailyseriesrw'] = rtrim($dailyseriesrw,',');


        

        $ttlreedemsm = Transaction::select(DB::raw('sum(transactions.price) as totalamt'),'reward_id')->where('status','paid')->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->groupBy('reward_id')->get();
        
        $i=0;$dailylabelrm = '';$dailyseriesrm ='';
        foreach($ttlreedemsm as $subscr)
        {
           // echo "<pre>";print_r($subscr);exit;
           $product = Reward::select('reward_name')->where('id', $subscr['reward_id'])->first();
           if($product['reward_name'] != '' && $product['reward_name'] != null){
                 $dailylabelrm = $dailylabelrm . "'". $product['reward_name'] ."',";
                 //$dailyseriesrm = $dailyseriesrm . "{meta: 'Total Redemmed', value: ".$subscr['totalamt']."},";
                 $dailyseriesrm = $dailyseriesrm . "'".$subscr['totalamt']."',";
           }
           
        }
        $data['dailylabelrm'] = rtrim($dailylabelrm,',');
        $data['dailyseriesrm'] = rtrim($dailyseriesrm,',');
           
        //Subscriptions::sum('numlicence' * 'amount');
        $data['activemembers'] = $activeMembers;
        $data['inactivemembers'] = $inactiveMembers;
        $data['submembers'] = $subMembers;
        $data['coinsreddmed'] = $coinsreddmed;
        $data['totalrevenue'] = $totalrevenue;
        $data['newMembers'] = $newMembers;
        $data['wellnessplans'] = $wellnessplans;
        $data['wellnessgoals'] = $wellnessgoals;


        return view('superadmin.dashboard', compact('newMembersList'), array(
                "userdata" => $userdata,
                "partnerdata" => $partnerdata,
                "data" => $data,
            )
        );
    }

    public function newuser()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('superadmin.adduser', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }
    /* Added By: Hima Shah
       For: Edit User View
       Date : 1st November 2022
    */

    public function edituser($id)
    {
        //echo $id;exit;
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $members = User::where('id', $id)->first();
        return view('superadmin.edituser', compact('members'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }
    
    /* Added By: Hima Shah
       For: Single User View
       Date : 1st November 2022
    */
    public function viewusers($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $members = User::where('id', $id)->first();
        return view('superadmin.viewusers', compact('members'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function userroles()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('superadmin.assignrole', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

     /* Modified By: Hima Shah
       For: Display all Users
       Date : 1st November 2022
    */
    public function userslist(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $members = Members::where('role', 'user')->orwhere('role', 'admin')->orwhere('role', 'manager')->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.userslist', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

     /* Added By: Hima Shah
       For: Export All Users
       Date : 1st November 2022
    */
    public function userslistexport(Request $request)
    {
        // Excel file name for download 
        $fileName = "users-data_" . date('Y-m-d') . ".xls"; 
 
        // Column names 
        $fields = array('Name', 'Gender', 'Email', 'Phone', 'Status'); 
                
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 

        $users = User::where('role', 'user')->get();

        if(isset($users)){
            foreach($users as $user){
                $status = ucwords(strtolower($user->status)); 
                $lineData = array($user->name, $user->gender, $user->email, $user->phone, $status); 
                $excelData .= implode("\t", array_values($lineData)) . "\n"; 
            }
        } else {
            $excelData .= 'No records found...'. "\n"; 
        }
        
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
        // Render excel data 
        echo $excelData; 
        
        exit;

    }
     /* Added By: Hima Shah
       For: Add/Update User Information
       Date : 1st November 2022
    */
    public function saveusers(Request $request)
    {
        
        if(!empty($request->id)) {           
            $this->validate(request(), [
                'name' => 'required|min:3|max:35',
                'email' => 'email|unique:users,email,'.$request->id,
                'phone' => 'required|digits:10|unique:users,phone,'.$request->id,
            ]);
           
        } else {
            $this->validate(request(), [
                'name' => 'required|min:3|max:35',
                'email' => 'email|unique:users,email',
                'phone' => 'required|digits:10|unique:users,phone',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);
        }
        $userdata = auth()->user();
       
        /* save merchant */
        $user = [];
        if(!empty($request->id)){
            $user['id'] = $request->id;
        }
        $user['name'] = ucwords(strtolower($request->name));
        $user['email'] = strtolower($request->email);
        $user['phone'] = $request->phone;
        $user['password'] = Hash::make($request->password);
        $user['user_id'] = $userdata->id;
        if(!empty($request->role)) {  
            $user['role'] = $request->role;
        }
        else{
            $user['role'] = 'user';
        }
        
        $user['status'] = 'active';
        $user['created_at'] = date("Y-m-d H:i:s");
        $addUser = $this->userRepository->save($user);
        
        if ($addUser) {
           
            if(!empty($request->id)){

                if(!empty($request->id)){
                    
                    $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Updated user by Admin';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);
                    $message = 'Record updated successfully.';
                } else {

                    
                    $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Added user by Admin';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

                    $message = 'Record added successfully.';
                }

                return redirect()->route('userslist')->with('success', $message);

             } else {
                $useremail = strtolower($request->email);
                $data = array(
                    'logo' => url('/public/assets/img/logo-psmas.png'),
                    'fullname' => ucwords(strtolower($request->name)),
                    'useremail' => $useremail,
                    'member' => 'user',
                );

                //code to send email to my inbox
                Mail::send('emails.newmember', $data, function($message) use ($data){
                    $message->from('admin@pulsehealth.com', 'Pulsehealth');
                    $message->to($data['useremail']);
                    $message->subject('Welcome to Pulsehealth');
                });

                if (Mail::failures()) { 
                    return redirect()->route('userslist')->with('success', 'Email sent failed!');
                } else { 
                    
                    if(!empty($request->id)){
                        $message = 'Record updated successfully.';
                    } else {
                        $message = 'Record added successfully.';
                    }
    
                    return redirect()->route('userslist')->with('success', $message);
                }
            }
        } else {
            return redirect()->back()->withErrors('Submission Failed')->withInput();
        }
    }

     /* Added By: Hima Shah
       For: Add User from excel File
       Date : 1st November 2022
    */

    public function saveusersFromImport(Request $request)
    {     
        if ($request->hasFile('importFile')) {
            try {
                Excel::import(new NewUsersImport,request()->file('importFile'));
                
                $message = 'Record added successfully.';
                return redirect()->route('userslist')->with('success', $message);

            } catch (\Exception $e) {
                $message = $e->getMessage(); //'Submission Failed.';
                return redirect()->route('userslist')->with('failed', $message);
            }
        }
    }

    public function partnerslist(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $members = Members::where('partner_id', $partner["id"])->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.partnerslist', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function serviceproviders(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $members = Members::where('partner_id', $partner["id"])->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.serviceproviders', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function loyaltypoints(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $members = Members::where('partner_id', $partner["id"])->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.loyaltypoints', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function pointsredeemed(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $members = Members::where('partner_id', $partner["id"])->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.loyaltypoints', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function manageservices(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $members = Members::where('partner_id', $partner["id"])->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.manageservice_providers', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function income(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $members = Members::where('partner_id', $partner["id"])->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.income', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function expenses(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $members = Members::where('partner_id', $partner["id"])->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.expenditure', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function subscribedpartners()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.subscribedpartners', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function newsubscriptions()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.newsubscriptions', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function subscriptions()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.subscriptions', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function addproduct()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.addproduct', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function productlist()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.productlist', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function manageproducts()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.manageproducts', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function subscribedpartnersreports()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.subscribedpartnersreports', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function newsubsreport()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.newsubsreport', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function incomereport()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.incomereports', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function expenditurereport()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.expenditurereport', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function loyaltypointsreport()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.expenditurereport', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function roles()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.rolesandpermission', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function integrate()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.integrate', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }
    
    public function newmerchant()
    {
        $userdata = auth()->user();
        
        $partner = $userdata->partner;

        //echo "<pre>"; print_r($partner); exit;

        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        //echo "<pre>"; print_r($partnerdata); exit;

        return view('superadmin.addmerchant', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function editmerchant($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        
        
        $merchant = User::where('id', $id)->where('role', 'merchant')->first();
        return view('superadmin.editmerchant', compact('merchant'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function merchantlist(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $merchants = User::where('role', 'merchant')->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.merchantlist', compact('merchants'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    
    public function merchantlistexport(Request $request)
    {
        // Excel file name for download 
        $fileName = "merchant-data_" . date('Y-m-d') . ".xls"; 
 
        // Column names 
        $fields = array('Name', 'Registration Number', 'Email', 'Phone', 'Status'); 
                
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 

        $merchants = User::where('role', 'merchant')->get();

        if(isset($merchants)){
            foreach($merchants as $merchant){
                $status = ucwords(strtolower($merchant->status)); 
                $lineData = array($merchant->name, $merchant->registrationNumber, $merchant->email, $merchant->phone, $status); 
                $excelData .= implode("\t", array_values($lineData)) . "\n"; 
            }
        } else {
            $excelData .= 'No records found...'. "\n"; 
        }
        
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
        // Render excel data 
        echo $excelData; 
        
        exit;

    }

    public function savemerchant(Request $request)
    {
      
        if(!empty($request->id)) {

            if (isset($request->directorId) && $request->directorId != '') {
                $directorIdreq = 'required|image|mimes:jpg,png,jpeg,gif,svg';
            } else {
                $merchant = User::where('id', $request->id)->where('role', 'merchant')->first();
                if(!empty($merchant->directorId)){
                    $directorIdreq = '';
                } else {
                    $directorIdreq = 'required|image|mimes:jpg,png,jpeg,gif,svg';
                }
            }

            if (isset($request->mouSigned) && $request->mouSigned != '') {
                $mouSignedreq = 'required|mimes:pdf';
            } else {
                $merchant = User::where('id', $request->id)->where('role', 'merchant')->first();
                if(!empty($merchant->mouSigned)){
                    $mouSignedreq = '';
                } else {
                    $mouSignedreq = 'required|mimes:pdf';
                }
            }
            
            $this->validate(request(), [
                'name' => 'required|min:3|max:35',
                'registrationNumber' => 'required|min:3|max:35|unique:users,registrationNumber,'.$request->id,
                'email' => 'email|unique:users,email,'.$request->id,
                'phone' => 'required|digits:10|unique:users,phone,'.$request->id,
                'directorName' => 'required|min:3|max:35',
                'directorId' => $directorIdreq,
                'registrationfee' => 'required',
                'mouSigned' => $mouSignedreq,
            ]);
           
        } else {
            $this->validate(request(), [
                'name' => 'required|min:3|max:35',
                'registrationNumber' => 'required|min:3|max:35|unique:users,registrationNumber',
                'email' => 'email|unique:users,email',
                'phone' => 'required|digits:10|unique:users,phone',
                'directorName' => 'required|min:3|max:35',
                'directorId' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                'registrationfee' => 'required',
                'mouSigned' => 'required|mimes:pdf',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);
        }
          
        if (isset($request->directorId) && $request->directorId != '') {
            $directorId = \App\Helpers\Helpers::uploadFile($request, 'directorId', public_path('/storage/directorid/original'));
        }

        if (isset($request->mouSigned) && $request->mouSigned != '') {
            $mouSigned = \App\Helpers\Helpers::uploadFile($request, 'mouSigned', public_path('/storage/mousigned/original'));
        }


        /* save merchant */
        $user = [];
        if(!empty($request->id)){
            $user['id'] = $request->id;
        }
        $user['name'] = ucwords(strtolower($request->name));
        $user['registrationNumber'] = $request->registrationNumber;
        $user['email'] = strtolower($request->email);
        $user['phone'] = $request->phone;
        $user['password'] = Hash::make($request->password);
        $user['directorName'] = $request->directorName;
        if(isset($directorId)){
            $user['directorId'] = $directorId;
        }
        if(isset($mouSigned)){
            $user['mouSigned'] = $mouSigned;
        }
        $user['registrationfee'] = $request->registrationfee;
        $user['paymentAcceptance'] = $request->paymentAcceptance;
        $user['role'] = 'merchant';
        $user['status'] = 'active';
        $user['created_at'] = date("Y-m-d H:i:s");
        $addUser = $this->userRepository->save($user);
        if ($addUser) {
            if(!empty($request->id)){
                $message = 'Record updated successfully.';
            } else {
                $message = 'Record added successfully.';
            }
            if(!empty($request->id)){ 
                $activtylog['user_id'] = Auth::user()->id;
                $activtylog['activity'] = 'Updated merchant';
                $activtylog['status'] = 'active';
                $activtylog['updated_at'] = date("Y-m-d H:i:s");
                $activtylogadded = $this->activitylogRepository->save($activtylog);

                return redirect()->route('merchantlist')->with('success', 'Email sent failed!');

            } else {
                $useremail = strtolower($request->email);
                $data = array(
                    'logo' => url('/public/assets/img/logo-psmas.png'),
                    'fullname' => ucwords(strtolower($request->name)),
                    'useremail' => $useremail,
                    'member' => 'merchant',
                );

                //code to send email to my inbox
                Mail::send('emails.newmember', $data, function($message) use ($data){
                    $message->from('admin@pulsehealth.com', 'Pulsehealth');
                    $message->to($data['useremail']);
                    $message->subject('Welcome to Pulsehealth');
                });

                if (Mail::failures()) { 
                    
                    $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Updated merchant';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

                    return redirect()->route('merchantlist')->with('success', 'Email sent failed!');
                } else {

                    
                    $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Added merchant';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

                    return redirect()->route('merchantlist')->with('success', $message);
                }
            }
                

           
        } else {
            return redirect()->back()->withErrors('Submission Failed')->withInput();
        }
    }

    public function savemerchantFromImport(Request $request)
    {     
        if ($request->hasFile('importFile')) {
            try {
                Excel::import(new MerchantImport,request()->file('importFile'));
                
                $message = 'Record added successfully.';
                return redirect()->route('merchantlist')->with('success', $message);

            } catch (\Exception $e) {
                $message = $e->getMessage(); //'Submission Failed.';
                return redirect()->route('merchantlist')->with('failed', $message);
            }
        }
    }

    public function viewmerchant($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $merchant = User::where('id', $id)->where('role', 'merchant')->first();
        return view('superadmin.viewmerchant', compact('merchant'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }
    
    public function newcorporate()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('superadmin.addcorporate', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function editcorporate($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $corporate = User::where('id', $id)->where('role', 'corporate')->first();
        return view('superadmin.editcorporate', compact('corporate'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function corporatelist(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $corporates = User::where('role', 'corporate')->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.corporatelist', compact('corporates'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    
    public function corporatelistexport(Request $request)
    {
        // Excel file name for download 
        $fileName = "client-data_" . date('Y-m-d') . ".xls"; 
 
        // Column names 
        $fields = array('Name', 'Registration Number', 'Email', 'Phone', 'Status'); 
                
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 

        $merchants = User::where('role', 'corporate')->get();

        if(isset($merchants)){
            foreach($merchants as $merchant){
                $status = ucwords(strtolower($merchant->status)); 
                $lineData = array($merchant->name, $merchant->registrationNumber, $merchant->email, $merchant->phone, $status); 
                $excelData .= implode("\t", array_values($lineData)) . "\n"; 
            }
        } else {
            $excelData .= 'No records found...'. "\n"; 
        }
        
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
        // Render excel data 
        echo $excelData; 
        
        exit;
    }

    public function savecorporate(Request $request)
    {
      
        if(!empty($request->id)) {

            if (isset($request->directorId) && $request->directorId != '') {
                $directorIdreq = 'required|image|mimes:jpg,png,jpeg,gif,svg';
            } else {
                $corporate = User::where('id', $request->id)->where('role', 'corporate')->first();
                if(!empty($corporate->directorId)){
                    $directorIdreq = '';
                } else {
                    $directorIdreq = 'required|image|mimes:jpg,png,jpeg,gif,svg';
                }
            }

            if (isset($request->mouSigned) && $request->mouSigned != '') {
                $mouSignedreq = 'required|mimes:pdf';
            } else {
                $corporate = User::where('id', $request->id)->where('role', 'corporate')->first();
                if(!empty($corporate->mouSigned)){
                    $mouSignedreq = '';
                } else {
                    $mouSignedreq = 'required|mimes:pdf';
                }
            }
            
            $this->validate(request(), [
                'name' => 'required|min:3|max:35',
                'registrationNumber' => 'required|min:3|max:35|unique:users,registrationNumber,'.$request->id,
                'email' => 'email|unique:users,email,'.$request->id,
                'phone' => 'required|digits:10|unique:users,phone,'.$request->id,
                'directorName' => 'required|min:3|max:35',
                'directorId' => $directorIdreq,
                'registrationfee' => 'required',
                'mouSigned' => $mouSignedreq,
            ]);
           
        } else {
            $this->validate(request(), [
                'name' => 'required|min:3|max:35',
                'registrationNumber' => 'required|min:3|max:35|unique:users,registrationNumber',
                'email' => 'email|unique:users,email',
                'phone' => 'required|digits:10|unique:users,phone',
                'directorName' => 'required|min:3|max:35',
                'directorId' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                'registrationfee' => 'required',
                'mouSigned' => 'required|mimes:pdf',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);
        }
          
        if (isset($request->directorId) && $request->directorId != '') {
            $directorId = \App\Helpers\Helpers::uploadFile($request, 'directorId', public_path('/storage/directorid/original'));
        }

        if (isset($request->mouSigned) && $request->mouSigned != '') {
            $mouSigned = \App\Helpers\Helpers::uploadFile($request, 'mouSigned', public_path('/storage/mousigned/original'));
        }


        /* save corporate */
        $user = [];
        if(!empty($request->id)){
            $user['id'] = $request->id;
        }
        $user['name'] = ucwords(strtolower($request->name));
        $user['firstname'] = ucwords(strtolower($request->name));
        $user['registrationNumber'] = $request->registrationNumber;
        $user['email'] = strtolower($request->email);
        $user['password'] = Hash::make($request->password);
        $user['phone'] = $request->phone;
        $user['directorName'] = $request->directorName;
        if(isset($directorId)){
            $user['directorId'] = $directorId;
        }
        if(isset($mouSigned)){
            $user['mouSigned'] = $mouSigned;
        }
        $user['registrationfee'] = $request->registrationfee;
        $user['paymentAcceptance'] = $request->paymentAcceptance;
        $user['role'] = 'corporate';
        $user['status'] = 'active';
        $user['created_at'] = date("Y-m-d H:i:s");
        $addUser = $this->userRepository->save($user);
        if ($addUser) {
            if(!empty($request->id)){

                $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Updated corporate';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);


                $message = 'Record updated successfully.';
            } else {

                $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Added corporate';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);


                $message = 'Record added successfully.';
            }

            
            if(!empty($request->id)){ 
                return redirect()->route('corporatelist')->with('success', 'Data updated.');

            } else {
                $useremail = strtolower($request->email);
                $data = array(
                    'logo' => url('/public/assets/img/logo-psmas.png'),
                    'fullname' => ucwords(strtolower($request->name)),
                    'useremail' => $useremail,
                    'member' => 'corporate',
                );

                //code to send email to my inbox
                Mail::send('emails.newmember', $data, function($message) use ($data){
                    $message->from('admin@pulsehealth.com', 'Pulsehealth');
                    $message->to($data['useremail']);
                    $message->subject('Welcome to Pulsehealth');
                });

                if (Mail::failures()) { 
                    return redirect()->route('corporatelist')->with('success', 'Email sent failed!');
                } else {
                    return redirect()->route('corporatelist')->with('success', $message);
                }
            }

            // return redirect()->route('corporatelist')->with('success', $message);
        } else {
            return redirect()->back()->withErrors('Submission Failed')->withInput();
        }
    }

    public function savecorporateFromImport(Request $request)
    {     
        if ($request->hasFile('importFile')) {
            
            try {
                Excel::import(new CorporateImport,request()->file('importFile'));

                $message = 'Record added successfully.';
                return redirect()->route('corporatelist')->with('success', $message);

            } catch (\Exception $e) {
                $message = $e->getMessage(); //'Submission Failed.';
                return redirect()->route('corporatelist')->with('failed', $message);
            }
        }
    }

    public function viewcorporate($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $corporate = User::where('id', $id)->where('role', 'corporate')->first();
        return view('superadmin.viewcorporate', compact('corporate'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function clients(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $users = User::select('users.*', 'corusers.name as corponame')->leftJoin('users as corusers', 'corusers.id', '=', 'users.corporate_id')->where('users.role', 'user')->get();
       
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.clients', compact('users', $users), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    
    public function clientsexport(Request $request)
    {
        // Excel file name for download 
        $fileName = "client-data_" . date('Y-m-d') . ".xls"; 
 
        // Column names 
        $fields = array('Member Id', 'Name', 'Email', 'Phone', 'Status'); 
                
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 

        $merchants = User::select('users.*', 'corusers.name as corponame')->leftJoin('users as corusers', 'corusers.id', '=', 'users.corporate_id')->where('users.role', 'user')->get();
       
        if(isset($merchants)){
            foreach($merchants as $merchant){
                $status = ucwords(strtolower($merchant->status)); 
                $lineData = array('PUL'.$merchant->id, $merchant->name, $merchant->email, $merchant->phone, $status); 
                $excelData .= implode("\t", array_values($lineData)) . "\n"; 
            }
        } else {
            $excelData .= 'No records found...'. "\n"; 
        }
        
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
        // Render excel data 
        echo $excelData; 
        
        exit;
    }

    
    public function viewclient($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        
        $user = User::select('users.*', 'corusers.name as corponame')->leftJoin('users as corusers', 'corusers.id', '=', 'users.corporate_id')->where('users.id', $id)->where('users.role', 'user')->first();

        $memberdata = $user;
        $member_id = $user->id;

        $bmiColor = "#82BE65";
        $bmiStatus = '';

        if ($memberdata->bmi < 18.5) {
            $bmiColor = "#FF3282";
            $bmiStatus = "Underweight";
        }
        if ($memberdata->bmi > 24.9) {
            $bmiColor = "#F6180E";
            $bmiStatus = "Overweight";
        }
        if ($memberdata->bmi >= 18.5 && $memberdata->bmi <= 24.9) {
            $bmiColor = "#82BE65";
            $bmiStatus = "Normal";
        }
        $progress = array(
            'steps' => 0,
            'calories' => 0,
            'distance' => 0,
            'weeklyGoals' => 0
        );
        
        $allActivities = Activitydetails::where('user_id', $member_id)->orderBy('id', 'desc')->get();
        $dailyTargets = array();
        $trainingProgram = AssignGoal::where('partner_id', $partner->id)
            ->where('user_id', $member_id)
            ->first();

        if ($trainingProgram && $trainingProgram->training_program_id)
            $dailyTargets = DB::table('core_par_goals')->find($trainingProgram->training_program_id);
        elseif ($trainingProgram && $trainingProgram->goal_id) {
            $dailyTargets = PartnerMasterGoals::find($trainingProgram->goal_id);
            if (!defined('STEPS_TARGET') && !defined('CALORIES_TARGET') && !defined('DISTANCE_TARGET')) {
                $dailyTargets->goal_type === 'steps' ? define('STEPS_TARGET', $dailyTargets->required_target) : define('STEPS_TARGET', 10000);
                $dailyTargets->goal_type === 'distance' ? define('DISTANCE_TARGET', $dailyTargets->required_target) : define('DISTANCE_TARGET', 10);
                $dailyTargets->goal_type === 'calories' ? define('CALORIES_TARGET', $dailyTargets->required_target) : define('CALORIES_TARGET', 1000);
            }
        } else {
            define('STEPS_TARGET', 10000);
            define('DISTANCE_TARGET', 10);
            define('CALORIES_TARGET', 1000);
        }
        if (isset($dailyTargets)) {
            if (!defined('STEPS_TARGET'))
                define('STEPS_TARGET', $dailyTargets->steps);
            if (!defined('DISTANCE_TARGET'))
                define('DISTANCE_TARGET', $dailyTargets->distance);
            if (!defined('CALORIES_TARGET'))
                define('CALORIES_TARGET', $dailyTargets->calories);
        } else {
            define('STEPS_TARGET', 10000);
            define('DISTANCE_TARGET', 10);
            define('CALORIES_TARGET', 1000);
        }

        $DailyStepCounts = DailyStepCount::where('userid', $member_id)->orderBy('id', 'desc')->get();
        foreach ($DailyStepCounts as $DailyStepCount) {
            $activityDate = strtotime($DailyStepCount->created_at);
            if (date('Y-m-d', $activityDate) === Carbon::now()->format('Y-m-d')) {
                $progress['steps'] += $DailyStepCount->steps;
                $progress['calories'] += $DailyStepCount->calories;
                $progress['distance'] += $DailyStepCount->distance;
            }
        }
        $weeklyActivities = array(
            'Mon' => [],
            'Tue' => [],
            'Wed' => [],
            'Thu' => [],
            'Fri' => [],
            'Sat' => [],
            'Sun' => [],
        );
        $goals = array(
            'Mon' => ['steps' => 0, 'calories' => 0, 'distance' => 0], 'Tue' => ['steps' => 0, 'calories' => 0, 'distance' => 0],
            'Wed' => ['steps' => 0, 'calories' => 0, 'distance' => 0], 'Thu' => ['steps' => 0, 'calories' => 0, 'distance' => 0],
            'Fri' => ['steps' => 0, 'calories' => 0, 'distance' => 0], 'Sat' => ['steps' => 0, 'calories' => 0, 'distance' => 0],
            'Sun' => ['steps' => 0, 'calories' => 0, 'distance' => 0],
        );

        foreach ($allActivities as $activity) {
            $activityDate = strtotime($activity->created_at);
            if (date('Y-m-d', $activityDate) >= Carbon::now()->startOfWeek()->format('Y-m-d') && date('Y-m-d',
                    $activityDate) <= Carbon::now()->endOfWeek()->format('Y-m-d')) {
                $goals[Carbon::parse($activityDate)->format('D')]['steps'] += $activity->steps;
                $goals[Carbon::parse($activityDate)->format('D')]['calories'] += $activity->calories;
                $goals[Carbon::parse($activityDate)->format('D')]['distance'] += $activity->distance;

                $goals[Carbon::parse($activityDate)->format('D')]['steps'] = $goals[Carbon::parse
                ($activityDate)->format('D')]['steps'] >= STEPS_TARGET ? intval(STEPS_TARGET) :
                    $goals[Carbon::parse
                    ($activityDate)->format('D')]['steps'];

                $goals[Carbon::parse($activityDate)->format('D')]['calories'] = $goals[Carbon::parse
                ($activityDate)->format('D')]['calories'] >= CALORIES_TARGET ? intval(CALORIES_TARGET) :
                    $goals[Carbon::parse
                    ($activityDate)->format('D')]['calories'];

                $goals[Carbon::parse($activityDate)->format('D')]['distance'] = $goals[Carbon::parse
                ($activityDate)->format('D')]['distance'] >= DISTANCE_TARGET ? intval(DISTANCE_TARGET) :
                    $goals[Carbon::parse
                    ($activityDate)->format('D')]['distance'];

            }
        }
        define('WEEKLY_GOALS_TARGET', 2100);
        $weeklyGoalsCompleted = 0;
        foreach ($goals as $goal) {
            $progress['weeklyGoals'] += intval(($goal['steps'] / STEPS_TARGET * 100) + ($goal['calories'] /
                    CALORIES_TARGET * 100) + ($goal['distance'] / DISTANCE_TARGET * 100));
        }
        
        //$allActivities = Activitydetails::where('user_id', $member_id)->orderBy('id', 'desc')->get();
        return view('superadmin.viewclient', compact('user', 'member_id', 'memberdata', 'bmiStatus', 'bmiColor', 'allActivities'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata,
            'progress' => $progress,
            'CALORIES_TARGET' => CALORIES_TARGET,
            'DISTANCE_TARGET' => DISTANCE_TARGET,
            'STEPS_TARGET' => STEPS_TARGET,
            'WEEKLY_GOALS_TARGET' => WEEKLY_GOALS_TARGET,
            'weeklyActivities' => $weeklyActivities,
            'weeklyGoalsCompleted' => $weeklyGoalsCompleted
        ));
    }

    public function editclient($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $user = User::where('id', $id)->where('role', 'user')->first();
        return view('superadmin.editclient', compact('user'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    
    public function userstatus(Request $request)
    {
        $user = [];
        if(!empty($request->id)){
            $user['id'] = $request->id;
        }
        $user['status'] = $request->status;

        // $product = Reward::where('id', $request->id)->first();
        $userdata = User::where('id', $request->id)->first();

        $useremail = strtolower($userdata->email);
        $data = array(
            'logo' => url('/public/assets/img/logo-psmas.png'),
            'fullname' => ucwords(strtolower($userdata->name)),
            'useremail' => $useremail,
            'userstatus' => ucwords(strtolower($request->status)),
        );

        //code to send email to my inbox
        Mail::send('emails.userstatus', $data, function($message) use ($data){
            $message->from('admin@pulsehealth.com', 'Pulsehealth');
            $message->to($data['useremail']);
            $message->subject('Your login status update on Pulsehealth');
        });
       
        $addUser = $this->userRepository->save($user);

        $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Updated user status';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

        return '1';
    }



    //Partner


    
    public function newpartner()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('superadmin.addpartner', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function editpartner($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $partner = User::where('id', $id)->where('role', 'partner')->first();
        return view('superadmin.editpartner', compact('partner'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function partnerlist(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $partners = User::where('role', 'partner')->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.partnerlist', compact('partners'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function partnerlistexport(Request $request)
    {
        // Excel file name for download 
        $fileName = "partner-data_" . date('Y-m-d') . ".xls"; 
 
        // Column names 
        $fields = array('Name', 'Trading Name', 'Business Type', 'Email', 'Phone', 'Status'); 
                
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 

        $merchants = User::where('role', 'partner')->get();

        if(isset($merchants)){
            foreach($merchants as $merchant){
                $status = ucwords(strtolower($merchant->status)); 
                $lineData = array($merchant->name, $merchant->partnerTradingName, $merchant->businessType, $merchant->email, $merchant->phone, $status); 
                $excelData .= implode("\t", array_values($lineData)) . "\n"; 
            }
        } else {
            $excelData .= 'No records found...'. "\n"; 
        }
        
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        
        // Render excel data 
        echo $excelData; 
        
        exit;

    }

    public function savepartner(Request $request)
    {
        if(!empty($request->id)) {

            if (isset($request->directorId) && $request->directorId != '') {
                $directorIdreq = 'required|image|mimes:jpg,png,jpeg,gif,svg';
            } else {
                $merchant = User::where('id', $request->id)->where('role', 'partner')->first();
                if(!empty($merchant->directorId)){
                    $directorIdreq = '';
                } else {
                    $directorIdreq = 'required|image|mimes:jpg,png,jpeg,gif,svg';
                }
            }

            if (isset($request->CR14form) && $request->CR14form != '') {
                $CR14formreq = 'required|mimes:pdf';
            } else {
                $merchant = User::where('id', $request->id)->where('role', 'partner')->first();
                if(!empty($merchant->CR14form)){
                    $CR14formreq = '';
                } else {
                    $CR14formreq = 'required|mimes:pdf';
                }
            }
            
            if (isset($request->certificateOfIncorporation) && $request->certificateOfIncorporation != '') {
                $certificateOfIncorporationreq = 'required|mimes:pdf';
            } else {
                $merchant = User::where('id', $request->id)->where('role', 'partner')->first();
                if(!empty($merchant->certificateOfIncorporation)){
                    $certificateOfIncorporationreq = '';
                } else {
                    $certificateOfIncorporationreq = 'required|mimes:pdf';
                }
            }

            $this->validate(request(), [
                'name' => 'required|min:3|max:35','email' => 'email|unique:users,email,'.$request->id,
                'phone' => 'required|digits:10|unique:users,phone,'.$request->id,
                'partnerTradingName' => 'required|min:3|max:35',
                'businessType' => 'required|min:3|max:35',
                'partnerTradingDetails' => 'required|min:3|max:35',
                'propertyNumber' => 'required|min:3|max:35',
                'streetName' => 'required|min:3|max:35',
                'suburb' => 'required|min:3|max:35',
                'bankName' => 'required|min:3|max:35',
                'accountNumber' => 'required|min:3|max:35',
                'branchName' => 'required|min:3|max:35',
                'branchCode' => 'required|min:3|max:35',
                'directorId' => $directorIdreq,
                'CR14form' => $CR14formreq,
                'certificateOfIncorporation' => $certificateOfIncorporationreq,
            ]);
           
        } else {
            $this->validate(request(), [
                'name' => 'required|min:3|max:35','email' => 'email|unique:users,email,'.$request->id,
                'phone' => 'required|digits:10|unique:users,phone,'.$request->id,
                'partnerTradingName' => 'required|min:3|max:35',
                'businessType' => 'required|min:3|max:35',
                'partnerTradingDetails' => 'required|min:3|max:35',
                'propertyNumber' => 'required|min:3|max:35',
                'streetName' => 'required|min:3|max:35',
                'suburb' => 'required|min:3|max:35',
                'bankName' => 'required|min:3|max:35',
                'accountNumber' => 'required|min:3|max:35',
                'branchName' => 'required|min:3|max:35',
                'branchCode' => 'required|min:3|max:35',
                'directorId' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                'CR14form' => 'required|mimes:pdf',
                'certificateOfIncorporation' => 'required|mimes:pdf',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);
        }
          
        if (isset($request->directorId) && $request->directorId != '') {
            $directorId = \App\Helpers\Helpers::uploadFile($request, 'directorId', public_path('/storage/directorid/original'));
        }

        if (isset($request->CR14form) && $request->CR14form != '') {
            $CR14form = \App\Helpers\Helpers::uploadFile($request, 'CR14form', public_path('/storage/CR14form/original'));
        }

        if (isset($request->certificateOfIncorporation) && $request->certificateOfIncorporation != '') {
            $certificateOfIncorporation = \App\Helpers\Helpers::uploadFile($request, 'certificateOfIncorporation', public_path('/storage/certificateOfIncorporation/original'));
        }


        /* save merchant */
        $user = [];
        if(!empty($request->id)){
            $user['id'] = $request->id;
        }
        $user['name'] = ucwords(strtolower($request->name));
        $user['email'] = strtolower($request->email);
        $user['phone'] = $request->phone;
        $user['password'] = Hash::make($request->password);
        $user['partnerTradingName'] = $request->partnerTradingName;
        $user['accountNumber'] = $request->accountNumber;
        $user['businessType'] = $request->businessType;
        $user['partnerTradingDetails'] = $request->partnerTradingDetails;
        $user['propertyNumber'] = $request->propertyNumber;
        $user['streetName'] = $request->streetName;
        $user['suburb'] = $request->suburb;
        $user['bankName'] = $request->bankName;
        $user['branchName'] = $request->branchName;
        $user['branchCode'] = $request->branchCode;
        if(isset($directorId)){
            $user['directorId'] = $directorId;
        }
        if(isset($CR14form)){
            $user['CR14form'] = $CR14form;
        }
        if(isset($certificateOfIncorporation)){
            $user['certificateOfIncorporation'] = $certificateOfIncorporation;
        }
        $user['role'] = 'partner';
        $user['status'] = 'active';
        $user['created_at'] = date("Y-m-d H:i:s");
        $addUser = $this->userRepository->save($user);
        if ($addUser) {
            if(!empty($request->id)){
                $message = 'Record updated successfully.';
            } else {
                $message = 'Record added successfully.';
            }

            if(!empty($request->id)){ 

                if(!empty($request->id)){
                    $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Updated partner';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

                    $message = 'Record updated successfully.';
                } else {

                    $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Added partner';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);


                    $message = 'Record added successfully.';
                }
                return redirect()->route('partnerlist')->with('success', $message);

            } else {
                $useremail = strtolower($request->email);
                $data = array(
                    'logo' => url('/public/assets/img/logo-psmas.png'),
                    'fullname' => ucwords(strtolower($request->name)),
                    'useremail' => $useremail,
                    'member' => 'partner',
                );

                //code to send email to my inbox
                Mail::send('emails.newmember', $data, function($message) use ($data){
                    $message->from('admin@pulsehealth.com', 'Pulsehealth');
                    $message->to($data['useremail']);
                    $message->subject('Welcome to Pulsehealth');
                });

                if (Mail::failures()) { 
                    return redirect()->route('partnerlist')->with('success', 'Email sent failed!');
                } else {
                    if(!empty($request->id)){
                        $message = 'Record updated successfully.';
                    } else {
                        $message = 'Record added successfully.';
                    }
                    return redirect()->route('partnerlist')->with('success', $message);
                }
            }
        } else {
            return redirect()->back()->withErrors('Submission Failed')->withInput();
        }
    }

    public function savepartnerFromImport(Request $request)
    {     
        if ($request->hasFile('importFile')) {
            
            try {
                Excel::import(new UsersImport,request()->file('importFile'));

                $message = 'Record added successfully.';
                return redirect()->route('partnerlist')->with('success', $message);

            } catch (\Exception $e) {
                $message = $e->getMessage(); //'Submission Failed.';
                return redirect()->route('partnerlist')->with('failed', $message);
            }
        }
    }

    public function viewpartner($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $partner = User::where('id', $id)->where('role', 'partner')->first();
        return view('superadmin.viewpartner', compact('partner'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }


    

    //subscriptions


    
    public function newsubscription()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('superadmin.addsubscription', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function editsubscription($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $partner = Subscriptionplans::where('id', $id)->first();
        return view('superadmin.editsubscription', compact('partner'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function subscriptionlist(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $subscriptions = Subscriptionplans::get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.subscriptionlist', compact('subscriptions'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function savesubscription(Request $request)
    {
      
            $this->validate(request(), [
                'plan_name' => 'required|min:3|max:35',
                'amount' => 'required',
                'description' => 'required|min:3',
                'days' => 'required',
            ]);
        
       

        /* save merchant */
        $user = [];
        if(!empty($request->id)){
            $user['id'] = $request->id;
        }
        $user['plan_name'] = $request->plan_name;
        $user['amount'] = $request->amount;
        $user['description'] = $request->description;
        $user['days'] = $request->days;
        $user['created_at'] = date("Y-m-d H:i:s");
        $addUser = $this->subscriptionplansRepository->save($user);
        if ($addUser) {
            if(!empty($request->id)){

                $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Subscription plan updated';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

                $message = 'Record updated successfully.';
            } else {

                $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Subscription plan added';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

                $message = 'Record added successfully.';
            }

           return redirect()->route('subscriptionlist')->with('success', $message);

            
        } else {
            return redirect()->back()->withErrors('Submission Failed')->withInput();
        }
    }

    public function viewsubscription($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $partner = Subscriptionplans::where('id', $id)->first();
        return view('superadmin.viewsubscription', compact('partner'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function userwellness(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $users = User::select('users.*', 'wellnessuser.plan_data')->leftJoin('user_wellness_plans as wellnessuser', 'wellnessuser.user_id', '=', 'users.id')->where('wellnessuser.status', '1')->get();
       
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.userwellness', compact('users', $users), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    
    public function viewwellness($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        
        $user = User::select('users.*', 'wellnessuser.plan_data')->leftJoin('user_wellness_plans as wellnessuser', 'wellnessuser.user_id', '=', 'users.id')->where('users.id', $id)->where('wellnessuser.status', '1')->first();
       
        if(isset($user->plan_data)){
            $plan_data = $user->plan_data;
            $plan_dataa = (json_decode($plan_data));  
        } else {
            $plan_dataa = '';
        }
     
        return view('superadmin.viewwellness', compact('user', 'plan_dataa'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function activitylogs(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        if(Auth::user()->role == 'merchant'){
            $activitylogs = Activitylog::select('activity_logs.*', 'users.name')->where('activity_logs.user_id', Auth::user()->id)->leftJoin('users', 'users.id', '=', 'activity_logs.user_id')->get();
        } elseif(Auth::user()->role == 'partner'){
            $activitylogs = Activitylog::select('activity_logs.*', 'users.name')->where('activity_logs.user_id', Auth::user()->id)->leftJoin('users', 'users.id', '=', 'activity_logs.user_id')->get();
        } elseif(Auth::user()->role == 'corporate'){
            $activitylogs = Activitylog::select('activity_logs.*', 'users.name')->where('activity_logs.user_id', Auth::user()->id)->leftJoin('users', 'users.id', '=', 'activity_logs.user_id')->get();
        } else {
            $activitylogs = Activitylog::select('activity_logs.*', 'users.name')->leftJoin('users', 'users.id', '=', 'activity_logs.user_id')->get();
        }
       
       
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.activitylogs', compact('activitylogs', $activitylogs), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function allsubscription(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $params['select'] = ['subscriptions.*', 'subscription_plans.plan_name', 'users.name as uname', 'users.role as urole','users.phone as phne','users.email as eml'];
        $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id','users,users.id,=,subscriptions.user_id'];
        $subscriptions = $this->subscriptionsRepository->getByParams($params);

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.allsubscription', compact('subscriptions', $subscriptions), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function assignsubscription(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $users = User::where('role', '=', 'partner')->Orwhere('role', '=', 'corporate')->get();
        $subscriptions = Subscriptionplans::get();

       
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.assignsubscription', compact('users', 'subscriptions'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function saveassignsub(Request $request)
    {
            $this->validate(request(), [
                'user_id' => 'required',
                'numlicence' => 'required',
                'current_period_start' => 'required',
                'current_period_end' => 'required',
                'plan_id' => 'required',
            ]);
        
        $plan = Subscriptionplans::where('id', $request->plan_id)->first();
            if($request->amount){
                $amount = $request->amount;
            } else {
                $amount = $plan->amount;
            }
        /* save merchant */
        $user = [];
      
        $user['user_id'] = $request->user_id;
        $user['numlicence'] = $request->numlicence;
        $user['amount'] = $amount;
        $user['current_period_start'] = $request->current_period_start;
        $user['current_period_end'] = $request->current_period_end;
        $user['plan_id'] = $request->plan_id;
        $user['created_at'] = date("Y-m-d H:i:s");
        $user['status'] = 'active';
        $addUser = $this->subscriptionsRepository->save($user);
        if ($addUser) {
            if(!empty($request->id)){
                $message = 'Record updated successfully.';
            } else {
                $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Assign subscriptio';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

                 
                $message = 'Record added successfully.';
            }

           return redirect()->route('allsubscription')->with('success', $message);

            
        } else {
            return redirect()->back()->withErrors('Submission Failed')->withInput();
        }
    }

    public function revenuereport(Request $request)
    {
        //        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);

        $params = array();
        $params['select'] = [\DB::raw('count(subscriptions.id) as totalcount,subscriptions.*,subscription_plans.plan_name,users.name as uname,users.role as urole')];
        $params['where'] = ['users.role'=>'partner', 'subscriptions.status'=>'active'];
        $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id','users,users.id,=,subscriptions.user_id'];
        $params['group_by'] = ['users.role'];
        $subscriptionspartner = $this->subscriptionsRepository->getByParams($params);
        if(empty($subscriptionspartner[0])){
            $totalpartner = 0;
        } else {
            $totalpartner = $subscriptionspartner[0]->totalcount;
        }
        
        $params = array();
        $params['select'] = [\DB::raw('sum(subscriptions.amount * subscriptions.numlicence) as totalamount,subscriptions.*,subscription_plans.plan_name,users.name as uname,users.role as urole')];
        $params['where'] = ['users.role'=>'partner', 'subscriptions.status'=>'active'];
        $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id','users,users.id,=,subscriptions.user_id'];
        $params['group_by'] = ['users.role'];
        $subscriptionspartneramout = $this->subscriptionsRepository->getByParams($params);
        if(empty($subscriptionspartneramout[0])){
            $totalpartnersm = 0;
        } else {
            $totalpartnersm = $subscriptionspartneramout[0]->totalamount;
        }

        $params = array();
        $params['select'] = [\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,subscription_plans.plan_name,users.name as uname,users.role as urole')];
        $params['where'] = ['users.role'=>'partner', 'subscriptions.status'=>'active'];
        $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id','users,users.id,=,subscriptions.user_id'];
        $params['group_by'] = ['users.role'];
        $subscriptionspartnerlice = $this->subscriptionsRepository->getByParams($params);
        if(empty($subscriptionspartnerlice[0])){
            $totalpartnerlic = 0;
        } else {
            $totalpartnerlic = $subscriptionspartnerlice[0]->totalnumlicence;
        }
        

        $params = array();
        $params['select'] = [\DB::raw('count(subscriptions.id) as totalcount,subscriptions.*,subscription_plans.plan_name,users.name as uname,users.role as urole')];
        $params['where'] = ['users.role'=>'corporate', 'subscriptions.status'=>'active'];
        $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id','users,users.id,=,subscriptions.user_id'];
        $params['group_by'] = ['users.role'];
        $subscriptionscorporate = $this->subscriptionsRepository->getByParams($params);
        if(empty($subscriptionscorporate[0])){
            $totalcorporate = 0;
        } else {
            $totalcorporate = $subscriptionscorporate[0]->totalcount;
        }

        $params = array();
        $params['select'] = [\DB::raw('sum(subscriptions.amount * subscriptions.numlicence) as totalamount,subscriptions.*,subscription_plans.plan_name,users.name as uname,users.role as urole')];
        $params['where'] = ['users.role'=>'corporate', 'subscriptions.status'=>'active'];
        $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id','users,users.id,=,subscriptions.user_id'];
        $params['group_by'] = ['users.role'];
        $subscriptionscorporateamout = $this->subscriptionsRepository->getByParams($params);
        if(empty($subscriptionscorporateamout[0])){
            $totalcorporatesm = 0;
        } else {
            $totalcorporatesm = $subscriptionscorporateamout[0]->totalamount;
        }

        

        $params = array();
        $params['select'] = [\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,subscription_plans.plan_name,users.name as uname,users.role as urole')];
        $params['where'] = ['users.role'=>'corporate', 'subscriptions.status'=>'active'];
        $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id','users,users.id,=,subscriptions.user_id'];
        $params['group_by'] = ['users.role'];
        $subscriptionscorporatelice = $this->subscriptionsRepository->getByParams($params);
        if(empty($subscriptionscorporatelice[0])){
            $totalcorporatelic = 0;
        } else {
            $totalcorporatelic = $subscriptionscorporatelice[0]->totalnumlicence;
        }
        
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        $totalam = $totalpartnersm + $totalcorporatesm;

          

        // $params = array();
        // $params['select'] = [\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt,subscription_plans.plan_name,users.name as uname,users.role as urole')];
        // $params['where'] = ['subscriptions.created_at'=>' >= DATE(NOW() - INTERVAL 7 DAY)', 'subscriptions.status'=>'active'];
        // // $params['whereNot'] = ['subscriptions.plan_id'=>'0'];
        // $params['join'] = ['subscription_plans,subscriptions.plan_id,=,subscription_plans.id','users,users.id,=,subscriptions.user_id'];
        // $params['group_by'] = ['datt'];
        // $subscriptionscorporatelicett = $this->subscriptionsRepository->getByParams($params, 1);

        // dd($subscriptionscorporatelicett);
        // if(empty($subscriptionscorporatelicett[0])){
        //     $totalcorporatelic = 0;
        // } else {
        //     $totalcorporatelic = $subscriptionscorporatelicett;
        // }
        
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        $totalam = $totalpartnersm + $totalcorporatesm;

        $corporates = User::where('role', 'corporate')->count();
        $partners = User::where('role', 'partner')->count();
        $merchants = User::where('role', 'merchant')->count();
        $users = User::where('role', 'user')->count();

        // dd($subscriptionscorporatelicett);

        // $befdate = date('Y-m-d H:i:s', strtotime('-7 days'));
        $befdate7 = date('Y-m-d', strtotime('-7 days'));
        $befdate6 = date('Y-m-d', strtotime('-6 days'));
        $befdate5 = date('Y-m-d', strtotime('-5 days'));
        $befdate4 = date('Y-m-d', strtotime('-4 days'));
        $befdate3 = date('Y-m-d', strtotime('-3 days'));
        $befdate2 = date('Y-m-d', strtotime('-2 days'));
        $befdate1 = date('Y-m-d', strtotime('-1 days'));
        $befdate11 = date('Y-m-d');
        
        $one = $befdate7;
        $two = $befdate6;
        $three = $befdate5;
        $four = $befdate4;
        $five = $befdate3;
        $six = $befdate2;
        $seven = $befdate1;
        $eight = $befdate11;

        
        $subscriptionscorporatelicett7 = DB::table('subscriptions')
            ->select(\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt'))
            ->where(\DB::raw('DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d")'), '=',  $befdate7)
            ->where('subscriptions.status', '=',  'active')
            ->groupBy('datt')
            ->get();
            
        $subscriptionscorporatelicett6 = DB::table('subscriptions')
            ->select(\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt'))
            ->where(\DB::raw('DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d")'), '=',  $befdate6)
            ->where('subscriptions.status', '=',  'active')
            ->groupBy('datt')
            ->get();
            
        $subscriptionscorporatelicett5 = DB::table('subscriptions')
            ->select(\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt'))
            ->where(\DB::raw('DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d")'), '=',  $befdate5)
            ->where('subscriptions.status', '=',  'active')
            ->groupBy('datt')
            ->get();
            
        $subscriptionscorporatelicett4 = DB::table('subscriptions')
                ->select(\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt'))
                ->where(\DB::raw('DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d")'), '=',  $befdate4)
                ->where('subscriptions.status', '=',  'active')
                ->groupBy('datt')
                ->get();
        
            
        $subscriptionscorporatelicett3 = DB::table('subscriptions')
                ->select(\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt'))
                ->where(\DB::raw('DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d")'), '=',  $befdate3)
                ->where('subscriptions.status', '=',  'active')
                ->groupBy('datt')
                ->get();
    
        $subscriptionscorporatelicett2 = DB::table('subscriptions')
                ->select(\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt'))
                ->where(\DB::raw('DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d")'), '=',  $befdate2)
                ->where('subscriptions.status', '=',  'active')
                ->groupBy('datt')
                ->get();

            
        $subscriptionscorporatelicett1 = DB::table('subscriptions')
                ->select(\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt'))
                ->where(\DB::raw('DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d")'), '=',  $befdate1)
                ->where('subscriptions.status', '=',  'active')
                ->groupBy('datt')
                ->get();

            
        $subscriptionscorporatelicett11 = DB::table('subscriptions')
                        ->select(\DB::raw('sum(subscriptions.numlicence) as totalnumlicence,subscriptions.*,DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d") as datt'))
                        ->where(\DB::raw('DATE_FORMAT(subscriptions.created_at, "%Y-%m-%d")'), '=',  $befdate11)
                        ->where('subscriptions.status', '=',  'active')
                        ->groupBy('datt')
                        ->get();


        $onev = isset($subscriptionscorporatelicett7[0]) ? $subscriptionscorporatelicett7[0]->totalnumlicence : 0;
        $twov = isset($subscriptionscorporatelicett6[0]) ? $subscriptionscorporatelicett6[0]->totalnumlicence : 0;
        $threev = isset($subscriptionscorporatelicett5[0]) ? $subscriptionscorporatelicett5[0]->totalnumlicence : 0;
        $fourv = isset($subscriptionscorporatelicett4[0]) ? $subscriptionscorporatelicett4[0]->totalnumlicence : 0;
        $fivev = isset($subscriptionscorporatelicett3[0]) ? $subscriptionscorporatelicett3[0]->totalnumlicence : 0;
        $sixv = isset($subscriptionscorporatelicett2[0]) ? $subscriptionscorporatelicett2[0]->totalnumlicence : 0;
        $sevenv = isset($subscriptionscorporatelicett1[0]) ? $subscriptionscorporatelicett1[0]->totalnumlicence : 0;
        $eightv = isset($subscriptionscorporatelicett11[0]) ? $subscriptionscorporatelicett11[0]->totalnumlicence : 0;

        return view('superadmin.revenuereport', [
            "userdata" => $userdata,  "partnerdata" => $partnerdata, "subscriptionscorporate" => $totalcorporate,  "subscriptionspartner" => $totalpartner,  "totalpartnersm" => $totalpartnersm,  "totalcorporatesm" => $totalcorporatesm,  "totalam" => $totalam,  "corporates" => $corporates,  "partners" => $partners,  "merchants" => $merchants,  "users" => $users,  "totalcorporatelic" => $totalcorporatelic,  "totalpartnerlic" => $totalpartnerlic, "one" => $one, "two" => $two, "three" => $three, "four" => $four, "five" => $five, "six" => $six, "seven" => $seven, "eight" => $eight, "onev" => $onev, "twov" => $twov, "threev" => $threev, "fourv" => $fourv, "fivev" => $fivev, "sixv" => $sixv, "sevenv" => $sevenv, "eightv" => $eightv
        ]);
    }

      
    public function changepartnerstatus(Request $request)
    {
        $user = [];
        if(!empty($request->id)){
            $user['id'] = $request->id;
        }
        $user['status'] = $request->status;

        // $product = Reward::where('id', $request->id)->first();
        $userdata = User::where('id', $request->id)->first();

        $useremail = strtolower($userdata->email);
        $data = array(
            'logo' => url('/public/assets/img/logo-psmas.png'),
            'fullname' => ucwords(strtolower($userdata->name)),
            'useremail' => $useremail,
            'userstatus' => ucwords(strtolower($request->status)),
        );

        //code to send email to my inbox
        Mail::send('emails.userstatus', $data, function($message) use ($data){
            $message->from('admin@pulsehealth.com', 'Pulsehealth');
            $message->to($data['useremail']);
            $message->subject('Your login status update on Pulsehealth');
        });
       
        $addUser = $this->userRepository->save($user);

        $activtylog['user_id'] = Auth::user()->id;
        $activtylog['activity'] = 'Updated user status';
        $activtylog['status'] = 'active';
        $activtylog['updated_at'] = date("Y-m-d H:i:s");
        $activtylogadded = $this->activitylogRepository->save($activtylog);

        return '1';
    }

    public function memberreportsadmin()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $members = Members::orderBy('id', 'desc')->get();

        $active = [
            "runners" => 0,
            "walkers" => 0,
            "cyclers" => 0
        ];
        $activities = Activities::where('partner_id', $partner->id)
            ->where('created_at', '>=', date('d-M-Y 00:00:00'))
            ->where('created_at', '<=', date('d-M-Y 23:59:59'))
            ->get();

        foreach ($activities as $activity) {
            if (strtolower($activity->activity) === 'running')
                $active['runners'] += 1;
            if (strtolower($activity->activity) === 'walking')
                $active['walkers'] += 1;
            if (strtolower($activity->activity) === 'cycling')
                $active['cyclers'] += 1;
        }

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.memberreportsadmin', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata,
            "members" => $members,
            "active" => $active
        ));
    }

    public function activityreportsadmin(Request $request)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $active = [
            "runners" => 0,
            "walkers" => 0,
            "cyclers" => 0
        ];

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }

        $allActivities = Activitydetails::select(\DB::raw('FORMAT (activity_details.kcals, 2) as conkcals, corusers.firstname, corusers.lastname, activity_details.*'))->leftJoin('users as corusers', 'corusers.id', '=', 'activity_details.user_id')->orderBy('activity_details.id', 'desc')->get();
        // dd($allActivities);
       
        return view('superadmin.activityreportsadmin', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata,
            "active" => $active,
            "partner" => $partner,
            "allActivities" => $allActivities
        ));
    }
    
    public function goalreportsadmin()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }

        $allActivities = Setgoal::select(\DB::raw('corusers.firstname, corusers.lastname, setgoal.*'))->leftJoin('users as corusers', 'corusers.id', '=', 'setgoal.user_id')->orderBy('setgoal.id', 'desc')->get();
        
        return view('superadmin.goalreportsadmin', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata,
            "allActivities" => $allActivities
        ));
    }

    
    public function newsfeedreportsadmin(Request $request)
    {
//        dd($id);
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        //dd($partner["id"]);


        $posts = Newsfeed::leftJoin('users as corusers', 'corusers.id', '=', 'newsfeeds.postedby')->orderBy('newsfeeds.id', 'desc')->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.newsfeedreportsadmin', compact('posts', $posts), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    
    public function rewardsreportadmin()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );


        $rewards = Reward::get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('superadmin.rewardsreportadmin', compact('rewards'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }


}
