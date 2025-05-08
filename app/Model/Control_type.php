<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
class Control_type extends Model
{
    protected $table = 'control_type';
    protected $primaryKey = 'id_control_type';
    protected $fillable = ['name', 'id_control_type'];
}