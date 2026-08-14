<?php

require_once __DIR__ . '/../core/DataBase.php';

class Destination
{
    public static function getAll(): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->query("SELECT id, nombre, provincia, canton, descripcion FROM destinos WHERE deleted_at IS NULL ORDER BY nombre");

        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT id, nombre, provincia, canton, descripcion FROM destinos WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute(['id' => $id]);
        $destination = $stmt->fetch();

        return $destination ?: null;
    }

    public static function getActivities(int $destinationId): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT id, nombre, descripcion, precio FROM actividades WHERE destino_id = :destino_id AND activo = TRUE AND deleted_at IS NULL");
        $stmt->execute(['destino_id' => $destinationId]);

        return $stmt->fetchAll();
    }

    public static function create(string $nombre, string $provincia, string $canton, string $descripcion): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("INSERT INTO destinos (nombre, provincia, canton, descripcion) VALUES (:nombre, :provincia, :canton, :descripcion)");

        try {
            $stmt->execute(compact('nombre', 'provincia', 'canton', 'descripcion'));
            return ['success' => true, 'id' => (int) $pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log('Error en Destination::create: ' . $e->getMessage());
            return ['success' => false, 'error' => 'No se pudo crear el destino. Intente nuevamente.'];
        }
    }

    public static function update(int $id, string $nombre, string $provincia, string $canton, string $descripcion): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("UPDATE destinos SET nombre = :nombre, provincia = :provincia, canton = :canton, descripcion = :descripcion WHERE id = :id AND deleted_at IS NULL");

        try {
            $stmt->execute(compact('id', 'nombre', 'provincia', 'canton', 'descripcion'));
            return ['success' => true];
        } catch (PDOException $e) {
            error_log('Error en Destination::update: ' . $e->getMessage());
            return ['success' => false, 'error' => 'No se pudo actualizar el destino. Intente nuevamente.'];
        }
    }

    public static function softDelete(int $id): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("UPDATE destinos SET deleted_at = NOW() WHERE id = :id AND deleted_at IS NULL");

        try {
            $stmt->execute(['id' => $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            error_log('Error en Destination::softDelete: ' . $e->getMessage());
            return ['success' => false, 'error' => 'No se pudo eliminar el destino.'];
        }
    }
}
