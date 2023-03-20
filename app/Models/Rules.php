<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    use HasFactory;


    public function categoryType()
    {
        return $this->belongsTo(ContentTypeCategory::class,'category_id');
    }
}
