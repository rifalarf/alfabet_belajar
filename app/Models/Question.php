<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    
    public function options()
    {
        return $this->hasMany(Option::class);
    }

   
    public function correctAnswer()
    {
        return $this->belongsTo(Alphabet::class, 'alphabet_id');
    }
}
