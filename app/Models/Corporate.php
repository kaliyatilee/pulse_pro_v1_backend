<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corporate extends Model
{
    use HasFactory;

    protected $table = 'corporates';

    protected $fillable = [
        "name",
        "registrationNumber",
        "email",
        "phone"
    ];
}
