<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\DailyStepCount;
use App\Models\AssignGoal;
use App\Models\Reward;
use App\Models\User;
use App\Models\NewPosts;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Members;
use App\Models\PartnerWellnessPlan;
use App\Models\PartnerMasterGoals;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use OneSignal;
use DB;
use function GuzzleHttp\Psr7\str;



class ViewsController extends Controller
{
    /**
     *
     *      Partner
     *       Start
     *
     */
    public function __construct()
    {
        $this->middleware('auth');


    }

    public function partnerIndex()
    {
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
             "dailyusers" => 0,
            "totalposts" => 0,
            "rewardslist" => 0,
            "rewardsallocated" => 0,
            "rewardsnew" => 0,
            "wellnessplans" => 0,
            "newsfeed" => 0,
            "wellnessgoals" => 0
        );

        $activeMembers = [];

        $activities = Activities::where('partner_id', $userdata->partner_id)->get();


        $dailystepcount = DB::table('dailystepcount')->get();


        foreach ($activities as $activity) {
            if (Carbon::parse($activity->date)->format('Y-m-d') === Carbon::today()->format('Y-m-d')) {
                if (!in_array($activity->user_id, $activeMembers)) {
                    array_push($activeMembers, $activity->user_id);
                }
            }
        }


        $subMembers = Members::where('partner_id', $userdata->partner_id)->count();
        $posts = Post::count();


        $newMembers = Members::where('partner_id', $userdata->partner_id)->whereDay('created_at', '=', date('d'))
            ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();

        $newMembersList = Members::where('partner_id', $userdata->partner_id)->whereDay('created_at', '=', date('d'))
            ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->get();
        $wellnessplans = PartnerWellnessPlan::where('partner_id', $partner->id)->count();
        $wellnessgoals = PartnerMasterGoals::where('partner_id', $partner->id)->count();

        $dailyRunners = Activities::where('partner_id', $userdata->partner_id)->where('activity','=','Running')->whereDay('created_at', '=', date('d'))
        ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();

        $dailyWalkers = Activities::where('partner_id', $userdata->partner_id)->where('activity','=','Walking')->whereDay('created_at', '=', date('d'))
        ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();

         $dailyCyclers = Activities::where('partner_id', $userdata->partner_id)->where('activity','=','Cycling')->whereDay('created_at', '=', date('d'))
        ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();


         $dailyZumbas = Activities::where('partner_id', $userdata->partner_id)->where('activity','=','Zumba')->whereDay('created_at', '=', date('d'))
        ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();

        $activemembers = Activities::
                         whereDay('created_at', '=', date('d'))
                        ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();

       $dailyUsers = DailyStepCount::
                         whereDay('created_at', '=', date('d'))
                        ->whereMonth('created_at', '=', date('m'))
                        ->whereYear('created_at', '=', date('Y'))
                        ->count();


        $data['submembers'] = $subMembers;
        $data['newMembers'] = $newMembers;
        $data['activemembers'] = $activemembers;
        $data['dailyusers'] = $dailyUsers;
        $data['dailyrunners'] =  $dailyRunners;
        $data['dailywalkers'] =  $dailyWalkers;
        $data['dailycyclers'] =  $dailyCyclers;
        $data['dailyzumbas'] =  $dailyZumbas;
        $data['wellnessplans'] = $wellnessplans;
        $data['wellnessgoals'] = $wellnessgoals;
        $data['totalposts'] = $posts;

        $data["totalsteps"] = DB::select('SELECT SUM(`steps`) AS totalsteps  FROM `dailystepcount` WHERE `date` = DATE_FORMAT(NOW(),"%d-%b-%Y")');
        $data["totalcalories"]  = DB::select('SELECT SUM(`calories`) AS totalcalories FROM `dailystepcount` WHERE `date` = DATE_FORMAT(NOW(),"%d-%b-%Y")');
       // $data["dailyusers"] = DB::select('SELECT COUNT(`id`) AS dailyusers FROM `dailystepcount` WHERE `date` = DATE_FORMAT(NOW(),"%d-%b-%Y")');



        $dateBegin = Carbon::today();
        $dateEnd = Carbon::today();
        return view('partner.dashboard', compact('newMembersList'), array(
                "userdata" => $userdata,
                "partnerdata" => $partnerdata,
                "data" => $data,
                "dateBegin" => $dateBegin,
                "dateEnd" => $dateEnd,
            )
        );
    }

    public function activemembers()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $activities = DB::table('activities')
        ->whereDate('created_at', Carbon::today())
        ->get();

        $activeMembers = array();

        foreach ($activities as $activity) {
            $user = User::find($activity->user_id);
            array_push($activeMembers, $user);
        }

