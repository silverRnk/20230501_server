<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'gender',
        'date_of_birth',
        'email',
        'phone_no'
    ];

    protected $hidden = [
        'password'
    ];

    public function classAdvisory(): BelongsTo {
        
        return $this->belongsTo(
            ClassSection::class, 'advisory_class')
            ->withDefault();
        
    }
}
