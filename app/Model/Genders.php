<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
class Genders extends Model
{
    protected $table = 'genders';
    protected $primaryKey = 'id_gender';
    protected $fillable = ['name'];
    public  function students (): hasMany
    {
        return $this->hasMany(Students::class, 'id_gender');
    }

}