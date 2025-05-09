<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;


class Grades extends Model
{
    protected $table = 'grades';
    protected $primaryKey = 'id_grade';
    protected $fillable = ['id_student', 'id_discipline', 'grade'];
    public $timestamps = false;
    public function disciplines(): belongsTo
    {
        return $this->belongsTo(Disciplines::class, 'id_discipline');
    }
    public function students(): belongsTo
    {
        return $this->belongsTo(Students::class, 'id_student');
    }
}