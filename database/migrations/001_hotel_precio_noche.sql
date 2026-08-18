ALTER TABLE hoteles
    ADD COLUMN precio_noche DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER calificacion;

UPDATE hoteles
SET precio_noche = CASE nombre
    WHEN 'Cariblue Beach & Jungle Resort' THEN 85000
    WHEN 'Hotel Belmar' THEN 145000
    WHEN 'Hotel La Mariposa' THEN 120000
    WHEN 'Hotel Los Lagos Spa & Resort' THEN 90000
    WHEN 'Hotel Parador Resort & Spa' THEN 175000
    WHEN 'Jardín Del Edén Boutique Hotel' THEN 150000
    WHEN 'Le Caméléon Boutique Hotel' THEN 125000
    WHEN 'Monteverde Lodge & Gardens' THEN 145000
    WHEN 'Tabacón Thermal Resort & Spa' THEN 220000
    WHEN 'Tamarindo Diria Beach Resort' THEN 115000
    ELSE 85000
END;
