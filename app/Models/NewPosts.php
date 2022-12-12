<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewPosts extends Model
{
    use HasFactory;
    protected $table = "newposts";
    protected $fillable =[
        'user_profile_id',
        'text',
        'media_url',
        'type',
        'share_count',
        'video_thumb_url',
        'text_location_on_url',
        'is_story',
        'is_public',
        'deleted_at',
        'title',
    ];
}
