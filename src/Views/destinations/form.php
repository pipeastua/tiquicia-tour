<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['id']) ? 'Editar' : 'Nuevo' ?> destino · Tiquicia Tour</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/destinations.css">
</head>

<body>

    <?php $errors = $errors ?? []; ?>
    <?php include __DIR__ . '/../../layouts/flash_message.php'; ?>

    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-content">
                <h1><?= isset($data['id']) ? 'Editar destino' : 'Nuevo destino' ?></h1>
                <p>Completa la información del destino</p>
            </div>
        </header>

        <section class="panel">
            <form action="<?= htmlspecialchars($formAction) ?>" method="POST" novalidate>

                <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($data['nombre'] ?? '') ?>">

                    <?php if (isset($errors['nombre'])): ?>
                        <span class="error"><?= $errors['nombre'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="provincia">Provincia</label>
                    <input type="text" id="provincia" name="provincia" value="<?= htmlspecialchars($data['provincia'] ?? '') ?>">

                    <?php if (isset($errors['provincia'])): ?>
                        <span class="error"><?= $errors['provincia'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="canton">Cantón</label>
                    <input type="text" id="canton" name="canton" value="<?= htmlspecialchars($data['canton'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4"><?= htmlspecialchars($data['descripcion'] ?? '') ?></textarea>
                </div>

                <button type="submit">Guardar</button>
                <a href="/destination" class="btn-secondary">Cancelar</a>

            </form>
        </section>
    </main>
    </div><!-- .dashboard-container -->

    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
    <script src="/assets/js/flashMessage.js"></script>

</body>

</html>