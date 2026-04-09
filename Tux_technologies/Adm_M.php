<?php
require 'Config/BD.php';

session_start();

$SesionA = $_SESSION["ADSESION"]["Sesion"] ?? false;

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
            <div
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
                <a href="Adm_tux.php"
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
            </div>
        </div>
    </div>

    <?php if($SesionA == false): ?>

    <!--Login-->
    <div id=modal class='fixed inset-0 z-20 bg-black/75 flex items-center justify-center'>
        <div class='flex flex-col gap-4 justify-center bg-black p-6 rounded-lg text-white border-white border'>
            <h2 class='text-2xl font-bold mb-2'>Iniciar Sesion</h2>
            <input type="email" id="email" pattern=".+@example\.com" placeholder="Ingresar Correo"
                class="p-2 border-2 border-white rounded-lg">
            <div class="flex flex-row items-center justify-end">
                <input id="Ipass" type="password" placeholder="ingrese contraseña"
                    class="p-2 border-2 border-white rounded-lg">
                <button id="btnp" class="absolute bg-white m-2 rounded-lg cursor-pointer hover:scale-110" onclick="contraseña()"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 fill-black">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            <button class="bg-white p-2 rounded-lg hover:scale-105 cursor-pointer text-black font-bold transition delay-50 duration-200 ">Iniciar Sesion</button>
        </div>
    </div>
    <?php endif?>
</body>
<script src="js/General.js"></script>
<script>

    //cambiar visibilidad de la contraseña
var btnp = document.getElementById("btnp");
var Ipass = document.getElementById("Ipass");

function contraseña() {
    if (Ipass.type == "password") {
        Ipass.type = "text"
    } else {
        Ipass.type = "password"
    }
}
</script>
</html>