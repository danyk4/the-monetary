<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\CategoriesController;
use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index'])->add(AuthMiddleware::class);

    $app->group('', function (RouteCollectorProxy $guest) {
        $guest->get('/login', [AuthController::class, 'loginView'])->add(GuestMiddleware::class);
        $guest->get('/register', [AuthController::class, 'registerView'])->add(GuestMiddleware::class);
        $guest->post('/login', [AuthController::class, 'logIn'])->add(GuestMiddleware::class);
        $guest->post('/register', [AuthController::class, 'register'])->add(GuestMiddleware::class);
    })->add(GuestMiddleware::class);

    $app->post('/logout', [AuthController::class, 'logOut'])->add(AuthMiddleware::class);

    $app->group('/categories', function (RouteCollectorProxy $categories) {
        $categories->get('', [CategoriesController::class, 'index']);
        $categories->get('/load', [CategoriesController::class, 'load']);
        $categories->post('', [CategoriesController::class, 'store']);
        $categories->delete('/{id:[0-9]+}', [CategoriesController::class, 'delete']);
        $categories->get('/{id:[0-9]+}', [CategoriesController::class, 'get']);
        $categories->post('/{id:[0-9]+}', [CategoriesController::class, 'update']);
    })->add(AuthMiddleware::class);
};
