-- Precios estimados en colones costarricenses, por persona.
UPDATE actividades
SET precio = CASE nombre
    WHEN 'Caminata Catarata La Fortuna' THEN 12000
    WHEN 'Canopy sobre el bosque' THEN 40000
    WHEN 'Tour de aguas termales' THEN 45000
    WHEN 'Caminata Parque Nacional Manuel Antonio' THEN 25000
    WHEN 'Paseo en catamarán al atardecer' THEN 55000
    WHEN 'Tour de kayak en manglar' THEN 32000
    WHEN 'Canopy y zip-line' THEN 45000
    WHEN 'Puentes colgantes del bosque nuboso' THEN 35000
    WHEN 'Tour nocturno de vida silvestre' THEN 25000
    WHEN 'Caminata cultural afrocaribeña' THEN 22000
    WHEN 'Snorkel en arrecife de Cahuita' THEN 38000
    WHEN 'Tour de bicicleta por la costa Caribe' THEN 22000
    WHEN 'Clase de surf' THEN 32000
    WHEN 'Tour de snorkel en Catalinas' THEN 60000
    WHEN 'Tour nocturno Parque Las Baulas' THEN 28000
    ELSE precio
END;
