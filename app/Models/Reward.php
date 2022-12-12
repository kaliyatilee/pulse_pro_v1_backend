<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $table = 'rewards';

    protected $fillable = [
        'reward_name',
        'pulse_points',
        'description',
        'imageurl',
        'partner_id',
        'productimage',
        'totalQty',
        'userId',
        'status'
    ];
}
