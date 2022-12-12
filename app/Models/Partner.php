<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "address",
        "phone",
        "logo",
        "role",
        "pri_color",
        "sec_color"
    ];

    public function subscriptionPlan(){
        return $this->hasMany(UserSubscriptionPlan::class, 'partner_id', "id");
    }

    public function partnerWellnessPlans(){
        return $this->hasMany(PartnerWellnessPlan::class, 'partner_id', "id");
    }
    public function partnerMasterGoals(){
        return $this->hasMany(PartnerMasterGoals::class, 'partner_id', "id");
    }

    public function members() {
        return $this->hasMany(Members::class, 'partner_id', 'id');
    }
}
