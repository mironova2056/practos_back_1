<?php
namespace Src\Auth;

interface IdentityInterface
{
    public function findIdentity(int $user_id);

    public function getId(): int;

    public function attemptIdentity(array $credentials);
}
