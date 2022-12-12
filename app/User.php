<?php

namespace App;

use App\Notifications\VerifyApiEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset;
use App\Feeds;

class User extends Authenticatable
{
    use Notifiable;


    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname','bmi','dob','gender','height','loyaltpoints','partnerId','phone','profileurl','status','title','weight', 'email', 'password','roleId','partner_id',
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



    public function sendApiEmailVerificationNotification()
    {
        // My notification
        $this->notify(new VerifyApiEmail);
    }

    public function posts(){
        return $this->hasMany(Feeds::class);
    }



}
