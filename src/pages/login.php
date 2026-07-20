<?php
session_start();

$errors = [];
$email = '';
$toast_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email)) {
        $errors['email'] = 'El correo electrónico es obligatorio.';
    }

    if (empty($password)) {
        $errors['password'] = 'La contraseña es obligatoria.';
    }

    if (empty($errors)) {
        if (isset($_SESSION['user']) && $_SESSION['user']['email'] === $email && password_verify($password, $_SESSION['user']['password_hash'])) {
            $_SESSION['logged_in'] = true;
            header('Location: /dashboard');
            exit;
        } else {
            $errors['general'] = 'Correo electrónico o contraseña incorrectos.';
        }
    }
}

if (isset($_GET['registered'])) {
    $toast_messages[] = [
        'type' => 'success',
        'message' => 'Cuenta creada correctamente. Ahora puedes iniciar sesión.'
    ];
}

if (isset($errors['general'])) {
    $toast_messages[] = [
        'type' => 'error',
        'message' => $errors['general']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="stylesheet" href="/assets/css/swiper.css">
</head>

<body>

    <?php require __DIR__ . '/../layouts/password_field.php'; ?>
    <?php require __DIR__ . '/../layouts/swiper.php'; ?>

    <div class="login-layout">

        <div class="login-form-side">

            <div class="login-form-inner">

                <h1>Iniciar sesión</h1>

                <form action="/" method="POST" novalidate>

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($email) ?>">

                        <?php if (isset($errors['email'])): ?>
                            <span class="error"><?= $errors['email'] ?></span>
                        <?php endif; ?>
                    </div>

                    <?php password_field('password', 'password', 'Contraseña', $errors); ?>

                    <button type="submit">Iniciar sesión</button>

                </form>

                <p class="switch-link">¿No tienes cuenta? <a href="/register">Regístrate</a></p>

            </div>
        </div>

        <?php
        swiper([
            '/assets/imgs/etienne-delorieux-EZCIoSIzGDU-unsplash.jpg',
            '/assets/imgs/luis-diego-aguilar-H4uBNJ93j10-unsplash.jpg',
            '/assets/imgs/patricia-palacin-EitAJO7TDLk-unsplash.jpg',
            '/assets/imgs/trail-ee8huBv8Vlw-unsplash.jpg',
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