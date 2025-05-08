<?php

namespace Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
class Genders extends Model
{
    protected $table = 'genders';
    protected $primaryKey = 'id_gender';
    protected $fillable = ['name', 'id_gender'];
    public  function students ()
    {
        return $this->hasMany('Model\Students', 'id_gender');
    }

}