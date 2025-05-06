<?php
namespace Controller;

use Illuminate\Database\Capsule\Manager as DB;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;
use Src\Session;
use Model\Role;

class Site
{
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function adminDashboard(Request $request): string
    {
        // Проверка прав администратора
        if (!Auth::check() || Auth::user()->id_role !== 1) {
            app()->route->redirect('/hello');
        }

        // Обработка добавления нового пользователя
        if ($request->method === 'POST' && isset($request->createUser)) {
            $data = $request->all();
            $validator = $this->validateUserData($data);

            if ($validator['success']) {
                if ($this->createUser($data)) {
                    Session::set('success', 'Пользователь успешно добавлен');
                }
                app()->route->redirect('/admin');
            } else {
                Session::set('errors', $validator['errors']);
            }
        }

        // Получение данных для формы
        $users = User::all();
        $roles = Role::all();

        return new View('site.admin.dashboard', [
            'users' => $users,
            'roles' => $roles,
            'success' => Session::get('success'),
            'error' => Session::get('error'),
            'errors' => Session::get('errors') ?? []
        ]);
    }
    private function createUser(array $data): bool
    {
        try {
            $user = User::create([
                'login' => $data['login'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'id_role' => $data['id_role']
            ]);

            return $user->exists; // Проверяем, что пользователь действительно создан
        } catch (\Exception $e) {
            error_log('User creation error: ' . $e->getMessage());
            Session::set('error', 'Ошибка при создании пользователя: ' . $e->getMessage());
            return false;
        }
    }

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
                app()->route->redirect('/hello');
            }
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
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

    private function validateUserData(array $data): array
    {
        $errors = [];

        if (empty($data['login'])) {
            $errors['login'] = 'Логин обязателен для заполнения';
        } elseif (User::where('login', $data['login'])->exists()) {
            $errors['login'] = 'Этот логин уже занят';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Пароль обязателен для заполнения';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Пароль должен содержать минимум 6 символов';
        }

        if (empty($data['id_role'])) {
            $errors['id_role'] = 'Необходимо указать роль пользователя';
        } elseif (!Role::where('id', $data['id_role'])->exists()) {
            $errors['id_role'] = 'Указанной роли не существует';
        }

        return [
            'success' => empty($errors),
            'errors' => $errors
        ];
    }
}