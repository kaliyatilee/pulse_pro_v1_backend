<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'user_id',
        'goal_id',
        'training_program_id'
    ];

    public function wellnessGoal() {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

}
