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
        if ($request->method === 'POST') {
            $validated = $this->validate($request->all());

            if ($validated['success']) {
                Disciplines::create($request->all());
                app()->route->redirect('/staff/disciplines?success=Дисциплина добавлена');
            }

            return new View('site.staff_page', ['errors' => $validated['errors']]);
        }

        return new View('site.staff_page');
    }

    public function attachToGroup(Request $request): string
    {
        if ($request->method === 'POST') {
            $validated = $this->validateAttachment($request->all());

            if ($validated['success']) {
                GroupDisciplines::create($request->all());
                app()->route->redirect('/staff/disciplines/attach?success=Дисциплина прикреплена');
            }

            return new View('site.staff_page', [
                'errors' => $validated['errors'],
                'groups' => StudentGroups::all(),
                'disciplines' => Disciplines::all(),
                'controlTypes' => ControlType::all()
            ]);
        }

        return new View('site.staff_page', [
            'groups' => StudentGroups::all(),
            'disciplines' => Disciplines::all(),
            'controlTypes' => ControlType::all()
        ]);
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