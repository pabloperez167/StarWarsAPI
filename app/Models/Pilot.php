<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','foto'
        
        // Add other attributes that you want to allow mass assignment for
    ];

    public function starships()
    {
        return $this->belongsToMany(Starship::class, 'pilot_starship', 'pilot_id', 'starship_id', 'starship_name');
    }

    
    

    
}
