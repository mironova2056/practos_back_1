<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/admin', [Controller\Site::class, 'adminDashboard']);
Route::add('POST', '/admin', [Controller\Site::class, 'adminDashboard']);