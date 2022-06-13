<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function user() 
    {
        return $this->hasOne(User::class);
    }
}
