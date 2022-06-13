<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'location'];

    public function organization() 
    {
        return $this->belongsTo(Organization::class);
    }

    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }
}
