<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerWellnessPlan extends Model
{
    use HasFactory;
    protected $fillable = ["partner_id", "plan_code","external_reference", "plan_name", "description"];
}
