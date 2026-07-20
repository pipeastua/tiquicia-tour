document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.toggle-password');

    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.target);
            const lookIcon = button.querySelector('.look-icon');
            const crossIcon = button.querySelector('.cross-icon');

            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                lookIcon.style.display = 'none';
                crossIcon.style.display = 'inline-block';
            } else {
                input.type = 'password';
                lookIcon.style.display = 'inline-block';
                crossIcon.style.display = 'none';
            }
        });
    });
});