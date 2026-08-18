<?php $image = hotelImage($hotel['nombre']); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($hotel['nombre']) ?> · Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/booking.css">
</head>

<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>
    <main class="main-content">
        <div class="booking-page">
            <a class="back-link" href="/hotel?destino_id=<?= (int) $hotel['destino_id'] ?>">← Volver a hoteles de <?= htmlspecialchars($hotel['destino_nombre']) ?></a>
            <section class="hotel-detail panel"><img src="/assets/images/hotels/<?= rawurlencode($image) ?>" alt="<?= htmlspecialchars($hotel['nombre']) ?>">
                <div><span class="section-label">Hospedaje en <?= htmlspecialchars($hotel['destino_nombre']) ?></span>
                    <h1><?= htmlspecialchars($hotel['nombre']) ?></h1>
                    <p><?= htmlspecialchars($hotel['direccion'] ?? '') ?></p>
                    <p class="rating">★ <?= number_format((float) $hotel['calificacion'], 1) ?> / 5</p><strong class="large-price">₡<?= number_format((float) $hotel['precio_noche'], 0) ?> <small>por noche</small></strong><a class="btn-primary" href="/reservation/create?hotel_id=<?= (int) $hotel['id'] ?>">Continuar con la reserva</a>
                </div>
            </section>
            <section class="panel section-pad"><span class="section-label">Experiencias disponibles</span>
                <h2>Actividades cerca de tu hotel</h2>
                <div class="card-grid"><?php foreach ($activities as $activity): ?><article class="mini-card">
                            <h3><?= htmlspecialchars($activity['nombre']) ?></h3>
                            <p><?= htmlspecialchars($activity['descripcion']) ?></p>
                            <p class="price">₡<?= number_format((float) $activity['precio'], 0) ?> por persona</p>
                        </article><?php endforeach; ?><?php if (!$activities): ?><p>Este hotel aún no tiene actividades vinculadas.</p><?php endif; ?></div>
            </section>
        </div>
    </main>
    </div><!-- .dashboard-container -->
</body>

</html><?php $image = hotelImage($hotel['nombre']); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($hotel['nombre']) ?> · Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/booking.css">
</head>

<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>
    <main class="main-content">
        <div class="booking-page">
            <a class="back-link" href="/hotel?destino_id=<?= (int) $hotel['destino_id'] ?>">← Volver a hoteles de <?= htmlspecialchars($hotel['destino_nombre']) ?></a>
            <section class="hotel-detail panel"><img src="/assets/images/hotels/<?= rawurlencode($image) ?>" alt="<?= htmlspecialchars($hotel['nombre']) ?>">
                <div><span class="section-label">Hospedaje en <?= htmlspecialchars($hotel['destino_nombre']) ?></span>
                    <h1><?= htmlspecialchars($hotel['nombre']) ?></h1>
                    <p><?= htmlspecialchars($hotel['direccion'] ?? '') ?></p>
                    <p class="rating">★ <?= number_format((float) $hotel['calificacion'], 1) ?> / 5</p><strong class="large-price">₡<?= number_format((float) $hotel['precio_noche'], 0) ?> <small>por noche</small></strong><a class="btn-primary" href="/reservation/create?hotel_id=<?= (int) $hotel['id'] ?>">Continuar con la reserva</a>
                </div>
            </section>
            <section class="panel section-pad"><span class="section-label">Experiencias disponibles</span>
                <h2>Actividades cerca de tu hotel</h2>
                <div class="card-grid"><?php foreach ($activities as $activity): ?><article class="mini-card">
                            <h3><?= htmlspecialchars($activity['nombre']) ?></h3>
                            <p><?= htmlspecialchars($activity['descripcion']) ?></p>
                            <p class="price">₡<?= number_format((float) $activity['precio'], 0) ?> por persona</p>
                        </article><?php endforeach; ?><?php if (!$activities): ?><p>Este hotel aún no tiene actividades vinculadas.</p><?php endif; ?></div>
            </section>
        </div>
    </main>
    </div><!-- .dashboard-container -->
</body>

</html>