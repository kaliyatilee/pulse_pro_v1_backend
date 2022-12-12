<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class HomeController extends Controller
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
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('admin/home');
    }

    public function managerHome()
    {
        return view('manager/home');
    }

    public function clientHome()
    {
        $userdata = auth()->user();
        $activitydata = array(
            "steps" => 0
        );
        $friendsdata = array(
            "count" => 0
        );

        $goals = array(
            "target" => 10000,
            "current" => 4000,
            "type" => "Steps",
            "percentage" => 4000/100
        );


        return view('clients/home',
            array(
                'userdata'=> $userdata,
                'activitydata'=>$activitydata,
                'friendsdata'=>$friendsdata,
                'goals' => $goals
            )
        );
    }
    
    
}
