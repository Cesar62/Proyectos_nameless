//Modales
var Modal = document.getElementById('modal');
var Modal2 = document.getElementById('modal2');
var Modal3 = document.getElementById('modal3');
var closeModalButton = document.querySelectorAll('.CloseModal');

closeModalButton.forEach(function(button) {
    button.addEventListener('click', function() {
        if (Modal) Modal.classList.add('hidden'); // Oculta el modal
        if (Modal2) Modal2.classList.add('hidden'); // Oculta el modal2
        if (Modal3) Modal3.classList.add('hidden'); // Oculta el modal3
    });
});