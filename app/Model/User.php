<?php

namespace Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'login',
        'password',
        'id_role'
    ];
    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }
    public function findIdentity(int $user_id)
    {
        return self::where('id_user', $user_id)->first();
    }

    public function getId(): int
    {
        return $this->id_user;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'login' => $credentials['login'],
            'password' => md5($credentials['password'])
        ])->first();
    }
    public function roles()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}