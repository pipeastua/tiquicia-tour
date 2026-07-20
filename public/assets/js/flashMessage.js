document.addEventListener('DOMContentLoaded', () => {
    if (typeof Toastify === 'undefined') {
        return;
    }

    const messages = window.flashMessages || [];

    messages.forEach(({ type, message }) => {
        const backgroundColor = type === 'success' ? '#2e7d32' : '#c62828';

        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'right',
            stopOnFocus: true,
            style: {
                background: backgroundColor,
                borderRadius: '8px',
                boxShadow: '0 8px 24px rgba(0, 0, 0, 0.15)'
            }
        }).showToast();
    });
});
