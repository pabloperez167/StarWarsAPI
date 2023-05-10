<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
        // Add other attributes that you want to allow mass assignment for
    ];
    
}
