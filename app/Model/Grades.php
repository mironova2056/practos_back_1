<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
class Grades extends Model
{
    protected $table = 'grades';
    protected $primaryKey = 'id_grade';
    protected $fillable = ['id_grade', 'id_student', 'id_discipline', 'grade'];
    public function disciplines()
    {
        return $this->belongsTo(Disciplines::class, 'id_discipline');
    }
    public function student(){
        return $this->belongsTo(Students::class, 'id_student');
    }
}