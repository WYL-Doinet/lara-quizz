<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{   
    use HasFactory;
    protected $guarded = [];
    protected $with = ['choices'];

    public function choices() : HasMany
    {
        return $this->hasMany(Choice::class);
    }
}
