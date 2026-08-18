<?php

function destinationImage(string $name): string
{
    $images = [
        'La Fortuna de San Carlos' => 'La Fortuna.jpg',
        'Monteverde' => 'Monteverde.jpg',
        'Manuel Antonio' => 'Manuel Antonio.jpg',
        'Puerto Viejo de Talamanca' => 'Puerto Viejo.jpg',
        'Tamarindo' => 'Tamarindo.jpg',
    ];

    return $images[$name] ?? '';
}

function hotelImage(string $name): string
{
    $images = [
        'Cariblue Beach & Jungle Resort' => 'Cariblue Beach & Jungle Resort.jpg',
        'Hotel Belmar' => 'Hotel Belmar.jpg',
        'Hotel La Mariposa' => 'Hotel La Mariposa.jpg',
        'Hotel Los Lagos Spa & Resort' => 'Hotel Los Lagos Spa & Resort.jpg',
        'Hotel Parador Resort & Spa' => 'Hotel Parador Resort & Spa.jpg',
        'Jardín Del Edén Boutique Hotel' => 'Jardín Del Edén Boutique Hotel.jpg',
        'Le Caméléon Boutique Hotel' => 'Le Caméléon Boutique Hotel.jpg',
        'Monteverde Lodge & Gardens' => 'Monteverde Lodge & Gardens.jpg',
        'Tabacón Thermal Resort & Spa' => 'Tabacón Thermal Resort & Spa.jpg',
        'Tamarindo Diria Beach Resort' => 'Tamarindo Diria Beach Resort.jpg',
    ];

    return $images[$name] ?? '';
}
