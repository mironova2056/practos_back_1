<?php

namespace Controller;

use Src\Request;
use Src\View;
use Model\StudentGroups, Model\Students;
use Model\GroupDisciplines;
use Model\Disciplines, Model\Grades;
use Src\Auth\Auth;

class StaffDashboardController
{
    public function index(Request $request): string
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        // Безопасное получение параметров
        $groupId = $request->get('group_id');
        $course = $request->get('course');
        $semester = $request->get('semester');
        $grade = $request->get('grade');

        $groupDisciplines = GroupDisciplines::with(['disciplines', 'student_groups', 'control_type'])
            ->when($groupId, fn($q) => $q->where('id_group', $groupId))
            ->when($course, fn($q) => $q->where('course', $course))
            ->when($semester, fn($q) => $q->where('semester', $semester))
            ->get();

        return new View('site.staff_page', [
            'groups' => StudentGroups::all(),
            'disciplines' => Disciplines::all(),
            'groupDisciplines' => $groupDisciplines,
            'selectedGroupId' => $groupId,
            'selectedCourse' => $course,
            'selectedSemester' => $semester,
            'students' => Students::with(['student_groups', 'gender'])->get(),
            'grades' => Grades::all()
        ]);
    }
}