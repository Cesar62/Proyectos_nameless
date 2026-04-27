<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'Config/BD.php';
require 'Config/funciones.php';

session_start();

$Session_estado = $_SESSION["SESION_E"]["Sesion"] ?? false; //Se guarda el estado de inicio de sesion del empleado
$Empleado_Info = $_SESSION["SESION_E"]["Sesion_Info"] ?? [];   //Informacion del empleado
$modal = $_SESSION["modal"] ?? false;
$accion = $_SESSION["Accion"] ?? "";
$btn = $_POST['Accion'] ?? null;
$Acciones = $_POST['acciones'] ?? $_SESSION["Acciones"] ?? "";
$errors = [];
$categoria = [];
$buscar = false;

$sql = $pdo->prepare('SELECT Nombre FROM categoria'); //Selecionamos los datos de la tabla

if ($sql->execute()) {
    $categoria = $sql->fetchAll(PDO::FETCH_COLUMN); //Guardamos los datos de los campos del usuario y los guardamos en un array
} else {
    $errors[] = "Error al obtener las categorias";
}

if ($btn) {
    switch ($btn) {
        case 'Guardar': //Guardar en la bd
            if ($Acciones == "Producto") {
                $nombre = trim($_POST["Nombre"]) ?? "";
                $precio = trim($_POST["Precio"]) ?? "";
                $categoria = trim($_POST["Categoria"]) ?? "";
                $marca = trim($_POST["Marca"]) ?? "";
                $cantidad = trim($_POST["Cantidad"]) ?? "";
                $foto_ruta = "";
                $img = $_FILES['img'] ?? null;
                $ruta_destino = "";

                // obtener imagen
                if (!empty($img) && $img['error'] === UPLOAD_ERR_OK && is_uploaded_file($img['tmp_name'])) { // Verifica que se ha subido un archivo sin errores
                    $directorio = "uploads/"; // Declaración de la carpeta donde se almacenarán las imágenes

                    if (!is_dir($directorio)) {  //Si el directorio no existe se crea uno
                        mkdir($directorio, 0777, true);
                    }

                    $nombre_imagen = basename($img['name']); //USa el nombre original de la imagen
                    $ruta_destino = $directorio . uniqid() . "_" . $nombre_imagen; // se agrega el nombre de la carptea un id unico y el nombre de la imagen
                    $foto_ruta = $ruta_destino;
                } else {
                    $errorCode = $img['error'] ?? null;
                    $errors[] = "Debe subir una imagen. Error de carga: " . ($errorCode !== null ? $errorCode : 'archivo no enviado');
                }

                if (vacio([$nombre, $precio, $categoria, $marca, $cantidad, $foto_ruta])) {
                    $errors[] = "Campos incompletos";
                } else {
                    if (registrar([$nombre, $precio, $categoria, $marca, $cantidad, $foto_ruta], "productos", ["Nombre", "Precio", "Categoria", "Marca", "Cantidad", "IMG"], $pdo)) {
                        if (!move_uploaded_file($img['tmp_name'], $ruta_destino)) {
                            $errors[] = "Error al mover la imagen subida.";
                        }
                        $_SESSION["modal"] = true;
                        $_SESSION["Accion"] = $btn;
                        $_SESSION["Acciones"] = $Acciones;
                        header("Location: Empleado_tux.php");
                        exit();
                    } else {
                        $errors[] = "Error al registrar el producto en la base de datos.";
                    }
                }
            } elseif ($Acciones == "Categoria") {
                $nombre = trim($_POST["Nombre"]) ?? "";
                $descripcion = trim($_POST["Descripcion"]) ?? "";
                $foto_ruta = "";
                $img = $_FILES['img'] ?? null;
                $ruta_destino = "";

                // obtener imagen
                if (!empty($img) && $img['error'] === UPLOAD_ERR_OK && is_uploaded_file($img['tmp_name'])) { // Verifica que se ha subido un archivo sin errores
                    $directorio = "uploads/"; // Declaración de la carpeta donde se almacenarán las imágenes

                    if (!is_dir($directorio)) {  //Si el directorio no existe se crea uno
                        mkdir($directorio, 0777, true);
                    }

                    $nombre_imagen = basename($img['name']); //USa el nombre original de la imagen
                    $ruta_destino = $directorio . uniqid() . "_" . $nombre_imagen; // se agrega el nombre de la carptea un id unico y el nombre de la imagen
                    $foto_ruta = $ruta_destino;
                } else {
                    $errorCode = $img['error'] ?? null;
                    $errors[] = "Debe subir una imagen. Error de carga: " . ($errorCode !== null ? $errorCode : 'archivo no enviado');
                }

                if (vacio([$nombre, $descripcion, $foto_ruta])) {
                    $errors[] = "Campos incompletos";
                } else {
                    if (registrar([$nombre, $descripcion, $foto_ruta], "categoria", ["Nombre", "Descripcion", "IMG"], $pdo)) {
                        if (!move_uploaded_file($img['tmp_name'], $ruta_destino)) {
                            $errors[] = "Error al mover la imagen subida.";
                        }
                        $_SESSION["modal"] = true;
                        $_SESSION["Accion"] = $btn;
                        $_SESSION["Acciones"] = $Acciones;
                        header("Location: Empleado_tux.php");
                        exit();
                    } else {
                        $errors[] = "Error al registrar la categoría en la base de datos.";
                    }
                }
            } else {
                echo "Acción no reconocida para Guardar.";
            }
            break;
        case 'Buscar':
            if ($Acciones == "Producto") {
                // Aquí puedes agregar la lógica para manejar la acción de "Si" para productos
                echo "Has buscado el producto.";
            } elseif ($Acciones == "Categoria") {
                // Aquí puedes agregar la lógica para manejar la acción de "Si" para categorías
                echo "Has buscado la categoría.";
            } else {
                echo "Acción no reconocida para Buscar.";
            }
            break;

        case 'Eliminar':
            if ($Acciones == "Producto") {
                // Aquí puedes agregar la lógica para manejar la acción de "Si" para productos
                echo "Has Eliminado el producto.";
            } elseif ($Acciones == "Categoria") {
                // Aquí puedes agregar la lógica para manejar la acción de "Si" para categorías
                echo "Has Eliminado la categoría.";
            } else {
                echo "Acción no reconocida para Eliminar.";
            }
            break;
        case 'Actualizar':
            if ($Acciones == "Producto") {
                // Aquí puedes agregar la lógica para manejar la acción de "Si" para productos
                echo "Has Actualizado el producto.";
            } elseif ($Acciones == "Categoria") {
                // Aquí puedes agregar la lógica para manejar la acción de "Si" para categorías
                echo "Has Actualizado la categoría.";
            } else {
                echo "Acción no reconocida para Actualizar.";
            }
            break;
        default:
            echo "Acción no reconocida.";
    }
}

