<?php
require 'Config/BD.php';

session_start();

$Session_estado = $_SESSION["SESION_E"]["Sesion"] ?? false; //Se guarda el estado de inicio de sesion del empleado
$Empleado_Info = $_SESSION["SESION_E"]["Sesion_Info"] ?? [];   //Informacion del empleado
$var = false;

$btn = $_POST['Accion'] ?? null;
$Acciones = $_POST['acciones'] ?? "Error";

if ($btn) {
    switch ($btn) {
        case 'Guardar':
            if ($Acciones == "Producto") {
                // Aquí puedes agregar la lógica para manejar la acción de "Si" para Producto
                echo "Has Guardado el producto.";
            } elseif ($Acciones == "Categoria") {
                // Aquí puedes agregar la lógica para manejar la acción de "Si" para Categoria
                echo "Has Guardado la categoria.";
            } else {
                echo "Acción no reconocida para Guardar.";
            }
            break;
        case 'Buscar':
            // Aquí puedes agregar la lógica para manejar la acción de "Si"
            echo "Has Buscado el producto.";
            break;

        case 'Eliminar':
            // Aquí puedes agregar la lógica para manejar la acción de "Si"
            echo "Has Eliminado el producto.";
            break;
        case 'Actualizar':
            // Aquí puedes agregar la lógica para manejar la acción de "Si" 
            echo "Has Actualizado el producto.";
            break;
        // Puedes agregar más casos para otras acciones si es necesario
        default:
            echo "Acción no reconocida.";
    }


    echo "
        <div id=modal2 class='fixed inset-0 z-20 bg-black/75 flex items-center justify-center'>
            <div class='bg-white p-6 rounded-lg'>
                <h2 class='text-2xl font-bold mb-4'>Resultado de la acción</h2>
                <p class='mb-4'>$btn $Acciones con exito</p>
                <button class='cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-white rounded-lg CloseModal'>Cerrar</button>
            </div>
        </div>
    ";
}

