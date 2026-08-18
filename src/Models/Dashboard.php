<?php

require_once __DIR__ . '/../core/DataBase.php';

class Dashboard
{
    public static function getStats(int $userId): array
    {
        $pdo = DataBase::getConnection();
        $counts = ['destinations' => "SELECT COUNT(*) FROM destinos WHERE deleted_at IS NULL", 'hotels' => "SELECT COUNT(*) FROM hoteles WHERE deleted_at IS NULL AND activo = TRUE", 'activities' => "SELECT COUNT(*) FROM actividades WHERE deleted_at IS NULL AND activo = TRUE"];
        $stats = [];
        foreach ($counts as $key => $query) $stats[$key] = (int) $pdo->query($query)->fetchColumn();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservas WHERE usuario_id = :user_id AND deleted_at IS NULL");
        $stmt->execute(['user_id' => $userId]);
        $stats['reservations'] = (int) $stmt->fetchColumn();
        return $stats;
    }

    public static function getFeaturedDestination(): ?array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->query("SELECT d.id, d.nombre, d.descripcion, COUNT(DISTINCT h.id) AS hotel_count, COUNT(DISTINCT a.id) AS activity_count FROM destinos d LEFT JOIN hoteles h ON h.destino_id = d.id AND h.deleted_at IS NULL AND h.activo = TRUE LEFT JOIN actividades a ON a.destino_id = d.id AND a.deleted_at IS NULL AND a.activo = TRUE WHERE d.deleted_at IS NULL GROUP BY d.id ORDER BY activity_count DESC, hotel_count DESC, d.nombre LIMIT 1");
        return $stmt->fetch() ?: null;
    }
}
