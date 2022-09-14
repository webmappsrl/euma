<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_orig',
        'acronym',
        'country',
        'web',
        'members',
        'since',
        'type'
    ];

    public function huts(){
        return $this->hasMany(Hut::class);
    }
    
    public function trails(){
        return $this->hasMany(Trail::class);
    }
    
    public function users(){
        return $this->hasMany(User::class);
    }
}
