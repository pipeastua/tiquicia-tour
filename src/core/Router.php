<?php

class Router
{
    public function dispatch()
    {
        if (session_status() === PHP_SESSION_NONE) {
            $sessionPath = session_save_path();
            if ($sessionPath === '' || !is_dir($sessionPath) || !is_writable($sessionPath)) {
                $sessionPath = __DIR__ . '/../storage/sessions';
                if (!is_dir($sessionPath) && !mkdir($sessionPath, 0700, true) && !is_dir($sessionPath)) {
                    throw new RuntimeException('No se pudo crear el directorio de sesiones.');
                }

                session_save_path($sessionPath);
            }
            session_start();
        }

        $publicPath = ['/', '/register'];
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        if (!in_array($path, $publicPath)) {
            if (empty($_SESSION['user_id'])) {
                header('Location: /');
                exit;
            }
        }

        switch ($path) {
            case '/':
                require_once __DIR__ . '/../controllers/LoginController.php';
                (new LoginController())->loginValidate();
                break;

            case '/register':
                require_once __DIR__ . '/../controllers/RegisterController.php';
                (new RegisterController())->registerValidate();
                break;

            case '/dashboard':
                require_once __DIR__ . '/../controllers/DashboardController.php';
                (new DashboardController())->index();
                break;

            case '/logout':
                require_once __DIR__ . '/../controllers/LogOutController.php';
                (new LogOutController())->logOut();
                break;

            case '/destination':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                (new DestinationController())->index();
                break;

            case '/destination/view':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                (new DestinationController())->show();
                break;

            case '/destination/create':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                (new DestinationController())->create();
                break;

            case '/destination/edit':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                (new DestinationController())->edit();
                break;

            case '/destination/delete':
                require_once __DIR__ . '/../controllers/DestinationController.php';
                (new DestinationController())->delete();
                break;

            case '/hotel':
                require_once __DIR__ . '/../controllers/HotelController.php';
                (new HotelController())->index();
                break;

            case '/hotel/view':
                require_once __DIR__ . '/../controllers/HotelController.php';
                (new HotelController())->show();
                break;

            case '/activity':
                require_once __DIR__ . '/../controllers/ActivityController.php';
                (new ActivityController())->index();
                break;

            case '/reservation/create':
                require_once __DIR__ . '/../controllers/ReservationController.php';
                (new ReservationController())->create();
                break;

            case '/reservation':
                require_once __DIR__ . '/../controllers/ReservationController.php';
                (new ReservationController())->index();
                break;

            case '/user':
                require_once __DIR__ . '/../controllers/UserController.php';
                (new UserController())->profile();
                break;

            default:
                http_response_code(404);
                echo "Página no encontrada";
                break;
        }
    }
}
