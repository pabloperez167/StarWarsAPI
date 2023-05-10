<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pilot;

class Starship extends Model
{

    use HasFactory;
    protected $fillable = [
        'name', 'model', 'piloto'
        // Add other attributes that you want to allow mass assignment for
    ];
    
}
