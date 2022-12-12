<?php

namespace App\Http\Controllers;

use App\Models\AssignGoal;
use App\Models\PartnerMasterGoals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Members;
use App\Models\User;
use App\HelperFunctions\CoreProgram;
use DB;
use PhpParser\Node\Expr\Array_;


class MembersController extends Controller
{
    public function store(Request $request)
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
        $partner_id = $request->partner_id ? $request->partner_id : null;

        $membership_number = '';

        if ($request->membership_number) {
            //Verify with APIs
            $membership_number = $request->membership_number;
        }
        else {
            $membership_number = "PH" . rand(10000000, 99999999);
        }
        $member = Members::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => $request->firstname . " " . $request->lastname,
            'membership_number' => $membership_number,
            'email' => $request->email,
            'gender' => $request->gender,
            'weight' => $request->weight,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'height' => $request->height,
            'password' => Hash::make($request->password),
            'partner_id' => $partner_id,
            'role' => 'user'
        ]);
        $newlyInsertedUser = User::find($member->id);
        $newlyInsertedUser->assignRole('user');
        $bmi = round($newlyInsertedUser->weight / pow(intval($request->height) / 100, 2), 1);
        $newlyInsertedUser->bmi = $bmi;
        $newlyInsertedUser->save();
        $age = Carbon::parse($newlyInsertedUser->dob)->age;

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
            return redirect()->back()->withSuccessMessage("Successfully Added New Member");
        }
        else {
            return redirect()->back()->withErrors("Something went wrong with assigning core program");
        }
    }

    public function fetch($id){
        return Members::find($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'firstname' => ['required', 'min:2'],
            'lastname' => ['required', 'min:2'],
            'gender' => ['required'],
        ]);
        $updateMember = Members::find($id);
        $updateMember->firstname = $request->firstname;
        $updateMember->lastname = $request->lastname;
        $updateMember->gender = $request->gender;
        if ($updateMember->save()) {
            return redirect()->route('showmembers')->withSuccessMessage("Member Updated");
        }
    }

    public function destroy($id)
    {
        $member = Members::find($id);
        if ($member) {
            if ($member->delete()) {
                return \redirect()->back()->with('status', 'Deleted');
            } else {
                return \redirect()->back()->with('status', 'Not Deleted');
            }
        }
        return \redirect()->back()->with('status', 'Error');
    }
    public function fetchWithBMI($partner_id)
    {
        $members = Members::where('partner_id', $partner_id)
            ->get();
        $underweight = 0;
        $normal = 0;
        $overweight = 0;
        $obese = 0;
        $relativeMemberList["underweight"] = [];
        $relativeMemberList["normal"] = [];
        $relativeMemberList["overweight"] = [];
        $relativeMemberList["obese"] = [];


        foreach ($members as $member) {
            if($member->bmi !== "" && floatval($member->bmi) < 18.5) {
                $underweight++;
                array_push($relativeMemberList["underweight"], $member);
            }
            if($member->bmi !== "" && (floatval($member->bmi) > 18.4 && floatval($member->bmi) < 25)) {
                $normal++;
                array_push($relativeMemberList["normal"], $member);
            }
            if($member->bmi !== "" && (floatval($member->bmi) > 24.9 && floatval($member->bmi) < 30)) {
                $overweight++;
                array_push($relativeMemberList["overweight"], $member);
            }
            if($member->bmi !== "" && floatval($member->bmi) >= 30 ) {
                $obese++;
                array_push($relativeMemberList["obese"], $member);
            }
        }
        $bmi["underweight"] = $underweight;
        $bmi["normal"] = $normal;
        $bmi["overweight"] = $overweight;
        $bmi["obese"] = $obese;
        $bmi["total"] = $obese + $overweight + $normal + $underweight;

        return  array(
            "bmi" => $bmi,
            "members" => $relativeMemberList
        );
    }

    public function activewhen() {
        $dailystepcount = DB::select("SELECT DATE_FORMAT(STR_TO_DATE(date, '%d-%b-%y'),'%2021-%m-%d') as date , COUNT(userid) FROM `dailystepcount`  
GROUP BY date ORDER BY `date` ASC");
        dd($dailystepcount);
    }
}
