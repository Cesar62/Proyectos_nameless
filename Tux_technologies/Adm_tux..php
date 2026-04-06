<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/rostro_tux_T.png">
    <link rel="stylesheet" href="../src/output.css">
    <title>Admin_tux</title>
</head>

<body class="bg-slate-900">
    <!-- Navbar -->
    <nav class="flex flex-row z-10 fixed bg-black p-2 w-full text-white font-bold text-xl">
        <div class=" flex basis-full  justify-start">
            <a href="Adm_M.html">
                <img src="imagenes/Logo_tux_technologies.jpeg" alt="Tux Technologies logo" class="ml-20 inline-30">
            </a>
        </div>
        <div class=" flex basis-full justify-center"></div>
        <div class="flex flex-row basis-full items-center justify-end gap-4 tracking-widest mr-10">
            <button class="md:hidden cursor-pointer" onclick="toggleMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <a href="#Inicio"
                class="hover:text-gray-600 hover:bg-white rounded-lg p-2 md:visible invisible md:inline-block hidden">INICIO</a>
            <a href="#Producto"
                class="hover:text-gray-600 hover:bg-white rounded-lg p-2 md:visible invisible md:inline-block hidden">PRODUCTOS</a>
            <a href="#Contacto"
                class="hover:text-gray-600 hover:bg-white rounded-lg p-2 md:visible invisible md:inline-block hidden">CONTACTO</a>
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center cursor-pointer">
                <img src="imagenes/iconos/icono_persona.svg">
            </div>
        </div>
    </nav>

    <!--espacio de relleno-->
    <div class="h-16"></div>

    <!-- Menu del admin -->
    <section class="flex flex-col items-center mt-8">
        <div class="flex flex-col w-[75%] items-center p-8 border-black border-2 rounded-lg bg-gray-300">
            <h1 class="text-4xl font-bold">Panel de Administración</h1>
            <div class="flex flex-row items-center p-4 justify-center gap-4 ">
                <input type="text" placeholder="Nombre" class="p-2 border-black border-2 rounded-lg">
                <select id="acciones" class="p-1 w-60 cursor-pointer border-black border-2 rounded-lg">
                    <option value="Crear">Que Desea Crear</option>
                    <option value="Producto">Producto</option>
                    <option value="Categoria">Categoria</option>
                </select>
            </div>
            <div id="productos" class="flex flex-col items-center justify-center gap-4 hidden">
                <div class="flex flex-row items-center gap-4">
                    <input type="text" placeholder="Precio" oninput="this.value = this.value.replace(/[a-zA-Z]/g, '')"
                        class="p-2 border-black border-2 rounded-lg appearance-none">
                    <select class="p-1 w-60 cursor-pointer border-black border-2 rounded-lg">
                        <option value="Categoria">Categoria</option>
                        <option value="Categoria1">Categoria 1</option>
                        <option value="Categoria2">Categoria 2</option>
                        <option value="Categoria3">Categoria 3</option>
                    </select>
                </div>
                <div class="flex flex-row items-center gap-4">
                    <input type="text" placeholder="Marca" class="p-2 border-black border-2 rounded-lg">
                    <input type="text" placeholder="cantidad" oninput="this.value = this.value.replace(/[a-zA-Z]/g, '')"
                        class="p-2 w-60 border-black border-2 rounded-lg appearance-none">
                </div>
            </div>

            <!-- Categoria -->
            <div id="Categoria" class="flex flex-col items-center p-4 justify-center gap-5 hidden">
                <div class="flex flex-row items-center gap-4">
                    <textarea placeholder="Descripcion"
                        class="p-2 w-100 border-black border-2 rounded-lg resize-none"></textarea>
                </div>
            </div>


            <!-- Agregar imagen-->
            <div id="Imagen" class="flex flex-row p-2 items-center gap-4 hidden">
                <input type="file" accept="image/*" id="fileInput" class="hidden">
                <button onclick="document.getElementById('fileInput').click()"
                    class="cursor-pointer hover:scale-105 px-4 py-2 bg-blue-500 text-white rounded-lg">Subir
                    Imagen</button>
                <div id="preview" class="w-64 h-64 border-2 border-black rounded-lg flex items-center justify-center">
                    <span class="cursor-default text-gray-500">Vista previa de la imagen</span>
                </div>
                <!-- Botones-->
                <div class="flex flex-col items-center gap-4">
                    <button id="Guardar"
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-green-500 text-white rounded-lg">Guardar</button>
                    <button id="Buscar"
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-yellow-500 text-white rounded-lg">Buscar</button>
                    <button
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-red-500 text-white rounded-lg">Eliminar</button>
                    <button
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-blue-500 text-white rounded-lg">Actualizar</button>
                </div>
            </div>

        </div>

        <!-- Modal-->
        <div id="modal" class="fixed inset-0 bg-black/75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg">
                <input id="M_Title" type="text" class="text-2xl font-bold mb-4" value="">
                <p id="M_content" class="mb-4"></p>
                <div class="flex flex-row items-center gap-4 text-white">
                    <button id="AceptModal"
                        class="cursor-pointer hover:scale-105 px-4 py-2 bg-green-500 rounded-lg">Si</button>
                    <button id="closeModal"
                        class="cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-red rounded-lg">NO</button>
                </div>

            </div>
        </div>
    </section>
