<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_level_id',
        'name'
    ];

    public function gradeLevel(): BelongsTo{

        return $this->belongsTo(
            GradeLevel::class, 'grade_level_id', 'uuid');
    }

    public function student(): HasMany {

        return $this->hasMany(
            Student::class,
            'section_id'
        );
    }

    
}
