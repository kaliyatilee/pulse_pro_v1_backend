<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Members extends Model
{
    use HasFactory, HasRoles;

    protected $guard_name = 'web';

    protected $table = 'users';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'name',
        'gender',
        'dob',
        'phone',
        'weight',
        'height',
        'password',
        'partner_id',
        'role',
        'name',
        'membership_number'
    ];

    public function partner() {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }
    public function wellnessGoal() {
        return $this->hasOne(AssignGoal::class, 'user_id', 'id');
    }
}
