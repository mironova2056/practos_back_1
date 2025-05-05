<?php
namespace Controller;

use Illuminate\Database\Capsule\Manager as DB;
use Model\Post;
use Src\View;
use Src\Request;

class Site
{
    public function index(Request $request): string
    {
        $posts = Post::all();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
}