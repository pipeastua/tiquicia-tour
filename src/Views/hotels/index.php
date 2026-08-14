<?php
$destination = $destination ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles &middot; Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/hotels.css">
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-content">
                <h1>Hoteles</h1>
                <p>
                    <?php if ($destination): ?>
                        Hoteles cercanos a <?= htmlspecialchars($destination['nombre']) ?>
                        &middot;
                        <a href="/destination/view?id=<?= (int) $destination['id'] ?>">Volver al destino</a>
                    <?php else: ?>
                        Todos los hoteles disponibles.
                    <?php endif; ?>
                </p>
            </div>
        </header>

        <section class="panel hotels-panel">
            <?php if (empty($hotels)): ?>
                <p>No se encontraron hoteles<?= $destination ? ' para este destino' : '' ?>.</p>
            <?php else: ?>
                <div class="hotel-grid">
                    <?php foreach ($hotels as $hotel): ?>
                        <?php $image = hotelImage($hotel['nombre']); ?>

                        <article class="hotel-card">
                            <div class="hotel-card__image">
                                <img
                                    src="/assets/images/hotels/<?= rawurlencode($image) ?>"
                                    alt="Instalaciones de <?= htmlspecialchars($hotel['nombre']) ?>"
                                >
                            </div>

                            <div class="card-body">
                                <h3><?= htmlspecialchars($hotel['nombre']) ?></h3>

                                <?php if (!$destination): ?>
                                    <p class="mini-card-tag"><?= htmlspecialchars($hotel['destino_nombre']) ?></p>
                                <?php endif; ?>

                                <p><?= htmlspecialchars($hotel['direccion'] ?? '') ?></p>

                                <span
                                    class="hotel-card__rating"
                                    aria-label="Calificación <?= number_format((float) $hotel['calificacion'], 1) ?> de 5"
                                >
                                    ★ <?= number_format((float) $hotel['calificacion'], 1) ?>
                                </span>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
