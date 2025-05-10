<?php

namespace Controller;
use Src\Request;
use Src\View;
use Model\Grades;
use Model\Students;
use Model\Disciplines;
use Model\StudentGroups;
use Src\Auth\Auth;
class GradeController
{
    public function index(Request $request): string
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        $grades = Grades::with(['students', 'disciplines'])->get();
        $students = Students::with('student_groups')->get();
        $disciplines = Disciplines::all();
        $groups = StudentGroups::all();

        return new View('site.staff_page', [
            'grades' => $grades,
            'students' => $students,
            'disciplines' => $disciplines,
            'groups' => $groups,
            'selectedStudentId' => $request->student_id,
            'selectedDisciplineId' => $request->discipline_id,
            'selectedGroupId' => $request->group_id
        ]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $validated = $this->validate($request->all());

            if ($validated['success']) {
                Grades::create($request->all());
                app()->route->redirect('/grades/create?success=Оценка добавлена');
            }

            return new View('site.add_grade', [
                'errors' => $validated['errors'],
                'students' => Students::with('student_groups')->get(),
                'disciplines' => Disciplines::all()
            ]);
        }

        return new View('site.add_grade', [
            'students' => Students::with('student_groups')->get(),
            'disciplines' => Disciplines::all()
        ]);
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (empty($data['id_student'])) $errors[] = 'Студент обязателен';
        if (empty($data['id_discipline'])) $errors[] = 'Дисциплина обязательна';
        if (empty($data['grade']) || $data['grade'] < 1 || $data['grade'] > 5) {
            $errors[] = 'Оценка должна быть от 1 до 5';
        }
        return ['success' => empty($errors), 'errors' => $errors];
    }
}