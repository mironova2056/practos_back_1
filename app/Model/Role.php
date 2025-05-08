<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id_role';
    protected $fillable = [
        'id_role',
        'name'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}