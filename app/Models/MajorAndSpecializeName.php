<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class MajorAndSpecializeName extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'major_and_specialize_names';

    protected $guarded = ['id'];
}
