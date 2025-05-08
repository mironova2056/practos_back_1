<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
class Genders extends Model
{
    protected $table = 'genders';
    protected $primaryKey = 'id_gender';
    protected $fillable = ['name', 'id_gender'];
}