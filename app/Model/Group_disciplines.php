<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
class Group_disciplines extends Model
{
    protected $table = 'group_disciplines';
    protected $primaryKey = 'id_group_discipline';
    protected $fillable = [
        'id_group_discipline',
        'id_group',
        'id_discipline',
        'course',
        'hours',
        'semester',
        'id_control_type',
        ];
}