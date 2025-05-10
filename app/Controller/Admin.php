<?php

namespace Controller;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Session;
use Model\User;
use Model\Role;

class Admin
{
    public function adminDashboard(Request $request): string
    {
        // Проверка прав администратора
        $this->checkAdminAccess();

        // Обработка добавления пользователя
        if ($request->method === 'POST' && !$request->has('search')) {
            $this->handleUserCreation($request);
        }

        // Получаем данные для отображения
        $searchQuery = $request->get('search');
        $users = $this->getUsersWithSearch($searchQuery);
        $roles = Role::all();

        return new View('site.admin.dashboard', [
            'users' => $users,
            'roles' => $roles,
            'success' => Session::get('success'),
            'error' => Session::get('error'),
            'errors' => Session::get('errors') ?? []
        ]);
    }
    private function getUsersWithSearch(?string $searchQuery = null)
    {
        $query = User::query()->with('roles');

        if ($searchQuery) {
            $query->where('login', 'LIKE', "%{$searchQuery}%");
        }

        return $query->get();
    }
    private function handleUserCreation(Request $request): void
    {
        $data = $request->all();
        $validator = $this->validateUserData($data);

        if ($validator['success']) {
            if ($this->createUser($data)) {
                Session::set('success', 'Пользователь успешно добавлен');
                app()->route->redirect('/admin');
            }
        } else {
            Session::set('errors', $validator['errors']);
        }
    }

    private function createUser(array $data): bool
    {
        try {
            $user = User::create([
                'login' => $data['login'],
                'password' => $data['password'],
                'id_role' => $data['id_role']
            ]);

            return $user->exists;
        } catch (\Exception $e) {
            error_log('User creation error: ' . $e->getMessage());
            Session::set('error', 'Ошибка при создании пользователя: ' . $e->getMessage());
            return false;
        }
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
        } elseif (!Role::where('id_role', $data['id_role'])->exists()) {
            $errors['id_role'] = 'Указанной роли не существует';
        }

        return [
            'success' => empty($errors),
            'errors' => $errors
        ];
    }

    private function checkAdminAccess(): void
    {
        if (!Auth::check() || Auth::user()->id_role !== 1) {
            app()->route->redirect('/login');
            return;
        }
    }

}