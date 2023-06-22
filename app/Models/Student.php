<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\ParentInfo;

class Student extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $primaryKey = 'std_ID';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guard = 'student';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'std_name',
        'std_gender',
        'std_email',
        'password',
        'std_photo',
        'std_date_of_birth',
        'std_religion',
        'std_email',
        'std_status',
        'tchr_Id',
        'grade_level_id',
        'section_id',
        'school_Id'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->std_ID = IdGenerator::generate([
                'table' => 'students',
                'field' => 'std_ID',
                'length' => 9, 
                'prefix' =>date('ymd'), 
                'reset_on_prefix_change' => false]);
    });
    }

    public function parent(): HasOne {
        return $this->hasOne(ParentInfo::class, 'student_id');
    }

    public function credentials(): HasMany {

        return $this->hasMany(
            Credential::class, 'std_ID', 'std_ID'
        );
    }

    public function gradeLevel(): BelongsTo {

        return $this->belongsTo(
            GradeLevel::class, 'grade_level_id', 'uuid');
    }

    public function section(): BelongsTo {

        return $this->belongsTo(
            ClassSection::class,
            'section_id',
        );
    }

    

}
