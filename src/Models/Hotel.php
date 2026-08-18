<?php

require_once __DIR__ . '/../core/DataBase.php';

class Hotel
{
    public static function getAll(?int $destinationId = null): array
    {
        $pdo = DataBase::getConnection();
        if ($destinationId) {
            $stmt = $pdo->prepare("SELECT h.id, h.nombre, h.direccion, h.calificacion, h.precio_noche, h.destino_id, d.nombre AS destino_nombre FROM hoteles h INNER JOIN destinos d ON d.id = h.destino_id WHERE h.destino_id = :destino_id AND h.deleted_at IS NULL AND h.activo = TRUE ORDER BY h.calificacion DESC, h.nombre");
            $stmt->execute(['destino_id' => $destinationId]);
        } else {
            $stmt = $pdo->query("SELECT h.id, h.nombre, h.direccion, h.calificacion, h.precio_noche, h.destino_id, d.nombre AS destino_nombre FROM hoteles h INNER JOIN destinos d ON d.id = h.destino_id WHERE h.deleted_at IS NULL AND h.activo = TRUE ORDER BY d.nombre, h.nombre");
        }

        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT h.id, h.destino_id, h.nombre, h.direccion, h.calificacion, h.precio_noche, d.nombre AS destino_nombre, d.provincia, d.canton FROM hoteles h INNER JOIN destinos d ON d.id = h.destino_id WHERE h.id = :id AND h.deleted_at IS NULL AND h.activo = TRUE");
        $stmt->execute(['id' => $id]);
        $hotel = $stmt->fetch();

        return $hotel ?: null;
    }

    public static function getActivities(int $hotelId): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT a.id, a.nombre, a.descripcion, a.precio FROM hotel_actividad ha INNER JOIN actividades a ON a.id = ha.actividad_id WHERE ha.hotel_id = :hotel_id AND a.activo = TRUE AND a.deleted_at IS NULL ORDER BY a.nombre");
        $stmt->execute(['hotel_id' => $hotelId]);
        return $stmt->fetchAll();
    }
}
