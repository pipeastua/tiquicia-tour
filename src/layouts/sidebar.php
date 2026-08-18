<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isDestination = $currentPath === '/destination' || strpos($currentPath, '/destination/') === 0;
$isHotel = $currentPath === '/hotel';
$isActivity = $currentPath === '/activity';
$isReservation = $currentPath === '/reservation' || strpos($currentPath, '/reservation/') === 0;
$isUser = $currentPath === '/user';
?>
<div class="dashboard-container">
    <aside class="sidebar">
        <div class="brand">
            <span class="brand-icon" aria-hidden="true">TT</span>
            <div>
                <h2>Tiquicia Tour</h2>
            </div>
        </div>

        <nav class="menu" aria-label="Navegación principal">
            <a href="/dashboard" <?= $currentPath === '/dashboard' ? ' class="active"' : '' ?>>Inicio</a>
            <a href="/destination" <?= $isDestination ? ' class="active"' : '' ?>>Destinos</a>
            <a href="/hotel" <?= $isHotel ? ' class="active"' : '' ?>>Hoteles</a>
            <a href="/activity" <?= $isActivity ? ' class="active"' : '' ?>>Actividades</a>
            <a href="/reservation" <?= $isReservation ? ' class="active"' : '' ?>>Mis reservas</a>
            <a href="/user" <?= $isUser ? ' class="active"' : '' ?>>Mi perfil</a>
        </nav>

        <div class="sidebar-footer">
            <a href="/logout">Cerrar sesión</a>
        </div>
    </aside>