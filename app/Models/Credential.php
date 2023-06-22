<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credential extends Model
{
    use HasFactory;

    protected $primaryKey = ['credential_type', 'std_ID'];

    protected $fillable = [
        'credential_type',
        'file_name',
        'file_path',
        'std_ID'
    ];

    
    public function student(): BelongsTo {

        return $this->belongsTo(
            Student::class, 'std_ID', 'std_ID'
        );
    }
}
