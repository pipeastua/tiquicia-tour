<?php

require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../Models/Users.php';
class LoginController
{
    public function loginValidate()
    {
        $errors = [];
        $email = '';
        $toast_messages = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Security::sanitizeInput($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
                $errors['general'] = 'Token de seguridad inválido. Intente nuevamente.';
            } else {
                if (empty($email)) {
                    $errors['email'] = 'El correo electrónico es obligatorio.';
                }

                if (empty($password)) {
                    $errors['password'] = 'La contraseña es obligatoria.';
                }

                if (empty($errors)) {
                    $result = User::attemptLogin($email, $password);

                    if ($result['success']) {
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $result['user']['id'];
                        $_SESSION['user_name'] = $result['user']['nombre'];
                        $_SESSION['user_role'] = $result['user']['role'];

                        header('Location: /dashboard');
                        exit;
                    }

                    $errors['general'] = $result['error'];
                }
            }
        }

        if (isset($_GET['registered'])) {
            $toast_messages[] = [
                'type' => 'success',
                'message' => 'Cuenta creada correctamente. Ahora puedes iniciar sesión.',
            ];
        }

        if (isset($errors['general'])) {
            $toast_messages[] = [
                'type' => 'error',
                'message' => $errors['general'],
            ];
        }

        include __DIR__ . '/../Views/auth/login.php';
    }
}
