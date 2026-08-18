<?php

function destinationCoords(string $name): ?array
{
    $coords = [
        'La Fortuna de San Carlos'   => [10.4713, -84.6425],
        'Monteverde'                 => [10.3010, -84.8232],
        'Manuel Antonio'             => [9.3925, -84.1417],
        'Puerto Viejo de Talamanca'  => [9.6551, -82.7539],
        'Tamarindo'                  => [10.2993, -85.8371],
    ];

    return $coords[$name] ?? null;
}

function hotelCoords(string $name): ?array
{
    $coords = [
        'Cariblue Beach & Jungle Resort'   => [9.6499, -82.7396],
        'Hotel Belmar'                     => [10.3151, -84.8129],
        'Hotel La Mariposa'                => [9.3891, -84.1435],
        'Hotel Los Lagos Spa & Resort'     => [10.4780, -84.6889],
        'Hotel Parador Resort & Spa'       => [9.3844, -84.1487],
        'Jardín Del Edén Boutique Hotel'   => [10.2965, -85.8377],
        'Le Caméléon Boutique Hotel'       => [9.6564, -82.7519],
        'Monteverde Lodge & Gardens'       => [10.3200, -84.8171],
        'Tabacón Thermal Resort & Spa'     => [10.4867, -84.6961],
        'Tamarindo Diria Beach Resort'     => [10.2989, -85.8395],
    ];

    return $coords[$name] ?? null;
}
