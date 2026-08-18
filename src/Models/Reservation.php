<?php

require_once __DIR__ . '/../core/DataBase.php';

class Reservation
{
    public static function create(int $userId, array $data, array $activities): array
    {
        $pdo = DataBase::getConnection();
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO reservas (usuario_id, estado) VALUES (:usuario_id, 'pendiente')");
            $stmt->execute(['usuario_id' => $userId]);
            $reservationId = (int) $pdo->lastInsertId();

            $stay = $pdo->prepare("INSERT INTO reserva_hospedajes (reserva_id, hotel_id, fecha_checkin, fecha_checkout, num_personas, precio_total) VALUES (:reserva_id, :hotel_id, :checkin, :checkout, :personas, :total)");
            $stay->execute([
                'reserva_id' => $reservationId,
                'hotel_id' => $data['hotel_id'],
                'checkin' => $data['checkin'],
                'checkout' => $data['checkout'],
                'personas' => $data['personas'],
                'total' => $data['hotel_total'],
            ]);

            if ($activities) {
                $activity = $pdo->prepare("INSERT INTO reserva_actividades (reserva_id, actividad_id, fecha, cantidad_personas, precio_total) VALUES (:reserva_id, :actividad_id, :fecha, :personas, :total)");
                foreach ($activities as $item) {
                    $activity->execute(['reserva_id' => $reservationId, 'actividad_id' => $item['id'], 'fecha' => $item['fecha'], 'personas' => $data['personas'], 'total' => $item['total']]);
                }
            }
            $pdo->commit();
            return ['success' => true, 'id' => $reservationId];
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log('Error en Reservation::create: ' . $e->getMessage());
            return ['success' => false, 'error' => 'No se pudo registrar la reserva. Inténtalo nuevamente.'];
        }
    }

    public static function getByUser(int $userId): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT r.id, r.estado, r.fecha_reserva, h.nombre AS hotel_nombre, d.nombre AS destino_nombre, rh.fecha_checkin, rh.fecha_checkout, rh.num_personas, rh.precio_total AS hospedaje_total, COALESCE((SELECT SUM(ra.precio_total) FROM reserva_actividades ra WHERE ra.reserva_id = r.id), 0) AS actividades_total FROM reservas r INNER JOIN reserva_hospedajes rh ON rh.reserva_id = r.id INNER JOIN hoteles h ON h.id = rh.hotel_id INNER JOIN destinos d ON d.id = h.destino_id WHERE r.usuario_id = :user_id AND r.deleted_at IS NULL ORDER BY r.fecha_reserva DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function getActivities(int $reservationId): array
    {
        $pdo = DataBase::getConnection();
        $stmt = $pdo->prepare("SELECT a.nombre, ra.fecha, ra.cantidad_personas, ra.precio_total FROM reserva_actividades ra INNER JOIN actividades a ON a.id = ra.actividad_id WHERE ra.reserva_id = :reservation_id ORDER BY ra.fecha, a.nombre");
        $stmt->execute(['reservation_id' => $reservationId]);
        return $stmt->fetchAll();
    }
}
