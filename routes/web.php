<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Main::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/login', [Controller\Authenticate::class, 'login']);
Route::add('GET', '/logout', [Controller\Authenticate::class, 'logout']);

Route::add('GET', '/admin', [Controller\Admin::class, 'adminDashboard']);
Route::add('POST', '/admin', [Controller\Admin::class, 'adminDashboard']);

Route::add('GET', '/staff', [Controller\StaffDashboardController::class, 'index']);
Route::add('POST', '/staff', [Controller\StaffDashboardController::class, 'index']);
// Студенты
Route::add('GET', '/students', [Controller\StudentController::class, 'index']);
Route::add('POST', '/students', [Controller\StudentController::class, 'index']);

// Группы
Route::add('GET', '/groups', [Controller\GroupController::class, 'index']);
Route::add('POST', '/groups', [Controller\GroupController::class, 'index']);
// Дисциплины
Route::add('GET', '/disciplines', [Controller\DisciplineController::class, 'index']);
Route::add('POST', '/disciplines', [Controller\DisciplineController::class, 'index']);
// Успеваемость
Route::add('GET', '/grades', [Controller\GradeController::class, 'index']);
Route::add('POST', '/grades', [Controller\GradeController::class, 'index']);