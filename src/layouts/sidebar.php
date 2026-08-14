<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isDestination = $currentPath === '/destination' || strpos($currentPath, '/destination/') === 0;
$isHotel = $currentPath === '/hotel';
?>
<div class="dashboard-container">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-icon" aria-hidden="true">TT</span>
            <div><h2>Tiquicia Tour</h2></div>
        </div>

        <nav class="menu" aria-label="Navegación principal">
            <a href="/dashboard"<?= $currentPath === '/dashboard' ? ' class="active"' : '' ?>>Inicio</a>
            <a href="/destination"<?= $isDestination ? ' class="active"' : '' ?>>Destinos</a>
            <a href="/hotel"<?= $isHotel ? ' class="active"' : '' ?>>Hoteles</a>
            <a href="#">Actividades</a>
            <a href="#">Reservas</a>
            <a href="#">Usuario</a>
        </nav>

        <div class="sidebar-footer">
            <a href="/logout">Cerrar sesión</a>
        </div>
    </aside>
