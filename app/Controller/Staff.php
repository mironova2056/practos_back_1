<?php

namespace Controller;
use Src\View;
use Src\Auth\Auth;
class Staff
{
    public function staffDashboard(): string
    {
        if (!Auth::check() || Auth::user()->id_role != 2) {
            app()->route->redirect('/login');
        }
        return new View('site.staff_page', []);
    }
}