<?php
$destination = $destination ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles &middot; Tiquicia Tour</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/map.css">
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

        <section class="panel hotels-panel" data-filter-root data-map>
            <?php if (empty($hotels)): ?>
                <p>No se encontraron hoteles<?= $destination ? ' para este destino' : '' ?>.</p>
            <?php else: ?>
                <?php $hotelDestinations = array_unique(array_column($hotels, 'destino_nombre'));
                sort($hotelDestinations); ?>
                <div class="filter-bar" role="search">
                    <div class="search-field"><label for="hotel-search">Buscar hotel</label><input id="hotel-search" type="search" placeholder="Nombre, ubicación o destino" data-search-input></div>
                    <?php if (!$destination): ?><div class="filter-field"><label for="hotel-destination">Destino</label><select id="hotel-destination" data-filter="destino">
                                <option value="">Todos los destinos</option><?php foreach ($hotelDestinations as $hotelDestination): ?><option value="<?= htmlspecialchars($hotelDestination) ?>"><?= htmlspecialchars($hotelDestination) ?></option><?php endforeach; ?>
                            </select></div><?php endif; ?>
                    <div class="filter-field"><label for="hotel-rating">Calificación</label><select id="hotel-rating" data-filter="rating">
                            <option value="">Todas</option>
                            <option value="alta">4.5 o más</option>
                            <option value="media">Menos de 4.5</option>
                        </select></div>
                </div>

                <div class="map-shell" data-map-canvas></div>

                <div class="hotel-grid">
                    <?php foreach ($hotels as $hotel): ?>
                        <?php
                        $image = hotelImage($hotel['nombre']);
                        $coords = hotelCoords($hotel['nombre']);
                        $priceLabel = 'Desde ₡' . number_format((float) $hotel['precio_noche'], 0) . ' por noche';
                        ?>

                        <article
                            class="hotel-card"
                            data-filter-card
                            data-destino="<?= htmlspecialchars($hotel['destino_nombre']) ?>"
                            data-rating="<?= (float) $hotel['calificacion'] >= 4.5 ? 'alta' : 'media' ?>"
                            data-search="<?= htmlspecialchars($hotel['nombre'] . ' ' . $hotel['destino_nombre'] . ' ' . ($hotel['direccion'] ?? '')) ?>"
                            <?php if ($coords): ?>
                            data-lat="<?= $coords[0] ?>"
                            data-lng="<?= $coords[1] ?>"
                            data-map-name="<?= htmlspecialchars($hotel['nombre']) ?>"
                            data-map-tag="<?= htmlspecialchars($hotel['destino_nombre']) ?>"
                            data-map-address="<?= htmlspecialchars($hotel['direccion'] ?? '') ?>"
                            data-map-price="<?= htmlspecialchars($priceLabel) ?>"
                            data-map-rating="<?= number_format((float) $hotel['calificacion'], 1) ?>"
                            data-map-link="/hotel/view?id=<?= (int) $hotel['id'] ?>"
                            data-map-link-label="Ver hotel y reservar"
                            <?php endif; ?>>
                            <div class="hotel-card__image">
                                <img
                                    src="/assets/images/hotels/<?= rawurlencode($image) ?>"
                                    alt="Instalaciones de <?= htmlspecialchars($hotel['nombre']) ?>">
                            </div>

                            <div class="card-body">
                                <h3><?= htmlspecialchars($hotel['nombre']) ?></h3>

                                <?php if (!$destination): ?>
                                    <p class="mini-card-tag"><?= htmlspecialchars($hotel['destino_nombre']) ?></p>
                                <?php endif; ?>

                                <p><?= htmlspecialchars($hotel['direccion'] ?? '') ?></p>

                                <p class="hotel-card__price">Desde ₡<?= number_format((float) $hotel['precio_noche'], 0) ?> por noche</p>

                                <span
                                    class="hotel-card__rating"
                                    aria-label="Calificación <?= number_format((float) $hotel['calificacion'], 1) ?> de 5">
                                    ★ <?= number_format((float) $hotel['calificacion'], 1) ?>
                                </span>
                                <a class="btn-primary" href="/hotel/view?id=<?= (int) $hotel['id'] ?>">Ver hotel y reservar</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <p class="filter-empty" data-filter-empty hidden>No encontramos hoteles con esos criterios.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
    </div><!-- .dashboard-container -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script src="/assets/js/filters.js"></script>
    <script src="/assets/js/map.js"></script>
    <script src="/assets/js/carousel.js"></script>
</body>

</html>