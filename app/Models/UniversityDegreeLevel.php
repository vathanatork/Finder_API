<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $createData)
 */
class UniversityDegreeLevel extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
}
