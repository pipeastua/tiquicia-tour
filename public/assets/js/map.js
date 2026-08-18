// Inicializa un mapa por cada contenedor que incluya tarjetas con coordenadas.
document.querySelectorAll('[data-map]').forEach((root) => {
    const canvas = root.querySelector('[data-map-canvas]');

    if (!canvas || typeof L === 'undefined') {
        return;
    }

    const points = [...root.querySelectorAll('[data-lat][data-lng]')];
    const map = L.map(canvas, { scrollWheelZoom: true });
    const defaultLocation = [9.7489, -83.7534];

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18,
    }).addTo(map);

    if (!points.length) {
        map.setView(defaultLocation, 8);
        return;
    }

    const markers = points.reduce((list, card) => {
        const lat = Number.parseFloat(card.dataset.lat);
        const lng = Number.parseFloat(card.dataset.lng);

        if (Number.isNaN(lat) || Number.isNaN(lng)) {
            return list;
        }

        const rows = [];

        if (card.dataset.mapTag) {
            rows.push(`<span class="map-popup__tag">${card.dataset.mapTag}</span>`);
        }

        if (card.dataset.mapAddress) {
            rows.push(`<span class="map-popup__address">${card.dataset.mapAddress}</span>`);
        }

        if (card.dataset.mapPrice || card.dataset.mapRating) {
            const price = card.dataset.mapPrice
                ? `<span class="map-popup__price">${card.dataset.mapPrice}</span>`
                : '';
            const rating = card.dataset.mapRating
                ? `<span class="map-popup__rating">★ ${card.dataset.mapRating}</span>`
                : '';

            rows.push(`<span class="map-popup__row">${price}${rating}</span>`);
        }

        if (card.dataset.mapLink) {
            const label = card.dataset.mapLinkLabel || 'Ver más';
            rows.push(`<a class="map-popup__link" href="${card.dataset.mapLink}">${label}</a>`);
        }

        const popupHtml = `
            <div class="map-popup">
                <span class="map-popup__title">${card.dataset.mapName || ''}</span>
                ${rows.join('')}
            </div>
        `;
        const marker = L.marker([lat, lng]).addTo(map).bindPopup(popupHtml);

        // Conecta el marcador con la tarjeta correspondiente del listado.
        marker.on('click', () => {
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        list.push(marker);
        return list;
    }, []);

    if (!markers.length) {
        map.setView(defaultLocation, 8);
        return;
    }

    if (markers.length === 1) {
        map.setView(markers[0].getLatLng(), 13);
        return;
    }

    map.fitBounds(L.featureGroup(markers).getBounds().pad(0.2));
});
