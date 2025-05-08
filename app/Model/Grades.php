<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
class Grades extends Model
{
    protected $table = 'grades';
    protected $primaryKey = 'id_grade';
    protected $fillable = ['id_grade', 'id_student', 'id_discipline', 'grade'];
}