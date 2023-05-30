<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pilot;

class Starship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'model', 'piloto', 'coste'
        // Add other attributes that you want to allow mass assignment for
    ];

    public function pilots()
    {
        return $this->belongsToMany(Pilot::class, 'pilot_starship', 'starship_id', 'pilot_id');
    }


    
    
}
