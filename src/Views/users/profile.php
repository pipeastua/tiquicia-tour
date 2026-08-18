<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil · Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/booking.css">
</head>

<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-content">
                <h1>Mi perfil</h1>
                <p>Gestioná los datos de tu cuenta de viajero.</p>
            </div>
        </header>

        <section class="profile-wrap panel">
            <span class="section-label">Datos personales</span>
            <h2><?= htmlspecialchars($user['nombre']) ?></h2>

            <?php if ($saved): ?>
                <div class="success-note">Perfil actualizado correctamente.</div>
            <?php endif; ?>

            <?php if ($errors): ?>
                <div class="form-errors">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Security::generateCSRFToken()) ?>">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <p class="account-meta">
                    Miembro desde <?= htmlspecialchars(date('d/m/Y', strtotime($user['created_at']))) ?>
                </p>
                <button type="submit">Guardar cambios</button>
            </form>
        </section>
    </main>
    </div><!-- .dashboard-container -->
</body>

</html>