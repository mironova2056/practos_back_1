<?php
return [
    'auth' => \Src\Auth\Auth::class,
    'identity'=>\Model\User::class,
    //Классы для middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
    ]

];