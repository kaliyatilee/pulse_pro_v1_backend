<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Activities;
use App\Models\AssignGoal;
use App\Models\Activitydetails;
use App\Models\DailyStepCount;
use App\Models\Reward;
use App\Models\Transaction;
use App\Models\Subscriptions;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\Corporate;
use App\Repositories\CorporateRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RewardRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Activitylog;
use App\Repositories\ActivitylogRepository;

use App\Models\Members; 
use App\Models\Newsfeed; 
use App\Repositories\NewsfeedRepository;
use App\Models\PartnerWellnessPlan;
use App\Models\PartnerMasterGoals;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Mail;

class CorporateController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $corporateRepository;
    protected $userRepository;
    protected $productRepository;
    protected $rewardRepository;
    protected $transactionRepository;
    protected $newsfeedRepository;
    protected $activitylogRepository;
    public function __construct(CorporateRepository $corporateRepository, UserRepository $userRepository, ProductRepository $productRepository, RewardRepository $rewardRepository, TransactionRepository $transactionRepository, NewsfeedRepository $newsfeedRepository, ActivitylogRepository $activitylogRepository)
    {
        // $this->middleware('auth');
        $this->corporateRepository = $corporateRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->rewardRepository = $rewardRepository;
        $this->transactionRepository = $transactionRepository;
        $this->newsfeedRepository = $newsfeedRepository;
        $this->activitylogRepository = $activitylogRepository;
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
            "totalsubscribers" => 0,
            "peicount"=>0
        );
        //echo $userdata->id;exit;
        $totalmembers = User::where('corporate_id', $userdata->id)->count();
        
        $activeMembers = User::where('corporate_id', $userdata->id)->where('status', 'active')->count();
        $totalsubscribers = Subscriptions::where('user_id', $userdata->id)->where('status', 'active')->count();
        //$subMembers = Members::where('partner_id', $userdata->id)->count();
        //$newMembers = Members::where('partner_id', $userdata->id)->whereDay('created_at', '=', date('d'))
           // ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();

        $newMembersList = Members::where('partner_id', $userdata->id)->whereDay('created_at', '=', date('d'))
            ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->get();
        $wellnessplans = PartnerWellnessPlan::where('partner_id', $userdata->id)->count();
        $wellnessgoals = PartnerMasterGoals::where('partner_id', $userdata->id)->count();
        $data['activemembers'] = $activeMembers;
        $data['totalmembers'] = $totalmembers;
        $data['totalsubscribers'] = $totalsubscribers;
        //$data['submembers'] = $subMembers;
        //$data['newMembers'] = $newMembers;
        $data['wellnessplans'] = $wellnessplans;
        $data['wellnessgoals'] = $wellnessgoals;

        //echo $userdata->id;exit;
        $Underweight = User::where('corporate_id', $userdata->id)->where('status', 'active')->where('bmi','<','18.5')->count();
        $Overweight = User::where('corporate_id', $userdata->id)->where('status', 'active')->where('bmi','>','24.9')->count();
        $Normal = User::where('corporate_id', $userdata->id)->where('status', 'active')->where('bmi','>=','18.5')->where('bmi','<=','24.9')->count();

        $data['peicount'] = $Underweight . ',' .$Overweight .','.$Normal;
        /*$bmiColor = "#82BE65";
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
        }*/
        

        return view('corporate.dashboard', compact('newMembersList'), array(
                "userdata" => $userdata,
                "partnerdata" => $partnerdata,
                "data" => $data,
                
            )
        );
    }

    
    public function corpouserslist(Request $request)
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


        $corporates = User::where('corporate_id', $userdata->id)->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('corporate.corpouserslist', compact('corporates', $corporates), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function corpouserslistexport(Request $request)
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

        // Excel file name for download 
        $fileName = "user-data_" . date('Y-m-d') . ".xls"; 
        
        // Column names 
        $fields = array('Name', 'Email', 'Phone'); 
                
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 

        $merchants = User::where('corporate_id', $userdata->id)->get();

        if(isset($merchants)){
            foreach($merchants as $merchant){
                $lineData = array($merchant->name, $merchant->email, $merchant->phone); 
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

    public function corponewuser()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('corporate.corpoadduser', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function savecorpouser(Request $request)
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
        $user['corporate_id'] = $userdata->id;
        $user['role'] = 'user';
        $user['status'] = 'active';
        $user['created_at'] = date("Y-m-d H:i:s");
        $addUser = $this->userRepository->save($user);
        
        if ($addUser) {
           
            if(!empty($request->id)){

                if(!empty($request->id)){
                    
                    $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Updated user by corporate';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);
                    $message = 'Record updated successfully.';
                } else {

                    
                    $activtylog['user_id'] = Auth::user()->id;
                    $activtylog['activity'] = 'Added user by corporate';
                    $activtylog['status'] = 'active';
                    $activtylog['updated_at'] = date("Y-m-d H:i:s");
                    $activtylogadded = $this->activitylogRepository->save($activtylog);

                    $message = 'Record added successfully.';
                }

                return redirect()->route('corpouserslist')->with('success', $message);

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
                    return redirect()->route('corpouserslist')->with('success', 'Email sent failed!');
                } else { 
                    
                    if(!empty($request->id)){
                        $message = 'Record updated successfully.';
                    } else {
                        $message = 'Record added successfully.';
                    }
    
                    return redirect()->route('corpouserslist')->with('success', $message);
                }
            }
        } else {
            return redirect()->back()->withErrors('Submission Failed')->withInput();
        }
    }

    public function editcorpouser($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $corpouser = User::where('id', $id)->where('role', 'user')->first();
        return view('corporate.editcorpouser', compact('corpouser'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function viewcorpouser($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $corpouser = User::where('id', $id)->where('role', 'user')->first();
        $memberdata = $corpouser;
        $member_id = $corpouser->id;

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

        $allActivities = Activities::where('user_id', $member_id)->get();
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
        foreach ($allActivities as $activity) {
            $activityDate = strtotime($activity->date);
            if (date('Y-m-d', $activityDate) === Carbon::now()->format('Y-m-d')) {
                $progress['steps'] += $activity->steps;
                $progress['calories'] += $activity->calories;
                $progress['distance'] += $activity->distance;
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
            $activityDate = strtotime($activity->date);
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
        
        return view('corporate.viewcorpouser', compact('corpouser', 'member_id', 'memberdata', 'bmiStatus', 'bmiColor', 'allActivities'), array(
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

  
    public function corponewsfeed(Request $request)
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

        $corponewsfeed = DB::table('newsfeeds')->where('postedby', $userdata->id)->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('corporate.corponewsfeed', compact('corponewsfeed', $corponewsfeed), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }
    
    public function corponewsfeedadd(Request $request)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('corporate.corponewsfeedadd', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }
    
    public function savecorponewsfeed(Request $request)
    {
        $userdata = auth()->user();
        if(!empty($request->id)) {

            if (isset($request->uploaded_file) && $request->uploaded_file != '') {
                $uploaded_filereq = 'required|image|mimes:jpg,png,jpeg,gif,svg';
            } else {
                $corponewsfeed = DB::table('newsfeeds')->where('id', $request->id)->first();
                if(!empty($corponewsfeed->imageurl)){
                    $uploaded_filereq = '';
                } else {
                    $uploaded_filereq = 'required|image|mimes:jpg,png,jpeg,gif,svg';
                }
            }

            $this->validate(request(), [
                'post' => 'required',
                // 'headline' => 'required',
                // 'category' => 'required',
                'uploaded_file' => $uploaded_filereq,
            ]);
           
        } else {
            $this->validate(request(), [
                'post' => 'required',
                // 'headline' => 'required',
                // 'category' => 'required',
                'uploaded_file' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
        }
          
        /* save corporate */
        $user = [];
        if(!empty($request->id)){
            $user['id'] = $request->id;
        }
     
        $user['post'] = $request->post;
   
        if (isset($request->uploaded_file) && $request->uploaded_file != '') {
           
            $path = $request->file('uploaded_file')->store('pulsehealth/images', 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $fullpath = Storage::disk('s3')->url($path);
            $fullpath = str_ireplace("/core","", $fullpath);
				//echo $fullpath;exit;
            $user['imageurl'] = $fullpath;
            $user['type'] = 'image';

        } else {
            $user['type'] = 'text';
        }

        $user['created_at'] = date('Y-m-d H:i:s');
        // $user['headline'] = $request->headline;
        // $user['category'] = $request->category;
        $user['viewstatus'] = 'Friends Only';

        if(!empty($request->id)) { } else {
            $user['postedby'] = $userdata->id;
        }

        $addUser = $this->newsfeedRepository->save($user);

        if ($addUser) {
            if(!empty($request->id)){
                
                $activtylog['user_id'] = Auth::user()->id;
                $activtylog['activity'] = 'Updated newsfeed by partner';
                $activtylog['status'] = 'active';
                $activtylog['updated_at'] = date("Y-m-d H:i:s");
                $activtylogadded = $this->activitylogRepository->save($activtylog);

                $message = 'Record updated successfully.';
            } else {
                
                $activtylog['user_id'] = Auth::user()->id;
                $activtylog['activity'] = 'Added newsfeed by partner';
                $activtylog['status'] = 'active';
                $activtylog['updated_at'] = date("Y-m-d H:i:s");
                $activtylogadded = $this->activitylogRepository->save($activtylog);

                $message = 'Record added successfully.';
            }
            return redirect()->route('corponewsfeed')->with('success', $message);
        } else {
            return redirect()->back()->withErrors('Submission Failed')->withInput();
        }

    }

    public function editcorponewsfeed($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $corpouser = Newsfeed::where('id', $id)->first();
        return view('corporate.editcorponewsfeed', compact('corpouser'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function viewcorponewsfeed($id)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $corpouser = Newsfeed::where('id', $id)->first();
        return view('corporate.viewcorponewsfeed', compact('corpouser'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }
}
