<?php

require_once __DIR__ . '/../core/DataBase.php';

class Hotel
{
    public static function getAll(?int $destinationId = null): array
    {
        $pdo = DataBase::getConnection();
        if ($destinationId) {
            $stmt = $pdo->prepare("SELECT h.id, h.nombre, h.direccion, h.calificacion, h.destino_id, d.nombre AS destino_nombre FROM hoteles h INNER JOIN destinos d ON d.id = h.destino_id WHERE h.destino_id = :destino_id AND h.deleted_at IS NULL AND h.activo = TRUE ORDER BY h.calificacion DESC, h.nombre");
            $stmt->execute(['destino_id' => $destinationId]);
        } else {
            $stmt = $pdo->query("SELECT h.id, h.nombre, h.direccion, h.calificacion, h.destino_id, d.nombre AS destino_nombre FROM hoteles h INNER JOIN destinos d ON d.id = h.destino_id WHERE h.deleted_at IS NULL AND h.activo = TRUE ORDER BY d.nombre, h.nombre");
        }

        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT id, destino_id, nombre, direccion, calificacion FROM hoteles WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);
        $hotel = $stmt->fetch();

        return $hotel ?: null;
    }
}
