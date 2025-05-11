<?php

namespace CustomValidation\Rules;

use CustomValidation\Validator;
use Illuminate\Database\Eloquent\Model;

class ExistsRule
{
    public function validate(Validator $validator, string $field, $value, string $modelClass, string $column = 'id'): bool
    {
        if (!class_exists($modelClass)) {
            $validator->addError($field, "Invalid model class");
            return false;
        }

        if (!$modelClass::where($column, $value)->exists()) {
            $validator->addError($field, "Record does not exist in {$modelClass} where {$column} = {$value}");
            return false;
        }

        return true;
    }
}