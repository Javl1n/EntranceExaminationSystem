<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamineeSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the examinee that owns the ExamineeSection
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function examinee(): BelongsTo
    {
        return $this->belongsTo(Examinee::class);
    }

    /**
     * Get the section that owns the ExamineeSection
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
