<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    /**
     * Get all of the examinees for the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function examinees(): HasMany
    {
        return $this->hasMany(ExamineeSection::class, 'section_id');
    }
}
