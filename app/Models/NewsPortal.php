<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPortal extends Model
{
    use HasFactory;

    protected $table = 'news_portals';

    protected $fillable = [
        'title',
        'short_description',
        'content',
        'featured_image',
        'video_url',
        'created_at',
        'updated_at'
    ];
}
