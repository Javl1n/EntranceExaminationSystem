<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Examinee extends Model
{
    use HasFactory;

    protected $guarded= [];

    /**
     * Get all of the answers for the Examinee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(ExamineeAnswer::class);
    }

    /**
     * Get all of the scores for the Examinee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scores(): HasMany
    {
        return $this->hasMany(ExamineeScore::class);
    }
}
