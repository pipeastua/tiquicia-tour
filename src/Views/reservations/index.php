<?php
// El indicador se muestra una sola vez después de crear una reserva.
$created = isset($_GET['created']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis reservas · Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/booking.css">
</head>

<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-content">
                <h1>Mis reservas</h1>
                <p>Consulta el estado y detalle de tus próximos viajes.</p>
            </div>
        </header>

        <section class="reservations-wrap" data-filter-root>
            <?php if ($created): ?>
                <div class="success-note">¡Solicitud enviada! Te confirmaremos tu reserva pronto.</div>
            <?php endif; ?>

            <?php if ($reservations): ?>
                <div class="filter-bar" role="search">
                    <div class="search-field">
                        <label for="reservation-search">Buscar reserva</label>
                        <input id="reservation-search" type="search" placeholder="Hotel, destino o actividad" data-search-input>
                    </div>
                    <div class="filter-field">
                        <label for="reservation-status">Estado</label>
                        <select id="reservation-status" data-filter="estado">
                            <option value="">Todos los estados</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="confirmada">Confirmada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <?php foreach ($reservations as $reservation): ?>
                <?php $activitiesText = implode(' ', array_column($reservation['activities'], 'nombre')); ?>
                <article
                    class="panel reservation-card"
                    data-filter-card
                    data-estado="<?= htmlspecialchars($reservation['estado']) ?>"
                    data-search="<?= htmlspecialchars($reservation['hotel_nombre'] . ' ' . $reservation['destino_nombre'] . ' ' . $reservation['estado'] . ' ' . $activitiesText) ?>">
                    <div class="reservation-card__head">
                        <div>
                            <span class="section-label">Reserva #<?= (int) $reservation['id'] ?></span>
                            <h2><?= htmlspecialchars($reservation['hotel_nombre']) ?></h2>
                            <p>
                                <?= htmlspecialchars($reservation['destino_nombre']) ?> ·
                                <?= htmlspecialchars($reservation['fecha_checkin']) ?> al
                                <?= htmlspecialchars($reservation['fecha_checkout']) ?>
                            </p>
                        </div>
                        <span class="status <?= htmlspecialchars($reservation['estado']) ?>">
                            <?= htmlspecialchars(ucfirst($reservation['estado'])) ?>
                        </span>
                    </div>

                    <p><?= (int) $reservation['num_personas'] ?> persona(s)</p>

                    <?php if ($reservation['activities']): ?>
                        <div class="included">
                            <strong>Actividades incluidas</strong>
                            <?php foreach ($reservation['activities'] as $activity): ?>
                                <span><?= htmlspecialchars($activity['nombre']) ?> · <?= htmlspecialchars($activity['fecha']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <strong>
                        Total: ₡<?= number_format((float) $reservation['hospedaje_total'] + (float) $reservation['actividades_total'], 0) ?>
                    </strong>
                </article>
            <?php endforeach; ?>

            <p class="filter-empty" data-filter-empty hidden>No encontramos reservas con esos criterios.</p>

            <?php if (!$reservations): ?>
                <div class="panel empty-state">
                    <h2>Aún no tenés reservas</h2>
                    <p>Explorá un destino y elegí tu hotel para iniciar tu viaje.</p>
                    <a class="btn-primary" href="/destination">Explorar destinos</a>
                </div>
            <?php endif; ?>
        </section>
    </main>
    </div><!-- .dashboard-container -->

    <script src="/assets/js/filters.js"></script>
</body>

</html>