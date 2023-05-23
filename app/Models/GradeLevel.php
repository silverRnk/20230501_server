<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradeLevel extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'level',
        'name'
    ];

    public function sections(): HasMany {

        return $this->hasMany(
            ClassSection::class,
            'grade_level_id',
            'uuid'
        );
    }

    public function students(): HasMany {

        return $this->hasMany(
            Student::class, 'grade_level_id', 'uuid');
    }
}
