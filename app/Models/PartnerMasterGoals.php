<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerMasterGoals extends Model
{
    use HasFactory;
    protected $fillable = [
        'partner_id',
        'group',
        'program',
        'steps',
        'distance',
        'calories',
        'weekly_frequency',
        'duration_per_session',
        'daily_calorie_intake',
        'reminder',
        'participation',
        'recommendations',
        'additional_consideration'
    ];
}
