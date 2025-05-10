<?php

namespace Controller;
use Src\Request;
use Src\View;
use Model\Students;
use Model\StudentGroups;
use Model\Genders;
use Src\Auth\Auth;
use Validation\StudentValidator;
class StudentController
{
    public function index(Request $request): View
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        $students = Students::with(['student_groups', 'gender'])->get();
        return new View('staff.students.index', [
            'students' => $students,
            'groups' => StudentGroups::all(),
            'genders' => Genders::all()
        ]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $validated = $this->validate($request->all());

            if ($validated['success']) {
                Students::create($request->all());
                app()->route->redirect('/students/create?success=Студент добавлен');
            }

            return new View('site.add_student', [
                'errors' => $validated['errors'],
                'groups' => StudentGroups::all(),
                'genders' => Genders::all()
            ]);
        }

        return new View('site.add_student', [
            'groups' => StudentGroups::all(),
            'genders' => Genders::all()
        ]);
    }

    private function validate(array $data): array
    {
        $validator = new StudentValidator();
        $isValid = $validator->validate($data);

        return [
            'success' => $isValid,
            'errors' => $isValid ? [] : $validator->getErrors()
        ];
    }
}