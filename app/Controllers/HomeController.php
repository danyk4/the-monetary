<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class HomeController
{
    public function __construct(private readonly Twig $twig)
    {
        //
    }

    public function index(Request $request, Response $response): Response
    {
        $user = $request->getAttribute('user');
//        xdebug_info();
//        exit;

        return $this->twig->render($response, 'dashboard.twig');
    }
}
