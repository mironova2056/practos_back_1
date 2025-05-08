<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
class Students extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id_student';
    protected $fillable = ['id_student',
        'name',
        'surname',
        'patronym',
        'date_birth',
        'address',
        'id_gender',
        'id_group'
    ];
    public function gender()
    {
        return $this->belongsTo(Genders::class, 'id_gender', 'id_gender');
    }
    public function grades(){
        return $this->hasMany(Grades::class, 'id_student', 'id_student');
    }
    public function student_groups(){
        return $this->belongsTo(Student_groups::class, 'id_group', 'id_group');
    }

}