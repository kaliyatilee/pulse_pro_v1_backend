<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyStepCount extends Model
{
    use HasFactory;
    protected $table = 'dailystepcount';
    protected $fillable = [
        'partner_id',
        'user_id',
        'goal_id'
    ];
}
