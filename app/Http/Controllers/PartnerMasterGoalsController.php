<?php

namespace App\Http\Controllers;

use App\Models\AssignGoal;
use App\Models\Members;
use Illuminate\Http\Request;
use App\Models\PartnerMasterGoals;
use Illuminate\Support\Facades\Auth;

class PartnerMasterGoalsController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'group' => ['required'],
            'program' => ['required'],
            'steps' => ['required'],
            'distance' => ['required'],
            'calories' => ['required'],
            'weekly_frequency' => ['required'],
            'duration_from' => ['required']
        ]);
        $partner_id = $request->partner_id ? $request->partner_id : null;
        $availableGoals = PartnerMasterGoals::where('partner_id', $partner_id)->get();
        $goalCount = 0;
        foreach ($availableGoals as $goal) {
            if ($goal->program === $request->program && $goal->group === $request->group) {
                $goalCount++;
            }
        }

        if ($goalCount > 0) {
            return redirect()->route('addmastergoals')->withErrorMessage("Goal Already Exists and is set! Instead Try Updating It");
        }
        $duration_per_session = $request->duration_to ? $request->duration_from . "-" . $request->duration_to . " minutes" : $request->duration_from . " minutes";

        $mastergoal = PartnerMasterGoals::create([
            'partner_id' => $partner_id,
            'group' => $request->group,
            'program' => $request->program,
            'steps' => $request->steps,
            'distance' => $request->distance,
            'calories' => $request->calories,
            'weekly_frequency' => $request->weekly_frequency,
            'duration_per_session' => $duration_per_session,
            'daily_calorie_intake' => $request->daily_calorie_intake,
            'reminder' => $request->reminder,
            'participation' => $request->participation,
            'recommendations' => $request->recommendations,
            'additional_consideration' => $request->additional_consideration,
        ]);

        if ($mastergoal->save()) {
            return redirect()->route('addmastergoals')->withSuccessMessage("Successfully Added New Master Goals");
        }

        return redirect()->route('addmastergoals')->with("error", "Master Goal Not Added!");
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'goal_name' => ['required'],
            'goal_measurement' => ['required'],
            'goal_type' => ['required'],
            'required_target' => ['required']
        ]);
        $updateGoal = PartnerMasterGoals::find($id);
        $updateGoal->goal_name = $request->goal_name;
        $updateGoal->goal_measurement = $request->goal_measurement;
        $updateGoal->goal_type = $request->goal_type;
        $updateGoal->required_target = $request->required_target;
        if ($updateGoal->save()) {
            return redirect()->route('showgoals')->withSuccessMessage("Goal Successfully Updated");
        }
    }

    public function destroy($id){
        $partnerMasterGoals = PartnerMasterGoals::find($id);
        if($partnerMasterGoals){
            if($partnerMasterGoals->delete()){
                return "Wellness plan deleted";
            }else{
                return "Wellness plan not deleted.";
            }
        }
    }
}
