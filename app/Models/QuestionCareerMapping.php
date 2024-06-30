<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 */
class QuestionCareerMapping extends Model
{
    use HasFactory;

    protected $table = 'question_career_mapping';

    protected $guarded = ['id'];

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id')->whereNull('deleted_at');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id')->whereNull('deleted_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeInactive($query, $param)
    {
        return $query->where('is_active', $param);
    }

}
