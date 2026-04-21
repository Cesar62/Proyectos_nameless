<?php
//Intento de hacer global registro a base de datos para no escribir lo mismo varias veces

function registrar(array $datos, string $tablabd, array $campos, PDO $pdo): bool{

        //implode añade un texto despues de cada valor del array
    $columnas = implode(', ', $campos); //Esto resulta en campo1, campo2, campo3, etc 

    $placeholders = implode(', ', array_fill(0, count($campos), '?')); // esto da ?,?,?,?

    $sql = "INSERT INTO $tablabd ($columnas) VALUES ($placeholders)";

    $stm = $pdo->prepare($sql);

    if($stm->execute(array_values($datos))){ //le pasamos la informacion que vamos a ingresar en la base
       return true;
    } else {
        print_r($stm->errorInfo());
        return false;
    }
    
}

//funciones para consultas
function consultar(string $tablabd, array $campos, array $where, PDO $pdo): bool{
    return true;
}

//Esto va a servir para que el usuario no envie datos vacios en la base
function vacio(array $parametros): bool{
    

    foreach ($parametros as $parametro) {
        if (empty($parametro)) {
            return true; // Si encuentra un campo vacío, retorna true
        }
    }
    return false; // Si no encuentra campos vacíos, retorna false
}
?>