<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Strand extends Model
{
    use HasFactory;

    // protected $with = ['list'];

    /**
     * Get all of the list for the Strand
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function list(): HasMany
    {
        return $this->hasMany(StrandRecommendation::class);
    }
}
