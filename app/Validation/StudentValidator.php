<?php

namespace Validation;
use Src\Validation\Validator;
use Model\StudentGroups;
use Model\Genders;
class StudentValidator extends Validator
{
    protected array $rules = [
        'name' => ['required'],
        'surname' => ['required'],
        'patronymic' => [],
        'date_birth' => ['required', 'max_year:2009'],
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

            case 'max_year':
                $maxYear = (int)explode(':', $rule)[1];
                $birthDate = new DateTime($value);
                if ($birthDate->format('Y') > $maxYear) {
                    $this->addError($field, "Год рождения должен быть не позднее $maxYear");
                }
                break;
        }
    }
}