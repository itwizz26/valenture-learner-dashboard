<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Learner extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
    ];

    protected $appends = ['full_name'];

    /**
     * Get the learner's full name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->firstname} {$this->lastname}",
        );
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrolments')
            ->withPivot('progress')
            ->withTimestamps();
    }
}
