<?php

namespace CustomValidation;

class Validator
{
    /** @var array */
    protected $errors = [];

    /** @var array */
    protected $rules = [];

    public function validate(array $data): bool
    {
        $this->errors = []; // Сбрасываем ошибки перед каждой валидацией

        foreach ($this->rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $value = $data[$field] ?? null;
                $this->applyRule($field, $rule, $value);

                // Прекращаем проверку правил для этого поля, если уже есть ошибки
                if (isset($this->errors[$field])) {
                    break;
                }
            }
        }

        return empty($this->errors);
    }

    protected function applyRule(string $field, string $rule, $value): void
    {
        if (strpos($rule, ':') !== false) {
            $parts = explode(':', $rule, 2);
            $ruleName = $parts[0];
            $parameter = $parts[1];
            $this->applyParameterizedRule($field, $ruleName, $value, $parameter);
        } else {
            $this->applyBasicRule($field, $rule, $value);
        }
    }

    protected function applyBasicRule(string $field, string $rule, $value): void
    {
        switch ($rule) {
            case 'required':
                if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                    $this->addError($field, "Поле обязательно для заполнения");
                }
                break;
        }
    }

    protected function applyParameterizedRule(string $field, string $rule, $value, string $parameter): void
    {

    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }
}