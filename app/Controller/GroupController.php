<?php

namespace Controller;
use Src\Request;
use Src\View;
use Model\StudentGroups;
use Src\Auth\Auth;
use Validation\GroupValidator;
class GroupController
{
    public function index(Request $request): string
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        return new View('site.add_group', [
            'groups' => StudentGroups::all()
        ]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new GroupValidator();

            if ($validator['success']) {
                $existingGroup = StudentGroups::where('name', $request->name)->first();
                if ($existingGroup) {
                    $validated['success'] = false;
                    $validated['errors'][] = 'Группа с таким названием уже существует';
                    return new View('site.add_group', ['errors' => $validated['errors']]);
                }
                StudentGroups::create($request->all());
                app()->route->redirect('/groups/create?success=Группа добавлена');
            }

            return new View('site.add_group', ['errors' => $validator->getErrors()]);
        }

        return new View('site.add_group');
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['name'])) $errors[] = 'Название группы обязательно';
        return ['success' => empty($errors), 'errors' => $errors];
    }
}