<?php

namespace Controller;
use Src\Request;
use Src\View;
use Model\StudentGroups;
use Src\Auth\Auth;
class GroupController
{
    public function index(Request $request): string
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        return new View('site.staff_page', [
            'groups' => StudentGroups::all()
        ]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $validated = $this->validate($request->all());

            if ($validated['success']) {
                StudentGroups::create($request->all());
                app()->route->redirect('/staff/groups?success=Группа добавлена');
            }

            return new View('site.staff_page', ['errors' => $validated['errors']]);
        }

        return new View('site.staff_page');
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['name'])) $errors[] = 'Название группы обязательно';
        return ['success' => empty($errors), 'errors' => $errors];
    }
}