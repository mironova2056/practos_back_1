<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Students extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id_student';
    protected $fillable = [
        'name',
        'surname',
        'patronym',
        'date_birth',
        'address',
        'id_gender',
        'id_group'
    ];
    public $timestamps = false;
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Genders::class, 'id_gender', 'id_gender');
    }
    public function grades(): HasMany
    {
        return $this->hasMany(Grades::class, 'id_student', 'id_student');
    }
    public function student_groups(): BelongsTo
    {
        return $this->belongsTo(StudentGroups::class, 'id_group', 'id_group');
    }

}