</body>

<script>
var accionesSelect = document.getElementById('acciones');
var ImagenDiv = document.getElementById('Imagen');
var productosDiv = document.getElementById('productos');
var categoriaDiv = document.getElementById('Categoria');
var Editar_crearSelect = document.getElementById('Editar_crear');


if (accionesSelect) { // Verifica si el elemento existe antes de agregar el event listener
    accionesSelect.addEventListener('change',
function() { //El addEventListener se encarga de detectar el cambio en el select y ejecutar la función cada vez que se selecciona una opción diferente
        var selectedValue = this.value;
        switch (selectedValue) {
            case 'Crear':
                ImagenDiv.classList.add('hidden');
                productosDiv.classList.add('hidden');
                categoriaDiv.classList.add('hidden');
                break;
            case 'Producto':
                ImagenDiv.classList.remove('hidden');
                productosDiv.classList.remove('hidden');
                categoriaDiv.classList.add('hidden');
                break;
            case 'Categoria':
                productosDiv.classList.add('hidden');
                categoriaDiv.classList.remove('hidden');
                ImagenDiv.classList.remove('hidden');
                break;
            default:
                console.log('Opción no válida');
        }
    });
}

var fileInput = document.getElementById('fileInput');
var preview = document.getElementById('preview');

if (fileInput) {
    fileInput.addEventListener('change', function() {
        var file = this.files[0]; //Obtiene la primera imagen seleccionada
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result +
                    '" class="w-full h-full object-cover rounded-lg">';
            }
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '<span class="text-gray-500">Vista previa de la imagen</span>';
        }
    });
}

//Funciones del modal

var Modal = document.getElementById('modal');
var closeModalButton = document.getElementById('closeModal');
var GuardarButton = document.getElementById('Guardar');
var BuscarButton = document.getElementById('Buscar');
var M_Title = document.getElementById('M_Title');
var M_Content = document.getElementById('M_content');

if (GuardarButton) {
    GuardarButton.addEventListener('click', function() {
        Modal.classList.remove('hidden');
        M_Title.value = "Guardar Producto";
        M_Content.textContent = "¿Esta seguro de guardar " + accionesSelect.value +
        " ?"; //Cambia el texto segun la seleccion
    });
}

if (BuscarButton) {
    BuscarButton.addEventListener('click', function() {
        Modal.classList.remove('hidden');
        M_Title.value = "Buscar Producto";
        M_Content.textContent = "¿Desea buscar " + accionesSelect.value +
        " ?"; //Cambia el texto segun la seleccion 
    });
}

if (closeModalButton) {
    closeModalButton.addEventListener('click', function() {
        Modal.classList.add('hidden');
    });
}

//Si recarga pagina reiniciar select 
window.onbeforeunload = function(e) {
  accionesSelect.selectedIndex = 0; // Reinicia el select al valor predeterminado
};
</script>

</html>