<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


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

    /**
     * Get the section associated with the Examinee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sectionPivot(): HasOne
    {
        return $this->hasOne(ExamineeSection::class, 'examinee_id');
    }

    /**
     * Get all of the strandRecommendations for the Examinee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function strandRecommendations(): HasMany
    {
        return $this->hasMany(StrandRecommendation::class, 'examinee_id');
    }
}
