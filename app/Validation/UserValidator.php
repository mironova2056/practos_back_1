<?php

namespace Validation;
use Src\Validation\Validator;
use Model\User;
use Model\Role;
class UserValidator extends Validator
{
    protected array $rules = [
        'login' => ['required', 'min:3', 'unique:users'],
        'password' => ['required', 'min:6'],
        'id_role' => ['required', 'exists:roles']
    ];

    protected array $messages = [
        'login' => [
            'unique' => 'Этот логин уже занят'
        ]
    ];

    protected function applyRule(string $field, string $rule, $value): void
    {
        switch ($rule) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, $rule);
                }
                break;

            case str_starts_with($rule, 'min:'):
                $min = (int) substr($rule, 4);
                if (strlen($value) < $min) {
                    $this->addError($field, 'min');
                }
                break;

            case 'unique:users':
                if (User::where('login', $value)->exists()) {
                    $this->addError($field, 'unique');
                }
                break;

            case 'exists:roles':
                if (!Role::where('id_role', $value)->exists()) {
                    $this->addError($field, 'exists');
                }
                break;
        }
    }
}