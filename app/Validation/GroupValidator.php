<?php

namespace Validation;

use Src\Validation\Validator;
use Model\StudentGroups;

class GroupValidator extends Validator
{
    protected array $rules = [
        'name' => ['required', 'min:2', 'unique']
    ];

    protected array $messages = [
        'name' => [
            'required' => 'Название группы обязательно для заполнения',
            'min' => 'Название группы должно содержать минимум 2 символа',
            'unique' => 'Группа с таким названием уже существует'
        ]
    ];

    protected function applyRule(string $field, string $rule, $value): void
    {
        switch ($rule) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, 'required');
                }
                break;

            case str_starts_with($rule, 'min:'):
                $min = (int) substr($rule, 4);
                if (strlen($value) < $min) {
                    $this->addError($field, 'min');
                }
                break;

            case 'unique':
                if (StudentGroups::where('name', $value)->exists()) {
                    $this->addError($field, 'unique');
                }
                break;
        }
    }
}