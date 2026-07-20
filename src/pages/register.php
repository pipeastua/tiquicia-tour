<?php
session_start();

$errors = [];
$data = [
    'name' => '',
    'email' => '',
];
$toast_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($data['name'])) {
        $errors['name'] = 'El nombre es obligatorio.';
    }

    if (empty($data['email'])) {
        $errors['email'] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El correo electrónico no es válido.';
    }

    if (empty($password)) {
        $errors['password'] = 'La contraseña es obligatoria.';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'La contraseña debe tener al menos 8 caracteres.';
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Las contraseñas no coinciden.';
    }

    if (!empty($errors)) {
        $toast_messages[] = [
            'type' => 'error',
            'message' => 'Por favor, corrige los errores en el formulario.'
        ];
    }

    if (empty($errors)) {
        $_SESSION['user'] = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => password_hash($password, PASSWORD_DEFAULT)
        ];
        header('Location: /?registered=1');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/register.css">
    <link rel="stylesheet" href="/assets/css/swiper.css">
</head>

<body>

    <?php require __DIR__ . '/../layouts/password_field.php'; ?>
    <?php require __DIR__ . '/../layouts/swiper.php'; ?>

    <div class="register-layout">

        <div class="register-form-side">

            <div class="register-form-inner">

                <h1>Crear cuenta</h1>

                <?php if (isset($errors['general'])): ?>
                    <p class="error"><?= $errors['general'] ?></p>
                <?php endif; ?>

                <form action="/register" method="POST" novalidate>

                    <div>
                        <label for="name">Nombre:</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?= htmlspecialchars($data['name']) ?>">

                        <?php if (isset($errors['name'])): ?>
                            <span class="error"><?= $errors['name'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="email">Correo electrónico:</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($data['email']) ?>">

                        <?php if (isset($errors['email'])): ?>
                            <span class="error"><?= $errors['email'] ?></span>
                        <?php endif; ?>
                    </div>

                    <?php password_field('password', 'password', 'Contraseña', $errors); ?>
                    <?php password_field('confirm_password', 'confirm_password', 'Confirmar contraseña', $errors); ?>

                    <button type="submit">Registrarse</button>

                </form>

                <p class="switch-link">¿Ya tienes una cuenta? <a href="/">Iniciar sesión</a></p>

            </div>
        </div>

        <?php
        swiper([
            '/assets/imgs/birger-strahl-H4Mqn6uh8bo-unsplash.jpg',
            '/assets/imgs/sterling-lanier-WDBqiHt3tNo-unsplash.jpg',
            '/assets/imgs/zdenek-machacek-46tBp3bP8LQ-unsplash.jpg',
            '/assets/imgs/david-regueira-iZ0FVcET6-I-unsplash.jpg',
        ]);
        ?>

    </div>

    <script src="/assets/js/togglePassword.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
    <script src="/assets/js/swiper.js"></script>
    <?php include __DIR__ . '/../layouts/windowFlashMessage.php'; ?>
    <script src="/assets/js/flashMessage.js"></script>

</body>

</html>