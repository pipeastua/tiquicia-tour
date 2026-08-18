<?php
// Se prepara la lista de destinos para el filtro mostrado en la vista.
$activities = $activities ?? [];
$destinations = $activities ? array_unique(array_column($activities, 'destino_nombre')) : [];
sort($destinations);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades · Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/booking.css">
</head>

<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-content">
                <h1>Actividades</h1>
                <p>Experiencias disponibles en cada destino.</p>
            </div>
        </header>

        <section class="panel section-pad activity-list" data-filter-root>
            <div class="filter-bar" role="search">
                <div class="search-field">
                    <label for="activity-search">Buscar actividad</label>
                    <input id="activity-search" type="search" placeholder="Actividad o destino" data-search-input>
                </div>

                <div class="filter-field">
                    <label for="activity-destination">Destino</label>
                    <select id="activity-destination" data-filter="destino">
                        <option value="">Todos los destinos</option>
                        <?php foreach ($destinations as $destination): ?>
                            <option value="<?= htmlspecialchars($destination) ?>">
                                <?= htmlspecialchars($destination) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="card-grid">
                <?php foreach ($activities as $activity): ?>
                    <article
                        class="mini-card"
                        data-filter-card
                        data-destino="<?= htmlspecialchars($activity['destino_nombre']) ?>"
                        data-search="<?= htmlspecialchars($activity['nombre'] . ' ' . $activity['destino_nombre'] . ' ' . $activity['descripcion']) ?>">
                        <span class="section-label"><?= htmlspecialchars($activity['destino_nombre']) ?></span>
                        <h3><?= htmlspecialchars($activity['nombre']) ?></h3>
                        <p><?= htmlspecialchars($activity['descripcion']) ?></p>
                        <p class="price">₡<?= number_format((float) $activity['precio'], 0) ?> por persona</p>
                    </article>
                <?php endforeach; ?>

                <p class="filter-empty" data-filter-empty hidden>
                    No encontramos actividades con esos criterios.
                </p>

                <?php if (!$activities): ?>
                    <p>No hay actividades disponibles.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    </div><!-- .dashboard-container -->

    <script src="/assets/js/filters.js"></script>
    <script src="/assets/js/carousel.js"></script>
</body>

</html>