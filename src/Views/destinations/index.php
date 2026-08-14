<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinos &middot; Tiquicia Tour</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css">
    <link rel="stylesheet" href="/assets/css/global.css">
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

        <section class="panel destinations-panel">
            <?php if (empty($destinations)): ?>
                <p>Todavía no hay destinos disponibles.</p>
            <?php else: ?>
                <div class="destination-grid">
                    <?php foreach ($destinations as $destination): ?>
                        <?php
                        $image = destinationImage($destination['nombre']);
                        $summary = $destination['descripcion'] ?? '';
                        ?>

                        <article class="destination-card">
                            <div class="destination-card__image">
                                <img
                                    src="/assets/images/destinations/<?= rawurlencode($image) ?>"
                                    alt="Paisaje de <?= htmlspecialchars($destination['nombre']) ?>"
                                >
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
                </div>
            <?php endif; ?>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
    <script src="/assets/js/flashMessage.js"></script>
</body>
</html>