if ($modal) {
    echo "
            <div id=modal2 class='fixed inset-0 z-20 bg-black/75 flex items-center justify-center'>
                <div class='bg-white p-6 rounded-lg'>
                    <h2 class='text-2xl font-bold mb-4'>Resultado de la acción</h2>
                    <p class='mb-4'>$accion $Acciones con exito</p>
                    <button class='cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-white rounded-lg CloseModal'>Cerrar</button>
                </div>
            </div>
        ";
    $_SESSION["modal"] = false;
} else if (count($errors) > 0) {
    $errorMessages = implode("<br>", $errors);
    echo "
            <div id=modal2 class='fixed inset-0 z-20 bg-black/75 flex items-center justify-center'>
                <div class='bg-white p-6 rounded-lg'>
                    <h2 class='text-2xl font-bold mb-4'>Errores encontrados</h2>
                    <p class='mb-4'>$errorMessages</p>
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
            <div id="user_lg"
                class="w-10 h-10 hover:scale-110 bg-white rounded-full flex items-center justify-center cursor-pointer">
                <img src="imagenes/iconos/icono_persona.svg">
            </div>
        </div>
    </nav>

    <!--espacio de relleno-->
    <div class="h-16"></div>


    <!-- Menu del Empleado -->
    <form action="Empleado_tux.php" method="post" class="flex flex-col items-center mt-8" enctype="multipart/form-data">
        <div class="flex flex-col w-[75%] items-center p-8 border-black border-2 rounded-lg bg-gray-300">
            <h1 class="text-4xl font-bold">Panel de Empleado</h1>
            <div class="flex flex-row items-center p-4 justify-center gap-4 ">
                <input type="text" placeholder="Nombre" name="Nombre"
                    class="p-2 border-black border-2 rounded-lg Producto Categoria">
                <select id="acciones" name="acciones" class="p-1 w-60 cursor-pointer border-black border-2 rounded-lg"
                    required>
                    <option value="" disabled selected>Que Desea Crear</option>
                    <option value="Producto">Producto</option>
                    <option value="Categoria">Categoria</option>
                </select>
            </div>
            <div id="productos" class="flex flex-col items-center justify-center gap-4 hidden">
                <div class="flex flex-row items-center gap-4">
                    <input type="text" placeholder="Precio" name="Precio"
                        oninput="this.value = this.value.replace(/[a-zA-Z]/g, '')"
                        class="p-2 border-black border-2 rounded-lg appearance-none Producto">
                    <?php if (count($categoria) > 0): ?>
                    <select name="Categoria"
                        class="p-1 w-60 cursor-pointer border-black border-2 rounded-lg Producto select">
                        <?php foreach ($categoria as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <?php else: ?>
                    <select name="categoria"
                        class="p-1 w-60 cursor-pointer border-black/50 text-gray-500 border-2 rounded-lg Producto select"
                        disabled>
                        <option value="">No hay categorias disponibles</option>
                    </select>
                    <?php endif; ?>
                </div>
                <div class="flex flex-row items-center gap-4">
                    <input type="text" placeholder="Marca" name="Marca"
                        class="p-2 border-black border-2 rounded-lg Producto">
                    <input type="text" placeholder="cantidad" name="Cantidad"
                        oninput="this.value = this.value.replace(/[a-zA-Z]/g, '')"
                        class="p-2 w-60 border-black border-2 rounded-lg appearance-none Producto">
                </div>
            </div>

            <!-- Categoria -->
            <div id="Categoria" class="flex flex-col items-center p-4 justify-center gap-5 hidden">
                <div class="flex flex-row items-center gap-4">
                    <textarea placeholder="Descripcion" name="Descripcion"
                        class="p-2 w-100 border-black border-2 rounded-lg resize-none Categoria"></textarea>
                </div>
            </div>


            <!-- Agregar imagen-->
            <div id="Imagen" class="flex flex-row flex-wrap p-2 h-64 items-center gap-4 hidden">
                <input type="file" accept="image/*" name="img" id="fileInput" class="hidden Producto Categoria">
                <input type="text" value="" class="hidden">
                <button onclick="document.getElementById('fileInput').click()" type="button"
                    class="cursor-pointer hover:scale-105 px-4 py-2 bg-blue-500 text-white rounded-lg">Subir
                    Imagen</button>
                <div id="preview" onclick="document.getElementById('fileInput').click()"  class="cursor-pointer w-64 h-64 border-2 border-black rounded-lg flex items-center justify-center ">
                    <span class="cursor-pointer text-gray-500">Subir imagen</span>
                </div>
                <!-- Botones-->
                <div class="flex flex-col flex-wrap h-64 justify-center  gap-4">
                    <?php if (!$buscar): ?>
                    <input id="Guardar"
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-green-500 text-white rounded-lg Action-B"
                        type="button" value="Guardar">
                    <input id="Buscar"
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-yellow-500 text-white rounded-lg Action-B"
                        type="button" value="Buscar">
                    <?php else: ?>
                    <input
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-blue-500 text-white rounded-lg Action-B"
                        type="button" value="Actualizar">

                    <input
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-red-500 text-white rounded-lg Action-B"
                        type="button" value="Eliminar">
                    <?php endif; ?>
                    <input
                        class="cursor-pointer hover:scale-105 px-4 py-2 w-30 bg-orange-500 text-white rounded-lg Action-B"
                        type="button" value="Limpiar">

                </div>
            </div>

        </div>

        <!-- Modal-->
        <div id="modal" class="fixed inset-0 z-20 bg-black/75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg">
                <input id="M_Title" type="text" class="text-2xl font-bold mb-4" value="">
                <p id="M_content" class="mb-4"></p>
                <div class="flex flex-row items-center gap-4 text-white">
                    <input id="AceptModal" onclick="AceptModalButtonSubmit()"
                        class="cursor-pointer hover:scale-105 px-4 py-2 bg-green-500 rounded-lg" type="button"
                        name="Accion" value="Si">
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

    <!--informacion del empleado cerrar sesion-->
    <form action="Adm_M.php" method="post">
        <div id="modalInfo" class="fixed inset-x-0 top-15 z-20 flex justify-end hidden">
            <div class="flex flex-col p-2 bg-black/75 text-white text-lg items-center border border-white rounded-lg">
                <?php if ($Session_estado == true) {
                    echo "<p>" . $Empleado_Info['Nombre'] . " " . $Empleado_Info['Apellido'] . "</p>
                    
                        <p>" . $Empleado_Info['Cargo'] . "</p>
                    
                    ";
                } ?>
                <input name="btn" type="submit" value="cerrar sesion"
                    class="cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-white rounded-lg">
            </div>
        </div>
    </form>
</body>
<script>
var accionesSelect = document.getElementById('acciones');
var ImagenDiv = document.getElementById('Imagen');
var productosDiv = document.getElementById('productos');
var categoriaDiv = document.getElementById('Categoria');
var Editar_crearSelect = document.getElementById('Editar_crear');
var ResetElementos = document.querySelectorAll('.Producto, .Categoria');

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

            ResetElementos.forEach(element => {
                if (!element.classList.contains('select')) {
                    element.value = ''; // Limpia el valor de cada campo de entrada
                    preview.innerHTML = '<span class="text-gray-500">Subir Imagen</span>';
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
            preview.innerHTML = '<span class="text-gray-500">Subir Imagen</span>';
        }
    });
}

//Si recarga pagina reiniciar select 
window.onbeforeunload = function(e) {
    accionesSelect.selectedIndex = 0; // Reinicia el select al valor predeterminado
};

var AceptModalButton = document.getElementById("AceptModal");

function AceptModalButtonSubmit() {
    var AceptModalButton = document.getElementById("AceptModal");
    AceptModalButton.type = "submit"; // Cambia el tipo del botón a submit para enviar el formulario
    AceptModalButton.click();
}
</script>
<script src="js/General.js"></script>

</html>