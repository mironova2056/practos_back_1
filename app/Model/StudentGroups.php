<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class StudentGroups extends Model
{
    protected $table = 'student_groups';
    protected $primaryKey = 'id_group';
    protected $fillable = ['name'];
    public $timestamps = false;
    public function students(): HasMany
    {
        return $this->hasMany(Students::class, 'id_group', 'id_group');
    }
    public function group_disciplines(): HasMany
    {
        return $this->hasMany(GroupDisciplines::class, 'id_group', 'id_group');
    }
}