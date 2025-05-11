<?php

namespace Validation;

use CustomValidation\Validator;
use CustomValidation\Rules\ExistsRule;
use CustomValidation\Rules\MaxYearRule;
use InvalidArgumentException;

class StudentValidator extends Validator
{
    // Убираем объявление типа для $rules, так как оно уже есть в родительском классе
    protected $rules = [
        'name' => ['required'],
        'surname' => ['required'],
        'patronymic' => [],
        'date_birth' => ['required', 'max_year:2009'],
        'id_gender' => ['required', 'exists:genders:id_gender'],
        'id_group' => ['required', 'exists:student_groups:id_group'],
        'address' => ['required']
    ];

    protected function applyParameterizedRule(string $field, string $rule, $value, string $parameter): void
    {
        switch ($rule) {
            case 'exists':
                $this->applyExistsRule($field, $value, $parameter);
                break;

            case 'max_year':
                $this->applyMaxYearRule($field, $value, (int)$parameter);
                break;
        }
    }

    protected function applyExistsRule(string $field, $value, string $parameter): void
    {
        try {
            [$table, $column] = array_pad(explode(':', $parameter, 2), 2, 'id');
            $modelClass = $this->getModelClass($table);

            (new ExistsRule())->validate($this, $field, $value, $modelClass, $column);
        } catch (InvalidArgumentException $e) {
            $this->addError($field, $e->getMessage());
        }
    }

    protected function applyMaxYearRule(string $field, $value, int $maxYear): void
    {
        (new MaxYearRule())->validate($this, $field, $value, $maxYear);
    }

    private function getModelClass(string $alias): string
    {
        $modelMap = [
            'genders' => \Model\Genders::class,
            'student_groups' => \Model\StudentGroups::class
        ];

        if (!array_key_exists($alias, $modelMap)) {
            throw new InvalidArgumentException("Unknown model alias: {$alias}");
        }

        return $modelMap[$alias];
    }
}