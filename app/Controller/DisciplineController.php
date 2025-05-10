<?php

namespace Controller;
use Src\Request;
use Src\View;
use Model\Disciplines;
use Model\StudentGroups;
use Model\ControlType, Model\GroupDisciplines;
use Src\Auth\Auth;
class DisciplineController
{
    public function index(Request $request): string
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        return new View('site.staff_page', [
            'disciplines' => Disciplines::all()
        ]);
    }

    public function create(Request $request): string
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        if ($request->method === 'POST') {
            $validated = $this->validate($request->all());

            if ($validated['success']) {
                Disciplines::create($request->all());
                app()->route->redirect('/disciplines/create?success=Дисциплина добавлена');
            }

            return new View('add_discipline', ['errors' => $validated['errors']]);
        }

        return new View('site.add_discipline');
    }

    public function attachToGroup(Request $request): string
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        $data = [
            'groups' => StudentGroups::all(),
            'disciplines' => Disciplines::all(),
            'controlTypes' => ControlType::all()
        ];

        if ($request->method === 'POST') {
            $validated = $this->validateAttachment($request->all());

            if ($validated['success']) {
                GroupDisciplines::create($request->all());
                app()->route->redirect('/disciplines/attach?success=Дисциплина прикреплена');
            }

            $data['errors'] = $validated['errors'];
        }

        return new View('site.attach_discipline', $data);
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['name'])) $errors[] = 'Название дисциплины обязательно';
        return ['success' => empty($errors), 'errors' => $errors];
    }

    private function validateAttachment(array $data): array
    {
        $errors = [];
        if (empty($data['id_group'])) $errors[] = 'Группа обязательна';
        if (empty($data['id_discipline'])) $errors[] = 'Дисциплина обязательна';
        if (empty($data['course'])) $errors[] = 'Курс обязателен';
        if (empty($data['semester'])) $errors[] = 'Семестр обязателен';
        if (empty($data['hours'])) $errors[] = 'Часы обязательны';
        if (empty($data['id_control_type'])) $errors[] = 'Тип контроля обязателен';
        return ['success' => empty($errors), 'errors' => $errors];
    }
}