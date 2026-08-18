<?php
require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../Models/Hotel.php';
require_once __DIR__ . '/../Models/Reservation.php';

class ReservationController
{
    public function index()
    {
        $reservations = Reservation::getByUser((int) $_SESSION['user_id']);
        foreach ($reservations as &$reservation) $reservation['activities'] = Reservation::getActivities((int) $reservation['id']);
        include __DIR__ . '/../Views/reservations/index.php';
    }

    public function create()
    {
        $hotel = Hotel::findById((int) ($_GET['hotel_id'] ?? $_POST['hotel_id'] ?? 0));
        if (!$hotel) {
            header('Location: /hotel');
            exit;
        }
        $availableActivities = Hotel::getActivities((int) $hotel['id']);
        $errors = [];
        $success = false;
        $data = ['checkin' => '', 'checkout' => '', 'personas' => 1];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['checkin' => $_POST['checkin'] ?? '', 'checkout' => $_POST['checkout'] ?? '', 'personas' => max(1, (int) ($_POST['personas'] ?? 1))];
            if (!isset($_POST['csrf_token']) || !Security::validateCSRFToken($_POST['csrf_token'])) $errors[] = 'La sesión expiró. Intentá de nuevo.';
            $today = date('Y-m-d');
            if (!$data['checkin'] || !$data['checkout'] || $data['checkin'] < $today || $data['checkout'] <= $data['checkin']) $errors[] = 'Seleccioná fechas válidas de llegada y salida.';
            if ($data['personas'] > 20) $errors[] = 'La reserva admite un máximo de 20 personas.';
            $allowed = array_column($availableActivities, null, 'id');
            $selected = [];
            foreach ((array) ($_POST['activities'] ?? []) as $id) {
                $id = (int) $id;
                if (!isset($allowed[$id])) continue;
                $date = $_POST['activity_date'][$id] ?? $data['checkin'];
                if ($date < $data['checkin'] || $date >= $data['checkout']) {
                    $errors[] = 'La fecha de cada actividad debe estar dentro de la estadía.';
                    break;
                }
                $selected[] = ['id' => $id, 'fecha' => $date, 'total' => $allowed[$id]['precio'] * $data['personas']];
            }
            if (!$errors) {
                $nights = (new DateTime($data['checkin']))->diff(new DateTime($data['checkout']))->days;
                $data += ['hotel_id' => (int) $hotel['id'], 'hotel_total' => $nights * (float) $hotel['precio_noche']];
                $result = Reservation::create((int) $_SESSION['user_id'], $data, $selected);
                if ($result['success']) {
                    header('Location: /reservation?created=1');
                    exit;
                }
                $errors[] = $result['error'];
            }
        }
        include __DIR__ . '/../Views/reservations/form.php';
    }
}
