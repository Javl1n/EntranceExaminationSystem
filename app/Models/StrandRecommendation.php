<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StrandRecommendation extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $with = ['strand', 'examinee'];

    /**
     * Get the examinee that owns the StrandRecommendation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function examinee(): BelongsTo
    {
        return $this->belongsTo(Examinee::class);
    }

    /**
     * Get the strand that owns the StrandRecommendation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function strand(): BelongsTo
    {
        return $this->belongsTo(Strand::class);
    }
}
