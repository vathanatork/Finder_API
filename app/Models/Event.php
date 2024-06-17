<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'start_at' => 'datetime: H:i',
        'end_at' => 'datetime: H:i'
    ];


    public function eventCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EventCategory::class,'event_category_id');
    }

    public function university(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(University::class,'university_id');
    }

}
