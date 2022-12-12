<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    
    public function home(){
        return view('/');
    }


    public function about(){
        return view('about');
    }

    public function corporates(){
        return view('corporates');
    }

    public function schools(){
        return view('schools');
    }

    public function insurance(){
        return view('insurance');
    }

    public function ecg(){
        return view('ecg');
        
    }

    public function setup(){
        return view('setup');
    }

    public function wearables(){
        return view('smartwatches');
    }

    public function heartrate(){
        return view('heartrate');
    }


    public function trackers(){
        return view('trackers');
    }

    public function stories(){
        return view('stories');
    }

    public function challenges(){
        return view('challenges');
    }

    public function webcommunity(){
        return view('community');
    }

    public function sleepmonitor(){
        return view('sleepmonitor');
    }


    public function scales(){
        return view('scales');
    }

    public function services(){
        return view('services');
    }
  

    public function policy(){
        return view('policy');
    }

    public function terms(){
        return view('termsandconditions');
    }

    public function cookies(){
        return view('cookies');
    }

    public function websubs(){
        return view('subscriptions');
    }

    public function pulsegold(){
        return view('goldsubscription');
    }

    public function pulsesilver(){
        return view('silversubscription');
    }

    public function pulseplatnum(){
        return view('platnumsubscription');
    }
  
  
  
  
  
  








}
