-- Tabla Padre PK: id

CREATE TABLE usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'usuario') DEFAULT 'usuario',
    activo TINYINT(1) DEFAULT 1,
    intentos_fallidos INT DEFAULT 0,
    ultimo_intento DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    -- Índices para mejorar rendimiento
    INDEX idx_email (email),
    INDEX idx_activo (activo),
    INDEX idx_role (role)
);
-- 1. destinos (tabla raíz de ubicación)

CREATE TABLE destinos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    provincia VARCHAR(100) NOT NULL,
    canton VARCHAR(100),
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- 2. hoteles (depende de destinos)

CREATE TABLE hoteles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    destino_id INT UNSIGNED NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    direccion VARCHAR(255),
    calificacion DECIMAL(2,1) DEFAULT 0.0,
    precio_noche DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    activo BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_hoteles_destino
        FOREIGN KEY (destino_id) REFERENCES destinos(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 3. actividades (depende de destinos, no de hoteles)

CREATE TABLE actividades (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    destino_id INT UNSIGNED NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    activo BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_actividades_destino
        FOREIGN KEY (destino_id) REFERENCES destinos(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 4. hotel_actividad (pivote N:M entre hoteles y actividades)

CREATE TABLE hotel_actividad (
    hotel_id INT UNSIGNED NOT NULL,
    actividad_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (hotel_id, actividad_id),
    CONSTRAINT fk_ha_hotel
        FOREIGN KEY (hotel_id) REFERENCES hoteles(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ha_actividad
        FOREIGN KEY (actividad_id) REFERENCES actividades(id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- 5. reservas (cabecera, depende de usuarios)

CREATE TABLE reservas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    estado ENUM('pendiente','confirmada','cancelada') NOT NULL DEFAULT 'pendiente',
    fecha_reserva DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    CONSTRAINT fk_reservas_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 6. reserva_hospedajes (detalle de reserva de hotel)

CREATE TABLE reserva_hospedajes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT UNSIGNED NOT NULL,
    hotel_id INT UNSIGNED NOT NULL,
    fecha_checkin DATE NOT NULL,
    fecha_checkout DATE NOT NULL,
    num_personas SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    precio_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_rh_reserva
        FOREIGN KEY (reserva_id) REFERENCES reservas(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_rh_hotel
        FOREIGN KEY (hotel_id) REFERENCES hoteles(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 7. reserva_actividades (detalle de reserva de actividad)

CREATE TABLE reserva_actividades (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT UNSIGNED NOT NULL,
    actividad_id INT UNSIGNED NOT NULL,
    fecha DATE NOT NULL,
    cantidad_personas SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    precio_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_ra_reserva
        FOREIGN KEY (reserva_id) REFERENCES reservas(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_ra_actividad
        FOREIGN KEY (actividad_id) REFERENCES actividades(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
