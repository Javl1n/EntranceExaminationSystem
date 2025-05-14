<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the user that owns the Answer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Get all of the examinee_answers for the Answer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function examinees_answers(): HasMany
    {
        return $this->hasMany(ExamineeAnswer::class);
    }
}
