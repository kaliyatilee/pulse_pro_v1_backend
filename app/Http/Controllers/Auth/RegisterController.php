<?php

namespace App\Http\Controllers\Auth;

use App\HelperFunctions\CoreProgram;
use App\Http\Controllers\Controller;
use App\Models\AssignGoal;
use App\Models\Members;
use App\Models\PartnerMasterGoals;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

//    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:6', 'confirmed'],
//            'firstname' => ['required', 'string', 'max:255'],
//            'lastname' => ['required', 'string', 'max:255'],
//            'height' => ['required'],
//            'weight' => ['required'],
//            'phone' => ['required', 'string', 'max:255'],
//            'gender' => ['required', 'string', 'max:255'],
//            'age' => ['required', 'string', 'max:255']
//        ]);
//    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(Request $request)
    {
        $this->validate($request, [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email'],
            'gender' => ['required'],
            'dob' => ['required'],
            'phone' => ['required'],
            'weight' => ['required'],
            'height' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        $partner_id = $request->partner_id ? $request->partner_id : 1;
        $membership_number = '';



        $member = Members::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => $request->firstname . " " . $request->lastname,
            'email' => $request->email,
            'gender' => $request->gender,
            'weight' => $request->weight,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'height' => $request->height,
            'password' => Hash::make($request->password),
            'partner_id' => $partner_id,
            'role' => 'user',
            //'membership_number' => $membership_number
        ]);

        if ($request->membership_number) {
            //Verify with APIs
            $membership_number = $request->membership_number;
        }
        else {
            $membership_number = "PH" . rand(10000000, 99999999).$member->id;

        }

        $member->user_id = $member->id;
        $member->membership_number = $membership_number;
        $member->update();


        $newlyInsertedUser = User::find($member->id);
        $newlyInsertedUser->assignRole('user');
        $bmi = round($newlyInsertedUser->weight / pow(intval($request->height) / 100, 2), 1);
        $newlyInsertedUser->bmi = $bmi;
        $newlyInsertedUser->save();
        $age = Carbon::parse($newlyInsertedUser->dob)->age;
        $credentials = $request->only('email', 'password');


        // Assign Core Goal
        $coreProgram = new CoreProgram($newlyInsertedUser->id, $age, $bmi, $partner_id);
        if ($coreProgram->assign()) {
            $mastergoals = PartnerMasterGoals::where("partner_id", $partner_id);
            foreach ($mastergoals as $mastergoal) {
                $assignGoal = AssignGoal::create([
                    'partner_id' => $partner_id,
                    'user_id' => $member->id,
                    'goal_id' => $mastergoal->id
                ]);
                $assignGoal->save();
            }
            if (Auth::attempt($credentials)) {
                return redirect()->route('client');
            }
        }
    }

    public function logout(Request $request) {


    }
}
