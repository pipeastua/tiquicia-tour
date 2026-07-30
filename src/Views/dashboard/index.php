<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiquicia Tour</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="/assets/css/global.css">
</head>

<body>

    <?php include __DIR__ . '/../../layouts/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <div class="topbar-content">
                <h1>Tiquicia Tour</h1>
                <p>Encuentra tu próxima aventura!</p>
            </div>

            <div class="user-box">
                <span><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></span>
                <div class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['user_name'] ?? '', 0, 1))) ?></div>
            </div>
        </header>

        <section class="stats-grid">
            <article class="stat-card">
                <span class="stat-label">Destinos</span>
                <strong>1</strong>
                <p>Registrados actualmente</p>
            </article>

            <article class="stat-card">
                <span class="stat-label">Hoteles</span>
                <strong>1</strong>
                <p>Disponibles para reservar</p>
            </article>

            <article class="stat-card">
                <span class="stat-label">Actividades</span>
                <strong>10</strong>
                <p>Experiencias activas</p>
            </article>

            <article class="stat-card">
                <span class="stat-label">Reservas</span>
                <strong>1</strong>
                <p>Solicitudes recibidas</p>
            </article>
        </section>

        <section class="content-grid">
            <article class="panel featured-destination">
                <div>
                    <span class="section-label">Destino destacado</span>
                    <h2>Parque Nacional Volcán Arenal</h2>
                    <p>
                        El Parque Nacional Volcán Arenal es un ícono de Costa Rica debido a su impresionante cono perfecto de 1,633 metros de altura. Destaca por su pasada actividad volcánica, visible hoy en los senderos de lava petrificada y en sus relajantes aguas termales naturales. Además, es un refugio de rica biodiversidad tropical y el epicentro del turismo de aventura, con actividades que van desde caminatas en el bosque hasta deportes acuáticos en el vecino Lago Arenal.
                    </p>
                </div>

                <button type="button">Ver detalles</button>
            </article>

            <article class="panel">
                <span class="section-label">Últimas reservas</span>

                <div class="reservation-list">
                    <div class="reservation-item">
                        <div>
                            <strong>Daniela Fonseca</strong>
                            <p>Jardin Del Eden Boutique Hotel</p>
                            <p>Tamarindo, Guanacaste, en la costa del Pacífico de Costa Rica</p>
                            <p>12/08/2026 - 19/08/2026</p>
                            <p>2 Personas</p>
                        </div>
                        <span>Pendiente</span>
                    </div>
                </div>
            </article>
        </section>
    </main>
    </div>
</body>

</html>