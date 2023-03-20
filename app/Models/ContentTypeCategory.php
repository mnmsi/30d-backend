<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTypeCategory extends Model
{
    use HasFactory;

    protected $guarded;

    public function contentType()
    {
     return $this->belongsTo(ContentType::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function  rules()
    {
        return $this->hasMany(Rules::class);
    }
}
