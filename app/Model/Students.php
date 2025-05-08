<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
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
}