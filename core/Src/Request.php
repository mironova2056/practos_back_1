<?php

namespace Src;

class Request
{
    protected array $body;
    public string $method;
    public array $headers;

    public function __construct()
    {
        $this->body = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders() ?? [];
    }

    public function all(): array
    {
        return $this->body + $this->files();
    }

    public function set(string $field, $value): void
    {
        $this->body[$field] = $value;
    }

    public function get(string $key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->body);
    }

    public function files(): array
    {
        return $_FILES;
    }

    public function __get(string $key)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        throw new \InvalidArgumentException("Request parameter '{$key}' not found");
    }
}