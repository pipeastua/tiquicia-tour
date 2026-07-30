<?php

require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../Models/Users.php';

class RegisterController
{
    public function registerValidate()
    {
        $errors = [];
        $data = [
            'name' => '',
            'email' => '',
        ];
        $toast_messages = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) {
                $errors['general'] = 'Token de seguridad inválido. Intente nuevamente.';
            } else {
                $data['name'] = Security::sanitizeInput($_POST['name'] ?? '');
                $data['email'] = Security::sanitizeInput($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';

                if (empty($data['name'])) {
                    $errors['name'] = 'El nombre es obligatorio.';
                }

                if (empty($data['email'])) {
                    $errors['email'] = 'El correo electrónico es obligatorio.';
                } elseif (!Security::validateEmail($data['email'])) {
                    $errors['email'] = 'El correo electrónico no es válido.';
                }

                if (empty($password)) {
                    $errors['password'] = 'La contraseña es obligatoria.';
                } elseif (!Security::validatePassword($password)) {
                    $errors['password'] = 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.';
                }

                if ($password !== $confirm_password) {
                    $errors['confirm_password'] = 'Las contraseñas no coinciden.';
                }

                if (empty($errors) && User::emailExist($data['email'])) {
                    $errors['email'] = 'Ese correo electrónico ya está registrado.';
                }

                if (!empty($errors)) {
                    $toast_messages[] = [
                        'type' => 'error',
                        'message' => 'Por favor, corrige los errores en el formulario.',
                    ];
                } else {
                    $result = User::create($data['name'], $data['email'], $password);

                    if ($result['success']) {
                        header('Location: /?registered=1');
                        exit;
                    }

                    $errors['general'] = $result['error'];
                    $toast_messages[] = [
                        'type' => 'error',
                        'message' => $result['error'],
                    ];
                }
            }
        }

        include __DIR__ . '/../Views/auth/register.php';
    }
}
