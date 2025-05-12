<?php

namespace Src\Validation;

abstract class Validator
{
    protected array $errors = [];
    protected array $rules = [];
    protected array $messages = [];
    protected array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $this->applyRule($field, $rule, $this->data[$field] ?? null);
            }
        }

        return empty($this->errors);
    }

    abstract protected function applyRule(string $field, string $rule, $value): void;

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function addError(string $field, string $rule): void
    {
        $message = $this->messages[$field][$rule] ?? $this->getDefaultMessage($rule);
        $this->errors[$field][] = $message;
    }

    protected function getDefaultMessage(string $rule): string
    {
        $messages = [
            'required' => 'Поле обязательно для заполнения',
            'min' => 'Значение должно быть не менее 6 символов для пароля и 3 символа для Логина',
            'unique' => 'Значение должно быть уникальным',
            'email' => 'Некорректный email адрес',
            'numeric' => 'Значение должно быть числом',
            'exists' => 'Указанное значение не существует'
        ];

        return $messages[$rule] ?? 'Некорректное значение';
    }
}