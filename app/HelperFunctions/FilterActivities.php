<?php

namespace App\HelperFunctions;

use App\User;
use function GuzzleHttp\Psr7\str;

class FilterActivities
{
    private $activity;
    private $weight;
    private $activityType;

    public function __construct($activity, $activityType, $weight)
    {
        $this->activity = $activity;
        $this->weight = $weight;
        $this->activityType = $activityType;
    }
    private function getUserBMI($userID) {
        $member = User::find($userID);
        if (strval($member->bmi) < 18.5) {
            return 'underweight';
        }
        if (strval($member->bmi) >= 18.5 && strval($member->bmi) <= 24.9) {
            return 'normal';
        }
        if (strval($member->bmi) >= 25 && strval($member->bmi) <= 29.9) {
            return 'overweight';
        }
        if (strval($member->bmi) >= 30) {
            return 'obese';
        }
    }

    public function filter() {
        if($this->activityType === 'all' && $this->weight === 'all') {
            return true;
        }
        elseif($this->activityType === 'all' && $this->getUserBMI($this->activity->user_id) === $this->weight) {
            return true;
        }
        elseif ($this->activityType === strtolower($this->activity->activity) && $this->getUserBMI($this->activity->user_id) === $this->weight){
            return true;
        }
        elseif ($this->activityType === strtolower($this->activity->activity) &&$this->weight === 'all'){
            return true;
        }
        return false;
    }
}