<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
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
    public function student_groups()
    {
        return $this->belongsTo(Student_groups::class, 'id_group', 'id_group');
    }
    public function disciplines(){
        return $this->belongsTo(Disciplines::class, 'id_discipline', 'id_discipline');
    }
    public function control_type(){
        return $this->belongsTo(Control_type::class, 'id_control_type', 'id_control_type');
    }
}