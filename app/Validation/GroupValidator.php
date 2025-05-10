<?php

namespace Validation;
use Src\Validation\Validator;
class GroupValidator extends Validator
{
    protected array $rules = [
        'name' => ['required', 'min:2']
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
        }
    }
}