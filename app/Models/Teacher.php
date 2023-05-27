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

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'name',
        'gender',
        'address',
        'date_of_birth',
        'email',
        'phone_no',
        'advisory_class',
        'admission_date',
        'profile_img',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    public $incrementing = false;

    public function classAdvisory(): BelongsTo {
        
        return $this->belongsTo(
            ClassSection::class, 'advisory_class');
        
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model){
            $model->uuid = IdGenerator::generate([
                'table' => 'teachers',
                'field' => 'uuid',
                'length' => 11,
                'prefix' => 'CDR1-'.date('ym'),
                'reset_on_prefix_change' => false
            ]);
        });
    }
}
