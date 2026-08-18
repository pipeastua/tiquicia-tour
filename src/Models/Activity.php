<?php

require_once __DIR__ . '/../core/DataBase.php';

class Activity
{
    public static function getAll(): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->query("SELECT a.id, a.nombre, a.descripcion, a.precio, d.nombre AS destino_nombre FROM actividades a INNER JOIN destinos d ON d.id = a.destino_id WHERE a.activo = TRUE AND a.deleted_at IS NULL ORDER BY d.nombre, a.nombre");
        return $stmt->fetchAll();
    }
}
