<?php
require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../Models/User.php';
class UserController
{
    public function profile()
    {
        $user = User::findById((int) $_SESSION['user_id']);
        if (!$user) {
            header('Location: /logout');
            exit;
        }
        $errors = [];
        $saved = isset($_GET['updated']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user['nombre'] = Security::sanitizeInput($_POST['nombre'] ?? '');
            $user['email'] = Security::sanitizeInput($_POST['email'] ?? '');
            if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) $errors[] = 'La sesión expiró. Intentá de nuevo.';
            if (!$user['nombre']) $errors[] = 'El nombre es obligatorio.';
            if (!Security::validateEmail($user['email'])) $errors[] = 'Ingresá un correo válido.';
            if (!$errors) {
                $result = User::updateProfile((int) $_SESSION['user_id'], $user['nombre'], $user['email']);
                if ($result['success']) {
                    $_SESSION['user_name'] = $user['nombre'];
                    header('Location: /user?updated=1');
                    exit;
                }
                $errors[] = $result['error'];
            }
        }
        include __DIR__ . '/../Views/users/profile.php';
    }
}
