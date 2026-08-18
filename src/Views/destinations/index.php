<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinos &middot; Tiquicia Tour</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/map.css">
    <link rel="stylesheet" href="/assets/css/destinations.css">
</head>

<body>
    <?php include __DIR__ . '/../../layouts/flash_message.php'; ?>
    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-content">
                <h1>Explorar destinos</h1>
                <p>Elegí un destino para ver sus actividades y hoteles cercanos.</p>
            </div>
        </header>

        <section class="panel destinations-panel" data-filter-root data-map>
            <?php if (empty($destinations)): ?>
                <p>Todavía no hay destinos disponibles.</p>
            <?php else: ?>
                <?php $provinces = array_unique(array_column($destinations, 'provincia'));
                sort($provinces); ?>
                <div class="filter-bar" role="search">
                    <div class="search-field"><label for="destination-search">Buscar destino</label><input id="destination-search" type="search" placeholder="Nombre, provincia o cantón" data-search-input></div>
                    <div class="filter-field"><label for="destination-province">Provincia</label><select id="destination-province" data-filter="provincia">
                            <option value="">Todas las provincias</option><?php foreach ($provinces as $province): ?><option value="<?= htmlspecialchars($province) ?>"><?= htmlspecialchars($province) ?></option><?php endforeach; ?>
                        </select></div>
                </div>

                <div class="map-shell" data-map-canvas></div>

                <div class="destination-grid">
                    <?php foreach ($destinations as $destination): ?>
                        <?php
                        $image = destinationImage($destination['nombre']);
                        $summary = $destination['descripcion'] ?? '';
                        $coords = destinationCoords($destination['nombre']);
                        $location = trim($destination['provincia'] . (!empty($destination['canton']) ? ', ' . $destination['canton'] : ''));
                        ?>

                        <article
                            class="destination-card"
                            data-filter-card
                            data-provincia="<?= htmlspecialchars($destination['provincia']) ?>"
                            data-search="<?= htmlspecialchars($destination['nombre'] . ' ' . $destination['provincia'] . ' ' . ($destination['canton'] ?? '') . ' ' . $summary) ?>"
                            <?php if ($coords): ?>
                            data-lat="<?= $coords[0] ?>"
                            data-lng="<?= $coords[1] ?>"
                            data-map-name="<?= htmlspecialchars($destination['nombre']) ?>"
                            data-map-tag="<?= htmlspecialchars($location) ?>"
                            data-map-link="/destination/view?id=<?= (int) $destination['id'] ?>"
                            data-map-link-label="Explorar destino"
                            <?php endif; ?>>
                            <div class="destination-card__image">
                                <img
                                    src="/assets/images/destinations/<?= rawurlencode($image) ?>"
                                    alt="Paisaje de <?= htmlspecialchars($destination['nombre']) ?>">
                            </div>

                            <div class="card-body">
                                <h3><?= htmlspecialchars($destination['nombre']) ?></h3>

                                <p class="mini-card-tag">
                                    <?= htmlspecialchars($destination['provincia']) ?>
                                    <?= !empty($destination['canton']) ? ', ' . htmlspecialchars($destination['canton']) : '' ?>
                                </p>

                                <p>
                                    <?= htmlspecialchars(mb_strlen($summary) > 120 ? mb_substr($summary, 0, 120) . '…' : $summary) ?>
                                </p>

                                <a href="/destination/view?id=<?= (int) $destination['id'] ?>" class="btn-primary">
                                    Explorar destino
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <p class="filter-empty" data-filter-empty hidden>No encontramos destinos con esos criterios.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
    </div><!-- .dashboard-container -->

    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script src="/assets/js/flashMessage.js"></script>
    <script src="/assets/js/filters.js"></script>
    <script src="/assets/js/map.js"></script>
    <script src="/assets/js/carousel.js"></script>
</body>

</html>