if (!$Session_estado) {
    header("Location: Adm_M.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/rostro_tux_T.png">
    <link rel="stylesheet" href="../src/output.css">
    <title>Empleado_tux</title>
</head>

<body class="bg-slate-900">
    <!-- Navbar -->
    <nav class="flex flex-row z-10 fixed bg-black p-2 w-full text-white font-bold text-xl">
        <div class=" flex basis-full  justify-start">
            <a href="Adm_M.php">
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


    <!-- Menu del Empleado -->
    <form action="Adm_tux.php" method="post" class="flex flex-col items-center mt-8">
        <div class="flex flex-col w-[75%] items-center p-8 border-black border-2 rounded-lg bg-gray-300">
            <h1 class="text-4xl font-bold">Panel de Empleado</h1>
            <div class="flex flex-row items-center p-4 justify-center gap-4 ">
                <input type="text" placeholder="Nombre" name="Nombre" class="p-2 border-black border-2 rounded-lg Producto Categoria">
                <select id="acciones" name="acciones" class="p-1 w-60 cursor-pointer border-black border-2 rounded-lg"
                    required>
                    <option value="" disabled selected>Que Desea Crear</option>
                    <option value="Producto">Producto</option>
                    <option value="Categoria">Categoria</option>
                </select>
            </div>
            <div id="productos" class="flex flex-col items-center justify-center gap-4 hidden">
                <div class="flex flex-row items-center gap-4">
                    <input type="text" placeholder="Precio" oninput="this.value = this.value.replace(/[a-zA-Z]/g, '')"
                        class="p-2 border-black border-2 rounded-lg appearance-none Producto">
                    <select class="p-1 w-60 cursor-pointer border-black border-2 rounded-lg Producto select">
                        <option value="Categoria" disabled selected>Categoria</option>
                        <option value="Categoria1">Categoria 1</option>
                        <option value="Categoria2">Categoria 2</option>
                        <option value="Categoria3">Categoria 3</option>
                    </select>
                </div>
                <div class="flex flex-row items-center gap-4">
                    <input type="text" placeholder="Marca" class="p-2 border-black border-2 rounded-lg Producto">
                    <input type="text" placeholder="cantidad" oninput="this.value = this.value.replace(/[a-zA-Z]/g, '')"
                        class="p-2 w-60 border-black border-2 rounded-lg appearance-none Producto">
                </div>
            </div>

            <!-- Categoria -->
            <div id="Categoria" class="flex flex-col items-center p-4 justify-center gap-5 hidden">
                <div class="flex flex-row items-center gap-4">
                    <textarea placeholder="Descripcion"
                        class="p-2 w-100 border-black border-2 rounded-lg resize-none Categoria"></textarea>
                </div>
            </div>


            <!-- Agregar imagen-->
            <div id="Imagen" class="flex flex-row p-2 items-center gap-4 hidden">
                <input type="file" accept="image/*" id="fileInput" class="hidden Producto Categoria">
                <input type="text" value="" class="hidden">
                <button onclick="document.getElementById('fileInput').click()" type="button"
                    class="cursor-pointer hover:scale-105 px-4 py-2 bg-blue-500 text-white rounded-lg">Subir
                    Imagen</button>
                <div id="preview" class="w-64 h-64 border-2 border-black rounded-lg flex items-center justify-center ">
                    <span class="cursor-default text-gray-500">Vista previa de la imagen</span>
                </div>
                <!-- Botones-->
                <div class="flex flex-col items-center gap-4">
                    <input id="Guardar"
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-green-500 text-white rounded-lg Action-B"
                        type="button" value="Guardar">
                    <input id="Buscar"
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-yellow-500 text-white rounded-lg Action-B"
                        type="button" value="Buscar">
                    <input
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-red-500 text-white rounded-lg Action-B"
                        type="button" value="Eliminar">
                    <input
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-blue-500 text-white rounded-lg Action-B"
                        type="button" value="Actualizar">
                </div>
            </div>

        </div>

        <!-- Modal-->
        <div id="modal" class="fixed inset-0 z-20 bg-black/75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg">
                <input id="M_Title" type="text" class="text-2xl font-bold mb-4" value="">
                <p id="M_content" class="mb-4"></p>
                <div class="flex flex-row items-center gap-4 text-white">
                    <input id="AceptModal" class="cursor-pointer hover:scale-105 px-4 py-2 bg-green-500 rounded-lg"
                        type="submit" name="Accion" value="Si">
                    <button type="button"
                        class="cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-red rounded-lg CloseModal">NO</button>
                </div>
            </div>
        </div>
    </form>

    <!--Campos vacios Modal-->
    <div id="modal3" class="fixed inset-0 z-20 bg-black/75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Campos Vacios</h2>
            <p class="mb-4">Por favor, complete todos los campos antes de guardar.</p>
            <button type="button"
                class="cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-white rounded-lg CloseModal">Cerrar</button>
        </div>
    </div>
</body>

<script>
    var accionesSelect = document.getElementById('acciones');
    var ImagenDiv = document.getElementById('Imagen');
    var productosDiv = document.getElementById('productos');
    var categoriaDiv = document.getElementById('Categoria');
    var Editar_crearSelect = document.getElementById('Editar_crear');
    var ResetElementos = document.querySelectorAll('.Productos, .Categoria');

    if (accionesSelect) { // Verifica si el elemento existe antes de agregar el event listener
        accionesSelect.addEventListener('change',
            function() { //El addEventListener se encarga de detectar el cambio en el select y ejecutar la función cada vez que se selecciona una opción diferente
                // Reinicia los campos de entrada cada vez que se cambia la selección
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

                ResetElementos.forEach(function(element) {
                    if (!element.classList.contains('select')) {
                        element.value = ''; // Limpia el valor de cada campo de entrada
                    }
                });

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

    //Si recarga pagina reiniciar select 
    window.onbeforeunload = function(e) {
        accionesSelect.selectedIndex = 0; // Reinicia el select al valor predeterminado
    };
</script>

<script src="js/General.js"></script>

</html>