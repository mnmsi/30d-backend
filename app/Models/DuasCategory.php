<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuasCategory extends Model
{
    use HasFactory;
    protected $table = 'duas_categories';

    public function dua()
    {
        return $this->belongsTo(Duas::class,'dua_id');
    }
}
