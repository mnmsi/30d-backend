<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $guarded;


    public function  categoryId()
    {
        return $this->belongsTo(ContentTypeCategory::class,'category_id');
    }
}
