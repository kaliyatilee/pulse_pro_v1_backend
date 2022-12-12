<?php

namespace App\Http\Controllers;

use App\Models\AssignGoal;
use App\Models\User;
use Illuminate\Http\Request;

class AssignGoalController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'partner_id' => ['required'],
            'user_id' => ['required'],
            'goal_id' => ['required']
        ]);
        if($request->goal_id == 'null') {
            return redirect()->back()->with('warning_message', 'No Goal Selected, please select a goal to assign!');
        }
        // check if member already has the same goal
        $member = User::find($request->user_id);
        $goals = AssignGoal::where('user_id', $member->id)->get();
        $goal_count = 0;

        foreach ($goals as $goal) {
            if ($goal->goal_id == $request->goal_id) {
                $goal_count++;
            }
        }
        if ($goal_count > 0) {
            return redirect()->back()->withErrorMessage("Member Already Has this Goal");
        }
        $assignGoal = AssignGoal::create([
            'partner_id' => $request->partner_id,
            'user_id' => $request->user_id,
            'goal_id' => $request->goal_id
        ]);
        $assignGoal->save();
        return redirect()->back()->withSuccessMessage("Goal assigned Successfully");

    }

    public function overwrite(Request $request){
        $this->validate($request, [
            'partner_id' => ['required'],
            'user_id' => ['required'],
            'goal_id' => ['required']
        ]);
        if ($request->goal_id === 'null') {
            return response(json_encode("Please select a goal"), 403);
        }
        $member = User::find($request->user_id);
        $goals = AssignGoal::where('user_id', $member->id)->firstOrFail();
        $goal_count = $goals->goal_id == $request->goal_id ? 1 : 0;
        if ($goal_count > 0) {
            return response(json_encode("Member already has this goal"), 403);
        }

        if($goals->training_program_id === null) {
            $goals->goal_id = $request->goal_id;
            $goals->save();
            return response(json_encode("Member goals updated successfully"), 200);
        }
        else {
            $goals->training_program_id = null;
            $goals->goal_id = $request->goal_id;
            $goals->save();
            return response(json_encode("Member goals updated successfully"), 200);
        }

    }
}
