<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
class Control_type extends Model
{
    protected $table = 'control_type';
    protected $primaryKey = 'id_control_type';
    protected $fillable = ['name', 'id_control_type'];
    public function group_disciplines()
    {
        return $this->hasMany(Group_disciplines::class, 'id_control_type');
    }
}