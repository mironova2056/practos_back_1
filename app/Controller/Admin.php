<?php

namespace Controller;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Session;
use Model\User;
use Model\Role;
use Controller\UserSearch;
use Validation\UserValidator;
class Admin
{
    public function adminDashboard(Request $request): string
    {
        $this->checkAdminAccess();

        $users = [];
        $errors = [];
        $oldInput = [];
        $searchQuery = null;

        if ($request->method === 'POST' && !$request->has('search')) {
            $validator = new UserValidator();

            if ($validator->validate($request->all())) {
                if ($this->createUser($request->all())) {
                    Session::set('success', 'Пользователь успешно добавлен');
                    app()->route->redirect('/admin');
                    return '';
                }
            } else {
                $errors = $validator->getErrors();
                $oldInput = $request->all();
            }
        }

        $searchQuery = $request->get('search') ? trim($request->get('search')) : null;
        $users = UserSearch::search($searchQuery);
        $roles = Role::all();

        $view = new View('site.admin.dashboard', [
            'users' => $users,
            'roles' => $roles,
            'searchQuery' => $searchQuery,
            'success' => Session::get('success'),
            'error' => Session::get('error'),
            'errors' => $errors,
            'old' => $oldInput
        ]);

        return (string)$view;
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

    private function checkAdminAccess(): void
    {
        if (!Auth::check() || Auth::user()->id_role !== 1) {
            app()->route->redirect('/login');
        }
    }
}