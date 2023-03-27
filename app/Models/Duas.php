<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duas extends Model
{
    use HasFactory;
    protected $table = 'duas';

    public function category()
    {
        return $this->hasMany(DuasCategory::class,'dua_id');
    }
}
