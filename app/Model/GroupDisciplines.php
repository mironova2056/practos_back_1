<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
class GroupDisciplines extends Model
{
    protected $table = 'group_disciplines';
    protected $primaryKey = 'id_group_discipline';
    protected $fillable = [
        'id_discipline',
        'course',
        'hours',
        'semester',
        'id_control_type',
        'id_group'
        ];
    public $timestamps = false;
    public function student_groups(): belongsTo
    {
        return $this->belongsTo(StudentGroups::class, 'id_group', 'id_group');
    }
    public function disciplines(): belongsTo
    {
        return $this->belongsTo(Disciplines::class, 'id_discipline', 'id_discipline');
    }
    public function control_type(): belongsTo
    {
        return $this->belongsTo(ControlType::class, 'id_control_type', 'id_control_type');
    }
}