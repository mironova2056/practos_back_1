<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Student_groups extends Model
{
    protected $table = 'student_groups';
    protected $primaryKey = 'id_group';
    protected $fillable = ['id_group', 'name'];
}