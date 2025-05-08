<?php
namespace Controller;

use Src\Request; // Изменено с Controller\Request на Src\Request
use Model\Group;
use Model\Student;
use Model\Discipline;
use Model\Performance;
use Src\View;
use Src\Auth\Auth;

class Staff
{
    public function staffDashboard(Request $request): string // Теперь использует Src\Request
    {
        // Проверка авторизации сотрудника
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }

        // Получаем данные из БД
        $groups = Group::withCount('students')->get();
        $students = Student::with('group')->orderBy('last_name')->get();

        // Фильтрация дисциплин
        $disciplinesQuery = Discipline::query()->with('group');
        if ($request->group_id) {
            $disciplinesQuery->where('group_id', $request->group_id);
        }
        if ($request->course) {
            $disciplinesQuery->where('course', $request->course);
        }
        if ($request->semester) {
            $disciplinesQuery->where('semester', $request->semester);
        }
        $disciplines = $disciplinesQuery->get();

        // Данные для фильтра успеваемости
        $studentsForGroup = [];
        if ($request->group_id) {
            $studentsForGroup = Student::where('group_id', $request->group_id)->get();
        }

        // Получаем успеваемость
        $performanceData = [];
        if ($request->student_id || $request->group_id || $request->discipline_id) {
            $performanceQuery = Performance::query()->with(['student', 'discipline']);

            if ($request->student_id) {
                $performanceQuery->where('student_id', $request->student_id);
            } elseif ($request->group_id) {
                $studentIds = Student::where('group_id', $request->group_id)->pluck('id');
                $performanceQuery->whereIn('student_id', $studentIds);
            }

            if ($request->discipline_id) {
                $performanceQuery->where('discipline_id', $request->discipline_id);
            }

            $performanceData = $performanceQuery->get();
        }

        return new View('staff.dashboard', [
            'groups' => $groups,
            'students' => $students,
            'disciplines' => $disciplines,
            'disciplinesList' => Discipline::all(),
            'selectedGroupId' => $request->group_id,
            'selectedCourse' => $request->course,
            'selectedSemester' => $request->semester,
            'selectedStudentId' => $request->student_id,
            'selectedDisciplineId' => $request->discipline_id,
            'studentsForGroup' => $studentsForGroup,
            'performanceData' => $performanceData
        ]);
    }
}