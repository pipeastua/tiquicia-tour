// Filtra las tarjetas usando el texto buscado y los selectores asociados.
document.querySelectorAll('[data-filter-root]').forEach((root) => {
    const search = root.querySelector('[data-search-input]');
    const filters = [...root.querySelectorAll('[data-filter]')];
    const cards = [...root.querySelectorAll('[data-filter-card]')];
    const empty = root.querySelector('[data-filter-empty]');

    const normalize = (value) => String(value || '')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase();

    const applyFilters = () => {
        const query = normalize(search?.value);
        let visible = 0;
        cards.forEach((card) => {
            const matchesSearch = !query || normalize(card.dataset.search).includes(query);
            const matchesFilters = filters.every((filter) => {
                const value = filter.value;
                return !value || normalize(card.dataset[filter.dataset.filter]) === normalize(value);
            });
            const show = matchesSearch && matchesFilters;
            card.hidden = !show;
            if (show) {
                visible++;
            }
        });

        if (empty) {
            empty.hidden = visible > 0;
        }
    };

    search?.addEventListener('input', applyFilters);
    filters.forEach((filter) => filter.addEventListener('change', applyFilters));
});
