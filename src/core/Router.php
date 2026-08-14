<?php

class Router
{
    public function dispatch()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $publicPath = ['/', '/register'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!in_array($path, $publicPath)) {
            if (empty($_SESSION['user_id'])) {
                header('Location: /');
                exit;
            }
        }

        switch ($path) {
            case '/':
                require_once __DIR__ . '/../controllers/LoginController.php';
                $controller = new LoginController();
                $controller->loginValidate();
                break;

            case '/register':
                require_once __DIR__ . '/../controllers/RegisterController.php';
                $controller = new RegisterController();
                $controller->registerValidate();
                break;

            case '/dashboard':
                require_once __DIR__ . '/../controllers/DashboardController.php';
                $controller = new DashboardController();
                $controller->index();
                break;

            case '/logout':
                require_once __DIR__ . '/../controllers/LogOutController.php';
                $controller = new LogOutController();
                $controller->logOut();
                break;

            case '/destination':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                $controller = new DestinationController();
                $controller->index();
                break;

            case '/destination/view':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                $controller = new DestinationController();
                $controller->show();
                break;

            case '/destination/create':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                $controller = new DestinationController();
                $controller->create();
                break;

            case '/destination/edit':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                $controller = new DestinationController();
                $controller->edit();
                break;

            case '/destination/delete':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                $controller = new DestinationController();
                $controller->delete();
                break;

            case '/hotel':
                require_once __DIR__ . '/../controllers/HotelController.php';
                $controller = new HotelController();
                $controller->index();
                break;

            default:
                http_response_code(404);
                echo "Página no encontrada";
                break;
        }
    }
}
