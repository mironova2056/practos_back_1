<?php

namespace Controller;
use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Model\User;
class Authenticate
{
    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        $credentials = $request->all();
        $validator = $this->validateLogin($credentials);

        if (!$validator['success']) {
            return new View('site.login', ['message' => $validator['message']]);
        }

        if (Auth::attempt($credentials)) {
            if (Auth::user()->id_role === 1) {
                app()->route->redirect('/admin');
            } else {
                app()->route->redirect('/staff');
            }
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }

    private function validateLogin(array $credentials): array
    {
        if (empty($credentials['login']) || empty($credentials['password'])) {
            return [
                'success' => false,
                'message' => 'Логин и пароль обязательны для заполнения'
            ];
        }

        return ['success' => true];
    }
}