<?php
$featuredImage = $featuredDestination ? destinationImage($featuredDestination['nombre']) : '';
$summary = $featuredDestination['descripcion'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>

<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar">
            <div class="topbar-content">
                <h1>Tiquicia Tour</h1>
                <p>Encuentra tu próxima aventura.</p>
            </div>
            <div class="user-box"><span><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></span>
                <div class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['user_name'] ?? '', 0, 1))) ?></div>
            </div>
        </header>
        <section class="stats-grid">
            <article class="stat-card"><span class="stat-label">Destinos</span><strong><?= (int) $stats['destinations'] ?></strong>
                <p>Disponibles para explorar</p>
            </article>
            <article class="stat-card"><span class="stat-label">Hoteles</span><strong><?= (int) $stats['hotels'] ?></strong>
                <p>Disponibles para reservar</p>
            </article>
            <article class="stat-card"><span class="stat-label">Actividades</span><strong><?= (int) $stats['activities'] ?></strong>
                <p>Experiencias activas</p>
            </article>
            <article class="stat-card"><span class="stat-label">Mis reservas</span><strong><?= (int) $stats['reservations'] ?></strong>
                <p>Solicitudes registradas</p>
            </article>
        </section>
        <section class="content-grid">
            <?php if ($featuredDestination): ?>
                <article class="panel featured-destination" <?= $featuredImage ? ' style="background-image: url(\'/assets/images/destinations/' . rawurlencode($featuredImage) . '\')"' : '' ?>>
                    <div><span class="section-label">Destino destacado</span>
                        <h2><?= htmlspecialchars($featuredDestination['nombre']) ?></h2>
                        <p><?= htmlspecialchars(mb_strlen($summary) > 340 ? mb_substr($summary, 0, 340) . '…' : $summary) ?></p>
                        <p class="destination-meta"><?= (int) $featuredDestination['hotel_count'] ?> hotel(es) · <?= (int) $featuredDestination['activity_count'] ?> actividad(es)</p>
                    </div><a class="dashboard-button" href="/destination/view?id=<?= (int) $featuredDestination['id'] ?>">Ver detalles</a>
                </article>
            <?php else: ?>
                <article class="panel dashboard-empty">
                    <h2>Aún no hay destinos</h2>
                    <p>Cuando se registren destinos, aparecerán aquí.</p>
                </article>
            <?php endif; ?>
            <article class="panel"><span class="section-label">Mis últimas reservas</span>
                <div class="reservation-list"><?php foreach ($recentReservations as $reservation): ?><a class="reservation-item" href="/reservation">
                            <div><strong><?= htmlspecialchars($reservation['hotel_nombre']) ?></strong>
                                <p><?= htmlspecialchars($reservation['destino_nombre']) ?></p>
                                <p><?= htmlspecialchars($reservation['fecha_checkin']) ?> al <?= htmlspecialchars($reservation['fecha_checkout']) ?> · <?= (int) $reservation['num_personas'] ?> persona(s)</p>
                            </div><span class="reservation-state <?= htmlspecialchars($reservation['estado']) ?>"><?= htmlspecialchars(ucfirst($reservation['estado'])) ?></span>
                        </a><?php endforeach; ?><?php if (!$recentReservations): ?><div class="dashboard-reservations-empty">
                            <p>Aún no tenés reservas.</p><a class="btn-primary" href="/destination">Explorar destinos</a>
                        </div><?php endif; ?></div>
            </article>
        </section>
    </main>
    </div><!-- .dashboard-container -->
</body>

</html>