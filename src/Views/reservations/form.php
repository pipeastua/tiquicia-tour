<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar reserva · Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/booking.css">
</head>

<body>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?><main class="main-content">
        <div class="booking-page"><a class="back-link" href="/hotel/view?id=<?= (int) $hotel['id'] ?>">← Regresar a <?= htmlspecialchars($hotel['nombre']) ?></a>
            <div class="booking-layout">
                <form class="panel reservation-form" method="post"><input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Security::generateCSRFToken()) ?>"><input type="hidden" name="hotel_id" value="<?= (int) $hotel['id'] ?>"><span class="section-label">Paso final</span>
                    <h1>Completa tu reserva</h1><?php if ($errors): ?><div class="form-errors"><?php foreach ($errors as $error): ?><p><?= htmlspecialchars($error) ?></p><?php endforeach; ?></div><?php endif; ?><div class="form-row">
                        <div class="form-group"><label for="checkin">Llegada</label><input required min="<?= date('Y-m-d') ?>" type="date" id="checkin" name="checkin" value="<?= htmlspecialchars($data['checkin']) ?>"></div>
                        <div class="form-group"><label for="checkout">Salida</label><input required min="<?= date('Y-m-d', strtotime('+1 day')) ?>" type="date" id="checkout" name="checkout" value="<?= htmlspecialchars($data['checkout']) ?>"></div>
                    </div>
                    <div class="form-group"><label for="personas">Cantidad de personas</label><input required min="1" max="20" type="number" id="personas" name="personas" value="<?= (int) $data['personas'] ?>"></div>
                    <fieldset>
                        <legend>Agrega actividades a tu viaje <small>(opcional)</small></legend><?php foreach ($availableActivities as $activity): ?><label class="activity-choice"><input type="checkbox" name="activities[]" value="<?= (int) $activity['id'] ?>"><span><strong><?= htmlspecialchars($activity['nombre']) ?></strong><small>₡<?= number_format((float) $activity['precio'], 0) ?> por persona</small></span><input aria-label="Fecha para <?= htmlspecialchars($activity['nombre']) ?>" type="date" name="activity_date[<?= (int) $activity['id'] ?>]" value="<?= htmlspecialchars($data['checkin']) ?>"></label><?php endforeach; ?><?php if (!$availableActivities): ?><p>No hay actividades vinculadas para este hotel.</p><?php endif; ?>
                    </fieldset><button type="submit">Confirmar solicitud de reserva</button>
                </form>
                <aside class="panel booking-summary"><span class="section-label">Tu hospedaje</span>
                    <h2><?= htmlspecialchars($hotel['nombre']) ?></h2>
                    <p><?= htmlspecialchars($hotel['destino_nombre']) ?></p>
                    <p>₡<?= number_format((float) $hotel['precio_noche'], 0) ?> por noche</p><small>El total se calcula según tus noches, personas y actividades elegidas.</small>
                </aside>
            </div>
        </div>
    </main>
    </div><!-- .dashboard-container -->
</body>

</html>