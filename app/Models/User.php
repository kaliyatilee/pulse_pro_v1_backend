<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'name',
        'email',
        'gender',
        'dob',
        'phone',
        'weight',
        'height',
        'password',
        'partner_id',
        'role',
        'membership_number',
        'partnerTradingName',
        'suburb',
        'businessType',
        'partnerTradingDetails',
        'propertyNumber',
        'streetName',
        'accountNumber',
        'bankName',
        'branchName',
        'branchCode',
        'directorId',
        'certificateOfIncorporation',
        'CR14form',
        'registrationNumber',
        'registrationfee',
        'paymentAcceptance',
        'mouSigned',
        'directorName'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function partner(){
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }
    public function wellnessGoal() {
        return $this->hasOne(AssignGoal::class, 'user_id', 'id');
    }
}
