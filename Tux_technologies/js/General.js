//Modales
var Modal = document.getElementById("modal");
var Modal2 = document.getElementById("modal2");
var Modal3 = document.getElementById("modal3");
var modalInfo = document.getElementById("modalInfo");

//funciones de los botones de accion espero que funcione en la mayoria de formularios
//Funciones del modal
var ActionButtons = document.querySelectorAll(".Action-B");
var M_Title = document.getElementById("M_Title");
var M_Content = document.getElementById("M_content");
var AceptModalButton = document.getElementById("AceptModal");

ActionButtons.forEach(function (button) {
  button.addEventListener("click", function () {
    // Validar campos vacíos
    var ElementosSeccion = document.querySelectorAll(
      "." + accionesSelect.value,
    );

    var vacio = false;

    for (const elemento of ElementosSeccion) { 
      if (elemento.name === "Nombre") { //encuentra el input con con el name nombre
        var Nombre = elemento.value;  //entonces obtenemos el texto del elemento
      }

      if (elemento.value.trim() === "") {
        Modal3.classList.remove("hidden"); // Muestra el modal de campos vacíos
        vacio = true;
        break;
      }
    }

    if (!vacio) {
      Modal.classList.remove("hidden"); // Muestra el modal de confirmación
      M_Title.value = button.value + " " + Nombre; // Cambia el título del modal según el botón de acción presionado
      M_Content.textContent =
        "¿Esta seguro de " + button.value + " " + Nombre + " ?"; //Cambia el texto segun la seleccion
      AceptModalButton.value = button.value; // Cambia el valor del botón de aceptar según el botón de acción presionado}
    }
  });
});

var closeModalButton = document.querySelectorAll(".CloseModal");

closeModalButton.forEach(function (button) {
  button.addEventListener("click", function () {
    if (Modal) Modal.classList.add("hidden"); // Oculta el modal
    if (Modal2) Modal2.classList.add("hidden"); // Oculta el modal2
    if (Modal3) Modal3.classList.add("hidden"); // Oculta el modal3
  });
});

//Modal de informacion y cerrar sesion
var usrlogo = document.getElementById("user_lg");
usrlogo.addEventListener("click", function() {
    modalInfo.classList.toggle("hidden");
});
