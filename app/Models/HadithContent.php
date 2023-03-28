<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HadithContent extends Model
{
    use HasFactory;

    public function getFeaturedImageAttribute($value)
    {
        if (!empty($value)) {
            return asset('/storage/' . $value);
        } else {
            return "";
        }
    }
}
