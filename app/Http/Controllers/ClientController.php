<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use DB;

class ClientController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function home()
    {
        $userdata = auth()->user();
        $current_date = date('d-M-Y');
        $updatereads = DB::table('dailystepcount')->where('date',$current_date)->where('userid',$userdata->id)->first();
        $steps = $updatereads ? $updatereads->steps : 0 ;
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
            "percentage" => round($steps/100,0)
        );

        $posts = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_profile_id')
            ->select('posts.*', 'users.name','users.image')
            ->whereIn('user_profile_id', [$userdata->id,$userdata->partner_id,7,8,9,10,12,13,14])
            ->orderBy('posts.created_at', 'desc')
            ->get();


        return view('clients.home',
            array(
                'userdata'=> $userdata,
                'activitydata'=>$activitydata,
                'friendsdata'=>$friendsdata,
                'goals' => $goals,
                'posts' => $posts
            )
        );
    }




}
