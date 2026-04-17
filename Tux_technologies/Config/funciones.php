<?php
//Intento de hacer global registro a base de datos para no escribir lo mismo varias veces

function registrar(array $datos, string $tablabd, array $campos, PDO $pdo){

        //implode añade un texto despues de cada valor del array
    $columnas = implode(', ', $campos); //Esto resulta en campo1, campo2, campo3, etc 

    $placeholders = implode(', ', array_fill(0, count($campos), '?')); // esto da ?,?,?,?

    $sql = "INSERT INTO $tablabd ($columnas) VALUES ($placeholders)";

    echo $sql;

    /*
    $stm = $pdo->prepare($sql);

    if($stm->execute(array_values($datos))){ //le pasamos la informacion que vamos a ingresar en la base
       return true;
    } else {
        print_r($stm->errorInfo());
    }
    */
}

//Esto va a servir para que el usuario no envie datos vacios en la base
function vacio(array $parametros){
     foreach($parametros as $parametro){ //foreach Recorre todos los elementos del array
       if(strlen(trim($parametro)) < 1){ //Strlen cuenta el tamaño del texto 
        return true; //Si no hay texto retornamos verdadero
     }
    } 
    return false;
}

?>