//        dd($activeMembers);
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.activemembers', compact('activeMembers'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }


 public function activewalkers()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

          $activeWalkers = DailyStepCount::
                        where('date', date('d-M-Y', strtotime(NOW())))
                        ->join('users', 'dailystepcount.userid', '=', 'users.user_id')
                        ->get();


        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.dailywalkers', compact('activeWalkers'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

 public function activecyclers()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $activeCyclers = Activities::where('partner_id', $userdata->partner_id)
            ->where('activity', '=','Cycling' )
            ->whereDate('created_at', Carbon::today())
            ->get();


        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.dailycyclers', compact('activeCyclers'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

 public function activerunners()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );


         $activeRunners = Activities::where('partner_id', $userdata->partner_id)
           ->where('activity', '=','Running' )
           ->whereDate('created_at', Carbon::today())
          
           ->get();
         
         
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.dailyrunners', compact('activeRunners'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }



 public function activezumba()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );


         $activeZumba = Activities::where('partner_id', $userdata->partner_id)
           ->where('activity', '=','Zumba' )
           ->whereDate('created_at', Carbon::today())
           ->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.dailyzumba', compact('activeZumba'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }




  public function totalcalories()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $calories_count = DB::table('dailystepcount')->where('date', date('d-M-Y', strtotime(NOW())))->join('users', 'dailystepcount.userid', '=', 'users.id')->get();
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.calories', compact('calories_count', $calories_count), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function dailyusers()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

           $dailyusers = DailyStepCount::
                        where('date', date('d-M-Y', strtotime(NOW())))
                        ->join('users', 'dailystepcount.userid', '=', 'users.user_id')
                        ->get();


        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.dailyusers', compact('dailyusers', $dailyusers), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function stepscount()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $step_count = DB::table('dailystepcount')->where('date', date('d-M-Y', strtotime(NOW())))->join('users', 'dailystepcount.userid', '=', 'users.id')->get();
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.steps', compact('step_count', $step_count), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function compose_mail()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('partner.mail', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function compose_sms()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('partner.sms', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }


    public function addmember()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );


        return view('partner.addmember', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function addposts(Request $request)
    {
    
       $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
    
        $this->validate($request, [
            'user_id' => 'required',
            'title' => 'required',
            'uploadedFile' => 'max:153600|mimes:png,jpg,jpeg,mp4,3gp,mkv',
            'category' => 'required',
            'group' => 'required'
        ]);
        $date_current = date('Y-m-d H:i:s');

        if ($request->hasFile('uploadedFile')) {
            $path = $request->file('uploadedFile')->store('pulsehealth/images', 's3');

            Storage::disk('s3')->setVisibility($path, 'public');

            $post_type = "";
            if ($request->file('uploadedFile')->getClientOriginalExtension() == "mp4") {
                $post_type = "video";
            } else {
                $post_type = "image";
            }

            $data = array(
                'postedby' => $request->user_id,
                'type' => $post_type,
                'text' => $request->post_desc,
                'image_url' => Storage::disk('s3')->url($path),
                'created_at' => $date_current,
                'headline' => $request->category,
                'category' => $request->category,
                'viewstatus' => $request->post_privacy,
                'partnerid' => $request->partner_id

            );

            $post = DB::table('posts')->insertGetId($data);

            OneSignal::sendNotificationToAll(
                "New notification",
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null
            );
            if (!is_null($post)) {
                return redirect()->route('showposts');
            } else {

                return Redirect::back()->withErrors("Failed");
            }

        } else {

            $data = array(
                'postedby' => $request->user_id,
                'type' => "text",
                'post' => $request->post_desc,
                'created_at' => $date_current,
                'headline' => $request->post_category,
                'category' => $request->post_category,
                'viewstatus' => $request->post_privacy,
                'partnerid' => $request->partner_id

            );


            $post = DB::table('posts')->insertGetId($data);

            dd($post);

            if (!is_null($post)) {
                return redirect()->route('showposts');
            } else {

                return Redirect::back()->withErrors("Failed");
            }
        }
    }


    public function addpost(Request $request)
    {

        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        return view('partner.addpost', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

  public function newpost(Request $request)
    {
  
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        request()->validate([
            'uploaded_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg|max:2048',
        ]);
   

        $imageName = time().'.'.request()->uploaded_file->getClientOriginalExtension();
        request()->uploaded_file->move(public_path('PostImages'), $imageName);

        $url = "public/PostImages/".$imageName;

        $post = new NewPosts();
        $post->text=request('post');
        $post->title=request('post_category');
        $post->type=$url;
        $post->media_url=$url;
        $post->save();
        
        return view('partner.addpost', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }



      public function showposts()
    {
        $userdata = auth()->user();

        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $dailyposts = NewPosts::
         whereDay('created_at', '=', date('d'))
        ->whereMonth('created_at', '=', date('m'))
        ->whereYear('created_at', '=', date('Y'))
        ->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
      
        return view('partner.showposts', compact('dailyposts'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }


    public function activitylog()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        return view('partner.activitylog', array(
            'userdata' => $userdata,
            'partnerdata' => $partnerdata
        ));
    }

    public function assigngoal()
    {
        $userdata = auth()->user();

        $partner = $userdata->partner;
        $members = Members::where('partner_id', $partner->id)->get();
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.assigngoal', compact('members'), array(
            "userdata" => $userdata,
            "partner" => $partner,
            "partnerdata" => $partnerdata
        ));
    }

    public function newsfeed()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#023f88",
            'sec_color' => $partner->sec_color,
        );


        $current_date = date('d-M-Y');
        $updatereads = DB::table('dailystepcount')->where('date', $current_date)->where('userid', $userdata->id)->first();
        $steps = $updatereads ? $updatereads->steps : 0;
        $activitydata = array(
            "steps" => $steps
        );
        $friendsdata = array(
            "count" => 0
        );

        $goals = array(
            "target" => 10000,
            "current" => $steps,
            "type" => "Steps",
            "percentage" => round($steps / 100, 0)
        );

        $posts = DB::select('SELECT n.*,u.firstname,u.lastname,u.profileurl
                                FROM posts AS n
                                INNER JOIN friends AS f
                                    ON (n.postedby = f.friend_id AND f.user_id = ' . $userdata->id . ') OR (n.postedby = f.user_id AND f.friend_id = ' . $userdata->id . ')
                                JOIN users AS u
                                  ON n.postedby = u.id
                                UNION ALL
                                SELECT n.*,u.firstname,u.lastname,u.profileurl
                                FROM posts AS n
                                JOIN users AS u
                                  ON n.postedby = u.id
                                WHERE n.postedby = ' . $userdata->id . '
                                AND n.viewstatus<>"me"
                                ORDER BY `created_at` DESC
                                 ');

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view(
            'partner.feeds',
            array(
                'userdata' => $userdata,
                'activitydata' => $activitydata,
                'friendsdata' => $friendsdata,
                'goals' => $goals,
                'posts' => $posts,
                "partnerdata" => $partnerdata
            )
        );
    }


    public function membergoals(Request $request)
    {
        $userID = $request->user()->id;
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $goals = $partner->partnerMasterGoals;
        $members = Members::where('partner_id', $partner->id)->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.membergoals', compact('members', 'goals'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function mastergoal()
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
        if (session('error_message')) {
            Alert::error('Error', session('error_message'));
        }
        return view('partner.addmastergoals', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function showgoals(Request $request)
    {
        $userID = $request->user()->id;
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $goals = $partner->partnerMasterGoals;
        $members = Members::where('partner_id', $partner->id)->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.goallist', compact('goals', 'members'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function memberreports()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $members = Members::where('partner_id', $partner["id"])->get();

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
        return view('partner.memberreports', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata,
            "members" => $members,
            "active" => $active
        ));
    }


    public function rewardsreport()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );


        $rewards = Reward::where('partner_id', $partner->id)->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.rewardsreport', compact('rewards'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function newmembers(Request $request)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $newMembers = Members::where('partner_id', $userdata->partner_id)->whereDay('created_at', '=', date('d'))
            ->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.newmembers', compact('newMembers'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

  public function redeemedrewards()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $rewards = Reward::where('partner_id', $partner->id)->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.redeemedrewards', compact('rewards'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function showmembers(Request $request)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $members = Members::where('partner_id', $partner["id"])->get();
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.showmembers', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function activitytracker(Request $request)
    {
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
        return view('partner.activityreport', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }


    public function goalsreport(Request $request)
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
        return view('partner.goalsreport', compact('members', $members), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function newsfeedreport(Request $request)
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


        $posts = Post::where('user_profile_id', $partner["id"])->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.newsfeedreport', compact('posts', $posts), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function memberprofile(Request $request)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $member_id = $request->member_id;


        $memberdata = User::findOrFail($member_id);
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
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

        return view('partner.memberprofile', compact('member_id', 'memberdata', 'bmiStatus', 'bmiColor', 'allActivities'),
            array(
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

    public function addplan()
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
        return view('partner.addwellnessplan', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function showplans(Request $request)
    {
        $userID = $request->user()->id;
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );
        $plans = PartnerWellnessPlan::where('partner_id', $partner->id)->get();
        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.showplans', compact('plans', $plans), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata,
            "partner" => $partner
        ));
    }

    public function addmastergoals()
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
        if (session('error_message')) {
            Alert::error('Error', session('error_message'));
        }
        return view('partner.addmastergoals', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function activityreports(Request $request)
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
        return view('partner.activityreports', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata,
            "active" => $active,
            "partner" => $partner
        ));
    }

    public function goalreports()
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
        return view('partner.goalreports', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function assigngoals(Request $request)
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $members = $partner->members;
        $masterGoals = $partner->partnerMasterGoals;

        $memberGoal = array();
        foreach ($members as $member) {
            if ($member->wellnessGoal !== null) {
                if ($member->wellnessGoal->training_program_id !== null) {
                    $id = $member->wellnessGoal->training_program_id;
                    $goal = DB::table('core_par_goals')->find($id);
                    $memberGoal[$member->id] = $goal;
                }
                if ($member->wellnessGoal->goal_id !== null) {
                    $id = $member->wellnessGoal->goal_id;
                    $goal = PartnerMasterGoals::find($id);
                    $memberGoal[$member->id] = $goal;
                }
            }
        }
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        if (session('error_message')) {
            Alert::error('Error', session('error_message'));
        }
        if (session('warning_message')) {
            Alert::warning('Warning', session('warning_message'));
        }
        return view('partner.assigngoal', compact('members', 'masterGoals', 'memberGoal'), array(
            "userdata" => $userdata,
            "partner" => $partner,
            "partnerdata" => $partnerdata,
        ));
    }

    public function addreward()
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
        return view('partner.addreward', array(
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
        return view('partner.addproduct', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }


    public function showproduct()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $products = Reward::where('partner_id', $partner->id)->get();

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.showproducts', compact('products'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function showrewards()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
        );

        $rewards = Reward::where('partner_id', $partner->id)->get();

//        dd($rewards);

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.showrewards', compact('rewards'), array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function rewardsallocation()
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
        return view('partner.rewardsallocation', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

//     public function activity_log()
//     {
//         $userdata = auth()->user();
//         $partner =$userdata->partner;
//         $partnerdata = array(
//             'name' => $partner->name,
//             'logo' => $partner->logo,
//             'pri_color' => $partner->pri_color ? $partner->pri_color :"#8cc640",
//             'sec_color' => $partner->sec_color,
//         );

//         if(session('success_message')) {
//             Alert::success('Success', session('success_message'));
//         }
//         return view('partner.activitylog',array(
//             "userdata" => $userdata,
//             "partnerdata" => $partnerdata
//         ));
//     }

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
        return view('partner.subscriptions', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function dailyactivities()
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
        return view('partner.activityreports', array(
            "userdata" => $userdata,
            "partnerdata" => $partnerdata
        ));
    }

    public function general()
    {
        $userdata = auth()->user();
        $partner = $userdata->partner;
        $partnerdata = array(
            'name' => $partner->name,
            'logo' => $partner->logo,
            'pri_color' => $partner->pri_color ? $partner->pri_color : "#8cc640",
            'sec_color' => $partner->sec_color,
            'email' => $partner->email,
            'phone' => $partner->phone,
            'address' => $partner->address,
        );

        if (session('success_message')) {
            Alert::success('Success', session('success_message'));
        }
        return view('partner.general', array(
            'userdata' => $userdata,
            'partnerdata' => $partnerdata,
            'partner_id' => $partner->id
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

    /**
     *
     *      Partner
     *       End
     *
     */
}
