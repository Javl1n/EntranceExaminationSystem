<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamineeScore extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the examinee that owns the ExamineeScore
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function examinee(): BelongsTo
    {
        return $this->belongsTo(Examinee::class);
    }

    /**
     * Get the category that owns the ExamineeScore
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
