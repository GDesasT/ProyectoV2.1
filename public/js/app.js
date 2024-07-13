document.addEventListener("DOMContentLoaded", function () {
    var now = new Date();
    var hours = now.getHours();
    var text = document.getElementById('desayunos');

    if (hours >= 12) {
        text.textContent = 'Comidas';
    } else {
        text.textContent = 'Desayunos';
    }
});