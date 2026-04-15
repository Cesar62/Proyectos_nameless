<?php
require 'Config/BD.php';

session_start();

$Session_estado = $_SESSION["SESION_E"]["Sesion"] ?? false; //Se guarda el estado de inicio de sesion del empleado
$Empleado_Info = $_SESSION["SESION_E"]["Sesion_Info"] ?? [];   //Informacion del empleado
$Login_Fallo = false;  //para cuando no se valide la informacion al loguearse
$Mensaje = ""; //global para mostrar mensajes cuando sea necesario

if (!empty($_POST)) { //si llega a fallar el metod post no va a hacer nada
    $btn = isset($_POST["btn"]) ? trim($_POST["btn"]) : "";

    if ($btn === "Iniciar Sesion") { //funciones para login
        $correo = trim($_POST["email"]);
        $contra = trim($_POST["password"]);

        $sql = $pdo->prepare('SELECT * FROM Empleado WHERE Correo = :email'); //Selecionamos los datos de la tabla
        $sql->bindParam(":email", $correo, PDO::PARAM_STR); //Verificamos el usuario en la tabla
        $sql->execute();
        $login = $sql->fetch(PDO::FETCH_ASSOC); //Guardamos los datos de los campos del usuario y los guardamos en un array

        if ($login) {
            if (password_verify($contra, $login["Contraseña"])) { // en password verify se pasa primero la contraseña que escribe el usuario luego se pasa la de la base de datos
                $_SESSION["SESION_E"] = [
                    "Sesion" => true,
                    "Sesion_Info" => $login
                ];

                $Empleado_Info = $login; // actualizar información del empleado en esta carga
                $Session_estado = true;
            } else {
                $Login_Fallo = true;
                $Mensaje = "Contraseña Incorrecta";
            }
        } else {
            $Login_Fallo = true;
            $Mensaje = "Correo no encontrado";
        }
    }

    if ($btn === "cerrar sesion") {
        session_destroy();
        $_SESSION = [];
        $Session_estado = false;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/rostro_tux_T.png">
    <link rel="stylesheet" href="../src/output.css">
    <base href="/Proyectos_nameless/Tux_technologies/">
    <title>Adm_Menu</title>
</head>

<body class="bg-slate-900">
    <!-- Navbar -->
    <nav class="flex flex-row z-10 fixed bg-black p-2 w-full text-white font-bold text-xl">
        <div class=" flex basis-full  justify-start">
            <img src="imagenes/Logo_tux_technologies.jpeg" alt="Tux Technologies logo" class="ml-20 inline-30">
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

    <!-- espacio de relleno -->
    <div class="h-16"></div>

    <!-- Seleccion de opciones -->
    <div class="flex flex-col items-center mt-8">
        <div class="flex flex-col w-[75%] items-center p-8 border-black border-2 rounded-lg bg-gray-300">
            <h1 class="text-2xl font-bold mb-4">Menú</h1>
            <div class="flex flex-row flex-wrap justify-content-center gap-8">
                <a href="Empleado_tux.php"
                    class="px-3 py-3 size-30 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 overflow-hidden">
                    <div class="flex flex-col items-center justify-center gap-2 h-full overflow-y-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-10 h-10 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p class="text-center text-sm break-words">Productos Y Categorías</p>
                    </div>
                </a>
                <a href="Adm_tux.php"
                    class="px-3 py-3 size-30 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 overflow-hidden">
                    <div class="flex flex-col items-center justify-center gap-2 h-full overflow-y-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-10 h-10 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>

                        <p class="text-center text-sm break-words">Administración</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <?php if ($Session_estado == false): ?>

    <!--Login-->
    <form id="lmodal" action="Adm_M.php" method="post"
        class='fixed inset-0 z-20 bg-black/75 flex items-center justify-center'>
        <div class='flex flex-col gap-4 justify-center bg-black p-6 rounded-lg text-white border-white border'>
            <?php if($Login_Fallo == true){ echo "<div class='text-white text-xs p-2 rounded-lg bg-red-600 border border-white'><p> $Mensaje </p></div>"; }?>
            <h2 class='text-2xl font-bold mb-2'>Iniciar Sesion</h2>
            <input type="email" id="email" name="email" pattern=".+@gmail\.com" placeholder="Ingresar Correo"
                class="p-2 border-2 border-white rounded-lg login">
            <div class="flex flex-row items-center justify-end">
                <input id="Ipass" type="password" name="password" placeholder="ingrese contraseña"
                    class="p-2 border-2 border-white rounded-lg login">
                <button id="btnp" type="button" class="absolute bg-white m-2 rounded-lg cursor-pointer hover:scale-110"
                    onclick="contraseña()"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6 fill-black">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            <input id="Lbtn" type="button" value="Iniciar Sesion" name="btn"
                class="bg-white p-2 rounded-lg hover:scale-105 cursor-pointer text-black font-bold transition delay-50 duration-200 ">
        </div>
    </form>
    <?php endif ?>

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
                <?php if($Session_estado == true){
                    echo "<p>" . $Empleado_Info['Nombre'] . " " . $Empleado_Info['Apellido'] . "</p>
                    
                        <p>" . $Empleado_Info['Cargo'] . "</p>
                    
                    ";
                }?>
                <input name="btn" type="submit" value="cerrar sesion"
                    class="cursor-pointer hover:scale-105 px-4 py-2 bg-red-500 text-white rounded-lg">
            </div>
        </div>
    </form>
</body>
<script>
//cambiar visibilidad de la contraseña
var btnp = document.getElementById("btnp");
var Ipass = document.getElementById("Ipass");
var lmodal = document.getElementById("lmodal");


function contraseña() {
    if (Ipass.type == "password") {
        Ipass.type = "text"
    } else {
        Ipass.type = "password"
    }
}

//validacio de inputs vacios
var Lbtn = document.getElementById("Lbtn");
var input_login = document.querySelectorAll(".login");
Lbtn.addEventListener("click", function() {
    var vacio = false;

    for (const elemento of input_login) {
        if (elemento.value.trim() === "") {
            Modal3.classList.remove("hidden"); // Muestra el modal de campos vacíos
            vacio = true;
            break;
        }
    }

    if (!vacio) {
        Lbtn.type = "submit";
        Lbtn.click();
    }
});

<?php if ($Session_estado == true): ?>
lmodal.classList.add("hidden");
<?php endif ?>
</script>

<script src="js/General.js"></script>

</html>