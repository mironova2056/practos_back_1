<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
class ControlType extends Model
{
    protected $table = 'control_type';
    protected $primaryKey = 'id_control_type';
    protected $fillable = ['name'];
    public $timestamps = false;
    public function group_disciplines(): hasMany
    {
        return $this->hasMany(GroupDisciplines::class, 'id_control_type');
    }
}