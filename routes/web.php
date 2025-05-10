<?php

use Src\Route;

Route::add(['GET', 'POST'], '/login', [Controller\Authenticate::class, 'login']);
Route::add('GET', '/logout', [Controller\Authenticate::class, 'logout']);

Route::add('GET', '/admin', [Controller\Admin::class, 'adminDashboard']);
Route::add('POST', '/admin', [Controller\Admin::class, 'adminDashboard']);

Route::add('GET', '/staff', [Controller\StaffDashboardController::class, 'index']);
Route::add('POST', '/staff', [Controller\StaffDashboardController::class, 'index']);
// Студенты
Route::add('GET', '/students/create', [Controller\StudentController::class, 'create']);
Route::add('POST', '/students/create', [Controller\StudentController::class, 'create']);

// Группы
Route::add('GET', '/groups/create', [Controller\GroupController::class, 'create']);
Route::add('POST', '/groups/create', [Controller\GroupController::class, 'create']);
// Дисциплины
Route::add('GET', '/disciplines/create', [Controller\DisciplineController::class, 'create']);
Route::add('POST', '/disciplines/create', [Controller\DisciplineController::class, 'create']);
Route::add('GET', '/disciplines/attach', [Controller\DisciplineController::class, 'attachToGroup']);
Route::add('POST', '/disciplines/attach', [Controller\DisciplineController::class, 'attachToGroup']);

// Успеваемость
Route::add('GET', '/grades/create', [Controller\GradeController::class, 'create']);
Route::add('POST', '/grades/create', [Controller\GradeController::class, 'create']);