<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
class Disciplines extends Model
{
    protected $table = 'disciplines';
    protected $primaryKey = 'id_discipline';
    protected $fillable = ['id_discipline', 'name'];
    public function disciplines()
    {
        return $this->hasMany(Disciplines::class, 'id_discipline');
    }
    public function group_disciplines(){
        return $this->hasMany(Group_disciplines::class, 'id_discipline');
    }
}