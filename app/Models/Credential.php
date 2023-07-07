<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credential extends Model
{
    use HasFactory, HasAttributes;

    // protected $primaryKey = ['credential_type', 'std_ID'];

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

    protected function updatedAt(): Attribute{

        return Attribute::make(
            get: fn (string $value) => date('Y-m-d H:i', strtotime($value)),
        );
    }
}
