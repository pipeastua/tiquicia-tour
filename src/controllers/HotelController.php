<?php

require_once __DIR__ . '/../Models/Hotel.php';
require_once __DIR__ . '/../Models/Destination.php';

class HotelController
{
    public function index()
    {
        $destinationId = isset($_GET['destino_id']) ? (int) $_GET['destino_id'] : null;
        $destination = $destinationId ? Destination::findById($destinationId) : null;
        $hotels = Hotel::getAll($destinationId);

        include __DIR__ . '/../Views/hotels/index.php';
    }
}
