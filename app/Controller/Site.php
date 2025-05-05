<?php
namespace Controller;
use Src\View;
class Site
{
    public function index(): string
    {
        $view = new View();
        return $view->render('site.hello', ['message' => 'всем салам']);
    }
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'я работаю']);
    }
}
