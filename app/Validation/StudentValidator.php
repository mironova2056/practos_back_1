<?php

namespace Validation;
use Validation\Validator;
use Model\StudentGroups;
use Model\Genders;
class StudentValidator extends Validator
{
    protected array $rules = [
        'name' => ['required'],
        'surname' => ['required'],
        'date_birth' => ['required'],
        'id_gender' => ['required', 'exists:genders'],
        'id_group' => ['required', 'exists:student_groups'],
        'address' => ['required']
    ];

    protected function applyRule(string $field, string $rule, $value): void
    {
        switch ($rule) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, $rule);
                }
                break;

            case 'exists:genders':
                if (!Genders::where('id_gender', $value)->exists()) {
                    $this->addError($field, 'exists');
                }
                break;

            case 'exists:student_groups':
                if (!StudentGroups::where('id_group', $value)->exists()) {
                    $this->addError($field, 'exists');
                }
                break;
        }
    }
}