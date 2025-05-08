<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
class Disciplines extends Model
{
    protected $table = 'disciplines';
    protected $primaryKey = 'id_discipline';
    protected $fillable = ['id_discipline', 'name'];
}