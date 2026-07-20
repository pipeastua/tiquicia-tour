<?php

class Router
{
    public function dispatch()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        switch ($path) {
            case '/':
                require_once __DIR__ . '/../controllers/LoginController.php';
                $controller = new LoginController();
                $controller->index();
                break;

            case '/register':
                require_once __DIR__ . '/../controllers/RegisterController.php';
                $controller = new RegisterController();
                $controller->index();
                break;

            case '/dashboard':
                require_once __DIR__ . '/../controllers/DashboardController.php';
                $controller = new DashboardController();
                $controller->index();
                break;

            default:
                http_response_code(404);
                echo "Página no encontrada";
                break;
        }
    }
}
