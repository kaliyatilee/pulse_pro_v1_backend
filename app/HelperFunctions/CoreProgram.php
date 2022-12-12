<?php

namespace App\HelperFunctions;
use App\Models\AssignGoal;
use App\Models\User;
use DB;
use mysql_xdevapi\Exception;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class CoreProgram
{
    private $member_id;
    private $age;
    private $bmi;
    private $partner_id;

    public function __construct($member_id, $age, $bmi, $partner_id)
    {
        $this->member_id = $member_id;
        $this->age = $age;
        $this->bmi = $bmi;
        $this->partner_id = $partner_id;
    }

    public function assign()
    {
        if ($this->bmi < 18.5)
            $bmi = "under-weight";
        elseif ($this->bmi >= 18.5 && $this->bmi <= 24.9)
            $bmi = "normal";
        elseif ($this->bmi >= 25 && $this->bmi <= 29.9)
            $bmi = "over-weight";
        else
            $bmi = "obese";

        if ($this->age < 13)
            $program = DB::table('core_par_goals')->where('group', 'pre-adolescent')->where('program', $bmi)->first();
        elseif ($this->age >= 13 && $this->age <= 17)
            $program = DB::table('core_par_goals')->where('group', 'adolescent')->where('program', $bmi)->first();
        elseif ($this->age >= 18 && $this->age <= 25)
            $program = DB::table('core_par_goals')->where('group', 'young-adult')->where('program', $bmi)->first();
        elseif ($this->age >= 26 && $this->age <= 59)
            $program = DB::table('core_par_goals')->where('group', 'adult')->where('program', $bmi)->first();
        elseif ($this->age >= 60)
            $program = DB::table('core_par_goals')->where('group', 'adult')->where('program', $bmi)->first();
        else
            $program = null;

        try {
            $assignGoal = AssignGoal::create([
                'partner_id' => $this->partner_id,
                'user_id' => $this->member_id,
                'training_program_id' => $program->id
            ]);
            $assignGoal->save();
            return 1;
        }
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return 0;
        }
    }
}