<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
class Disciplines extends Model
{
    protected $table = 'disciplines';
    protected $primaryKey = 'id_discipline';
    protected $fillable = ['name'];
    public $timestamps = false;
    public function grades(): hasMany
    {
        return $this->hasMany(Grades::class, 'id_discipline');
    }
    public function group_disciplines(): hasMany
    {
        return $this->hasMany(GroupDisciplines::class, 'id_discipline');
    }
}