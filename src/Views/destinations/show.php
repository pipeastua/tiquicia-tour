<?php
$destination = $destination ?? [];
$activities = $activities ?? [];
$image = destinationImage($destination['nombre'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($destination['nombre'] ?? 'Destino') ?> &middot; Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/destinations.css">
</head>
<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="destination-detail">
            <div class="hero-banner">
                <img
                    src="/assets/images/destinations/<?= rawurlencode($image) ?>"
                    alt="Paisaje de <?= htmlspecialchars($destination['nombre'] ?? '') ?>"
                >

                <div class="hero-overlay">
                    <h1><?= htmlspecialchars($destination['nombre'] ?? '') ?></h1>
                    <p>
                        <?= htmlspecialchars($destination['provincia'] ?? '') ?>
                        <?= !empty($destination['canton']) ? ', ' . htmlspecialchars($destination['canton']) : '' ?>
                        &middot; <a href="/destination">Volver a destinos</a>
                    </p>
                </div>
            </div>

            <section class="panel">
                <span class="section-label">Sobre este destino</span>
                <p><?= nl2br(htmlspecialchars($destination['descripcion'] ?? '')) ?></p>
            </section>

            <section class="panel">
                <span class="section-label">Actividades cercanas</span>

                <?php if (empty($activities)): ?>
                    <p>No hay actividades disponibles para este destino.</p>
                <?php else: ?>
                    <div class="card-grid">
                        <?php foreach ($activities as $activity): ?>
                            <article class="mini-card">
                                <h3><?= htmlspecialchars($activity['nombre']) ?></h3>
                                <p><?= nl2br(htmlspecialchars($activity['descripcion'])) ?></p>
                                <p class="price">Precio: ₡<?= number_format($activity['precio'], 2) ?></p>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="panel cta-panel">
                <div>
                    <span class="section-label">¿Listo para hospedarte?</span>
                    <p>Elegí un hotel cercano a <?= htmlspecialchars($destination['nombre'] ?? '') ?> para continuar con tu reserva.</p>
                </div>

                <a href="/hotel?destino_id=<?= (int) $destination['id'] ?>" class="btn-primary">
                    Ver hoteles cercanos
                </a>
            </section>
        </div>
    </main>
</body>
</html>
