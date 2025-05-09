<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilters($query, $filters)
    {
        foreach ($filters as $key => $value) {
            if (is_null($value)) {
                $query->whereNull($key);
            } else {
                $query->where($key, $value);
            }
        }
    }
}
