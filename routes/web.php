<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Main::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/login', [Controller\Authenticate::class, 'login']);
Route::add('GET', '/logout', [Controller\Authenticate::class, 'logout']);
Route::add('GET', '/admin', [Controller\Admin::class, 'adminDashboard']);
Route::add('POST', '/admin', [Controller\Admin::class, 'adminDashboard']);
Route::add('GET', '/staff', [Controller\Staff::class, 'staffDashboard']);