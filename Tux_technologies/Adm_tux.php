<?php
require 'Config/BD.php';
require 'Config/funciones.php';

session_start();

$Session_estado = $_SESSION["SESION_E"]["Sesion"] ?? false; //Se guarda el estado de inicio de sesion del empleado
$Empleado_Info = $_SESSION["SESION_E"]["Sesion_Info"] ?? [];   //Informacion del empleado
$modal = $_SESSION["modal"] ?? false;
$errors = [];
$accion = $_SESSION["Accion"] ?? "";
$Acciones = $_POST['acciones'] ?? "Error";
if (!empty($_POST)) { //si llega a fallar el metod post no va a hacer nada
    $btn = isset($_POST["btn"]) ? trim($_POST["btn"]) : "";

    switch ($btn) {
        case 'Registrar': //Registrar los empleados en la bd
            $nombre = trim($_POST["Nombre"]);
            $apellido = trim($_POST["apellido"]);
            $correo = trim($_POST["correo"]);
            $cargo = trim($_POST["cargo"]);
            $contra = trim($_POST["contraseña"]);
            $contraSecret = password_hash($contra,  PASSWORD_BCRYPT, ['cost' => 12]);  //cost retrasa el proceso lo que evita hackeos en lso que va probando un monton de contraseñas

            if (registrar([$nombre, $apellido, $correo, $contraSecret, $cargo], "Empleado", ["Nombre", "Apellido", "Correo", "Contraseña", "Cargo"], $pdo)) {
                $_SESSION["modal"] = true;
                $_SESSION["Accion"] = $btn;
                header("Location: Adm_tux.php");
                exit();
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
    <title>Admin_tux</title>
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
            <a href="Adm_M.php"
                class="hover:text-gray-600 hover:bg-white rounded-lg p-2 md:visible invisible md:inline-block hidden">Menu</a>
            <div id="user_lg"
                class="w-10 h-10 hover:scale-110 bg-white rounded-full flex items-center justify-center cursor-pointer">
                <img src="imagenes/iconos/icono_persona.svg">
            </div>
        </div>
    </nav>

    <!--espacio de relleno-->
    <div class="h-16"></div>

    <!--Panel del admin-->
    <div class="flex flex-col items-center mt-8">
        <div class="flex flex-col w-[75%] gap-2 items-center p-8 border-black border-2 rounded-lg bg-gray-300">
            <h1 class="text-4xl font-bold">Panel de Administración</h1>
            <div class="flex flex-row w-[100%] gap-2">
                <input type="button" value="Registrar Empleados"
                    class="p-1 border border-black rounded-lg cursor-pointer hover:scale-105 SButton">
                <input type="button" value="Lista de Empleados"
                    class="p-1 border border-black rounded-lg cursor-pointer hover:scale-105 SButton">
            </div>
            <form action="Adm_tux.php" method="post" class="flex flex-col w-[100%] gap-2 items-center">
                <h2  class="text-xl font-bold">Registrar Nuevo Empleado</h2>
                <input id="accionesSelect" name="acciones" type="text" class="hidden" value="RegistrarEmpleados">
                <div class="flex flex-row gap-2">
                    <input type="text" placeholder="Nombre" name="Nombre"
                        class="p-2 border-black border-2 rounded-lg RegistrarEmpleados">
                    <input type="text" placeholder="Apellido" name="apellido"
                        class="p-2 border-black border-2 rounded-lg RegistrarEmpleados">
                </div>
                <div class="flex flex-row gap-2">
                    <input type="text" placeholder="Correo" name="correo"
                        class="p-2 border-black border-2 rounded-lg RegistrarEmpleados">
                    <input type="text" placeholder="Contraseña" name="contraseña"
                        class="p-2 border-black border-2 rounded-lg RegistrarEmpleados">
                </div>
                <div class="flex flex-row gap-2">
                    <select name="cargo" class="p-1 w-30 cursor-pointer border-black border-2 rounded-lg select">
                        <option value="Categoria" disabled selected>Cargo</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Empleado">Empleado</option>
                    </select>
                    <input type="button" value="Registrar" class="cursor-pointer hover:scale-105 p-2 w-30 bg-green-500 text-white rounded-lg border-2 border-black  hover:scale-105 Action-B">
                </div>
                <!-- Modal-->
                <div id="modal" class="fixed inset-0 z-20 bg-black/75 flex items-center justify-center hidden">
                    <div class="bg-white p-6 rounded-lg">
                        <input id="M_Title" type="text" disabled class="text-2xl font-bold mb-4" value="">
                        <p id="M_content" class="mb-4"></p>
                        <div class="flex flex-row items-center gap-4 text-white">
                            <input id="AceptModal"
                                class="cursor-pointer hover:scale-105 px-4 py-2 bg-green-500 rounded-lg" type="submit"
                                name="btn" value="Registrar">
                            <button type="button"
                                class="cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-red rounded-lg CloseModal">NO</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--Campos vacios Modal-->
        <div id="modal3" class="fixed inset-0 z-20 bg-black/75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-4">Campos Vacios</h2>
                <p class="mb-4">Por favor, complete todos los campos antes de guardar.</p>
                <button type="button"
                    class="cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-white rounded-lg CloseModal">Cerrar</button>
            </div>
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
    var SButton = document.querySelectorAll(".SButton");
    var accionesSelect = document.getElementById("accionesSelect");

    SButton.forEach(function(SBvalue) {
        SBvalue.addEventListener("click", function() {
            accionesSelect.value = SBvalue.value.replace(/\s+/g, '');
        });
    });
</script>
<script src="js/General.js"></script>

</html>